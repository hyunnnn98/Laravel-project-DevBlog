<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //TODO 각각 모델 생성후 간단한 CRUD 등록
        //TODO 미들웨어 등록 후 로그인 연결
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->string('position');
            $table->string('thumb');
            $table->string('content');
            $table->dateTime('project_start_date');
            $table->dateTime('project_end_date');
            $table->string('project_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
