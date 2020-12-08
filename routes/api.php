<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::middleware('auth:api')->group(function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

// award :: route
Route::prefix('/award')->group(function () {
    Route::get('/', 'AwardController@index');
    Route::post('/', 'AwardController@store');
    Route::patch('/update/{award_id}', 'AwardController@update');
    Route::delete('{award_id}', 'AwardController@delete');
});

// project :: route
Route::prefix('/project')->group(function () {
    Route::get('/', 'ProjectController@index');
    Route::post('/', 'ProjectController@store');
    Route::post('/update/{project_id}', 'ProjectController@update');
    Route::delete('{project_id}', 'ProjectController@delete');
});

// skill :: route
Route::prefix('/skill')->group(function () {
    Route::get('/', 'SkillController@index');
    Route::post('/', 'SkillController@store');
    Route::post('/update/{skill_id}', 'SkillController@update');
    Route::delete('{skill_id}', 'SkillController@delete');
});