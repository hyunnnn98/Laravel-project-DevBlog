<?php

namespace App\Http\Controllers;

use App\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // 등록된 기술스택 조회
    public function index() {
        $projects = Skill::all();

        return self::response_json("프로젝트 조회에 성공하였습니다", 200, $projects);
    }

    // 기술스택 생성
    public function store() {
        $rules = [
            'title' => 'required|string|unique:sections,sect_name',
            'thumb' => 'required|date',
        ];
    }

    // 기술스택 수정
    public function update() {

    }

    // 기술스택 삭제
    public function delete() {
        
    }
}
