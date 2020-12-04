<?php

namespace App\Http\Controllers;

use App\Award;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    // 등록된 수상경력 조회
    public function index() {
        $awards = Award::all();

        return self::response_json("수상경력 조회에 성공하였습니다", 200, $awards);
    }

    // 수상경력 생성
    public function store() {
        $rules = [
            'sect_name' => 'required|string|unique:sections,sect_name',
            'sect_start_date' => 'required|date',
            'sect_end_date' => 'required|date|after_or_equal:sect_start_date',
        ];
    }

    // 수상경력 수정
    public function update() {

    }

    // 수상경력 삭제
    public function delete() {
        
    }
}
