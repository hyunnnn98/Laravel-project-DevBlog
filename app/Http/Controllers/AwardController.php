<?php

namespace App\Http\Controllers;

use App\Award;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    // 등록된 수상경력 조회
    public function index() {
        $data;
        $data['onCampus'] = Award::where('type', 'onCampus')->get();
        $data['outCampus'] = Award::where('type', 'outCampus')->get();
        return self::response_json("수상경력 조회에 성공하였습니다.", 200, $data);
    }

    /**
      *     $table->id();
      *     $table->string('title');
      *     $table->string('award')->nullable();
      *     $table->dateTime('award_at');
      *     $table->timestamps();
     */

    // 수상경력 생성
    public function store(Request $request) {
        $rules = [
            'type' => 'required|string',
            'title' => 'required|string',
            'award_at' => 'required|date',
        ];

        $validated_result = self::request_validator(
            $request, $rules, '수상경력 등록에 실패했습니다.'
        );

        if (is_object($validated_result)) {
            return $validated_result;
        }

        $created_award = Award::create([
            'type' => $request->input('type'),
            'title' => $request->input('title'),
            'award' => $request->input('award'),
            'award_at' => $request->input('award_at'),
        ]);

        return self::response_json("수상경력 생성에 성공하였습니다.", 201, $created_award);
    }

    // 수상경력 수정
    public function update(Request $request, Award $award_id) {
        $rules = [
            'title' => 'required|string',
            'type' => 'required|string',
            'position' => 'required|string',
            'content' => 'required|string',
            'project_start_date' => 'required|date',
            'project_end_date' => 'required|date',
            'project_link' => 'required|string',
        ];

        $validated_result = self::request_validator(
            $request, $rules, '수상경력 수정에 실패했습니다.'
        );

        if (is_object($validated_result)) {
            return $validated_result;
        }

        $award_id->update($request);

        return self::response_json("수상경력 수정에 성공하였습니다.", 200);
    }

    // 프로젝트 삭제
    public function delete(Award $award_id) {

        $award_id->delete();

        return self::response_json("수상경력 삭제에 성공하였습니다.", 200);
    }
}
