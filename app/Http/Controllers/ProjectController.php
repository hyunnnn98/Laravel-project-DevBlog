<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // 등록된 프로젝트 조회
    public function index() {
        $projects = Project::all();

        return self::response_json("프로젝트 조회에 성공하였습니다.", 200, $projects);
    }

    /**
    *   table->id();
    *   table->string('title');
    *   table->string('type');
    *   table->string('position');
    *   table->string('thumb');
    *   table->string('content');
    *   table->dateTime('project_start_date');
    *   table->dateTime('project_end_date');
    *   table->string('project_link')->nullable();
    *   table->timestamps();
     */

    // 프로젝트 생성
    public function store(Request $request) {
        $rules = [
            'title' => 'required|string',
            'type' => 'required|string',
            'position' => 'required|string',
            'thumb' => 'required|string',
            'content' => 'required|string',
            'project_start_date' => 'required|date',
            'project_end_date' => 'required|date',
            'project_link' => 'required|string',
        ];

        $validated_result = self::request_validator(
            $request, $rules, '프로젝트 등록에 실패했습니다.'
        );

        if (is_object($validated_result)) {
            return $validated_result;
        }

        //TODO 사진 저장 로직넣기

        $created_project = Project::create($request);

        return self::response_json("프로젝트 생성에 성공하였습니다.", 201, $created_project);
    }

    // 프로젝트 수정
    public function update(Request $request, Project $project_id) {
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
            $request, $rules, '프로젝트 수정에 실패했습니다.'
        );

        if (is_object($validated_result)) {
            return $validated_result;
        }

        $project_id->update($request);

        return self::response_json("프로젝트 수정에 성공하였습니다.", 200);
    }

    // 프로젝트 삭제
    public function delete(Project $project_id) {

        $project_id->delete();

        return self::response_json("프로젝트 삭제에 성공하였습니다.", 200);
    }
}
