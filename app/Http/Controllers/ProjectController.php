<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // 등록된 프로젝트 조회
    public function index() {
        $projects = Project::all();

        foreach($projects as $project) {
            $project['thumb'] = self::get_img($project['thumb']);
        }

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
            'thumb' => 'required|image',
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

        $project = Project::create([
            'title' => $request->input('title'),
            'type' => $request->input('type'),
            'position' => $request->input('position'),
            'thumb' => 0,
            'content' => $request->input('content'),
            'project_start_date' => $request->input('project_start_date'),
            'project_end_date' => $request->input('project_end_date'),
            'project_link' => $request->input('project_link'),
        ]);

        $img_title = $project->title;

        $project->update([
            'thumb' => self::set_img($request->file('thumb'), $img_title, 'project')
        ]);

        return self::response_json("프로젝트 등록에 성공하였습니다.", 201, $project);
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

        // 기존 이미지 삭제
        Storage::delete($project_id->thumb);

        $img_title = $request->input('title');
        $requestData = $request->all();
        $requestData['thumb'] = self::set_img($request->file('thumb'), $img_title, 'project');

        $project_id->update($requestData);

        return self::response_json("프로젝트 수정에 성공하였습니다.", 200);
    }

    // 프로젝트 삭제
    public function delete(Project $project_id) {

        $project_id->delete();

        return self::response_json("프로젝트 삭제에 성공하였습니다.", 200);
    }
}
