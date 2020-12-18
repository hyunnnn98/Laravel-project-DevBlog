<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 게시글 조회
    public function index() {
        // TODO 페이지네이션 추가
        $posts = Post::all();

        return self::response_json("게시글 조회에 성공하였습니다", 200, $posts);
    }
    // 게시글 생성
    public function store(Request $request) {
        $rules = [
            'category' => 'required|integer|distinct|min:0|max:999',
            'title' => 'required|string',
            'content' => 'required|string',
        ];

        $validated_result = self::request_validator(
            $request, $rules, '게시글 등록에 실패했습니다.'
        );

        if (is_object($validated_result)) {
            return $validated_result;
        }

        $created_post = Post::create($request->all());

        return self::response_json("게시글 생성에 성공하였습니다.", 201, $created_post);
    }
}
