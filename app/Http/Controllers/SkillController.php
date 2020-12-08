<?php

namespace App\Http\Controllers;

use App\Skill;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // 등록된 기술스택 조회
    public function index() {
        $skills = Skill::all();

        foreach($skills as $skill) {
            $skill['thumb'] = self::get_img($skill['thumb']);
        }

        return self::response_json("기술스택 조회에 성공하였습니다", 200, $skills);
    }

    // 기술스택 생성
    public function store(Request $request) {
        $rules = [
            'title' => 'required|string|unique:skills,title',
            'thumb' => 'required|image',
        ];

        $validated_result = self::request_validator(
            $request, $rules, '기술스택 등록에 실패했습니다.'
        );

        if (is_object($validated_result)) {
            return $validated_result;
        }

        // <<-- 기술스택 작성
        $skill = Skill::create([
            'title' => $request->input('title'),
            'thumb' => 0,
        ]);
        // -->>

        $skill->update([
            'thumb' => self::set_img($request->file('thumb'), $skill->title, 'skill')
        ]);

        return self::response_json("기술스택 등록에 성공하였습니다", 201);
    }

    // 기술스택 수정
    public function update(Request $request, Skill $skill_id) {
        $rules = [
            'title' => 'required|string',
            'thumb' => 'required|image',
        ];

        $validated_result = self::request_validator(
            $request, $rules, '기술스택 변경에 실패했습니다.'
        );

        if (is_object($validated_result)) {
            return $validated_result;
        }

        // 기존 이미지 삭제
        Storage::delete($skill_id->thumb);

        // 기술스택 수정
        // TODO 모델로 빼기
        $skill_id->update([
            'title' => $request->input('title'),
            'thumb' => self::set_img($request->file('thumb'), $skill_id->title, 'skill')
        ]);

        return self::response_json("기술스택 변경에 성공하였습니다", 201);
    }

    // 기술스택 삭제
    public function delete(Skill $skill_id) {
        $skill_id->delete();

        return self::response_json("기술스택 삭제에 성공하였습니다.", 200);
    }
}
