<?php
namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ];

        $validated_result = self::request_validator(
            $request,
            $rules,
            '회원가입에 실패하였습니다.'
        );

        if (is_object($validated_result)) {
            return $validated_result;
        }

        $now = date('Y-m-d H:i:s');

        $user = new User([
            'email' => $request->email,
        	'name' => $request->name,
            'password' => bcrypt($request->password),
        	'simple_intro' => $request->simple_intro,
        	'profile_intro' => $request->profile_intro,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        $user->save();

        return self::response_json('회원가입에 성공하였습니다.', 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string'
        ];

        $validated_result = self::request_validator(
            $request,
            $rules,
            '입력 형식을 확인해주세요.'
        );

        if (is_object($validated_result)) {
            return $validated_result;
        }

        return $this->createToken($request->email, $request->password);
       
    }
    
    public function createToken ($userId, $password) {
        $credentials = array(
            'email' => $userId,
            'password' => $password
        );

        if (!Auth::attempt($credentials)) {
            return self::response_json_error("로그인에 실패하였습니다");
        }

        //TODO client_secret는 주기적으로 바꿔야하는것인가?
        $data = [
            'grant_type' => 'password',
            'client_id' => '2',
            'client_secret' => '3rN7v11Hr0vqvT1QxyjN8r0xVb1Im3RfLWBkBslu',
            'username' => Auth::user()['id'],
            'password' => $password,
            'scope' => '*',
        ];

        $request = Request::create('/oauth/token', 'POST', $data);
        $response = app()->handle($request);

        return $response;
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}