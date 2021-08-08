<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
//---------------------------------------------------------------

//Uncomment here to see the memory game blade
//Route::view('/', 'components.exercises.memory-game');
//Route::view('/', 'pages.student-side.index');
//--------------------------------------------------------------
Route::get('/roles', 'PermissionController@Permission');
Route::group(['middleware'=>'auth'],function() {

    Route::prefix('/')->group(function () {
        Route::get('', 'HomeController@index');
        Route::get('change-password', 'ChangePasswordController@index');
        Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
    });

    Route::group(['middleware'=>'role:teacher'],function() {

        Route::prefix('/students')->group(function () {
            Route::get('/search/', 'StudentController@query');
            Route::get('', 'StudentController@index');
            Route::get('create', 'StudentController@create');
            Route::post('', 'StudentController@store');
            Route::post('destroy-all', 'StudentController@destroyAll');
            Route::get('{student}/edit', 'StudentController@edit');
            Route::put('{student}', 'StudentController@update');
            Route::delete('{student}', 'StudentController@destroy');
            Route::get('{student}', 'StudentController@show');
        });

        Route::prefix('teacher-side')->group(function () {
            Route::get('teachers-list', 'TeacherController@teachersList');
            Route::get('create', 'TeacherController@create');
            Route::get('/search/', 'TeacherController@query');
            Route::get('', 'TeacherController@index');
            Route::post('', 'TeacherController@store');
            Route::post('destroy-all', 'TeacherController@destroyAll');
            Route::get('{teacher}/edit', 'TeacherController@edit');
            Route::put('{teacher}', 'TeacherController@update');
            Route::delete('{teacher}', 'TeacherController@destroy');
            Route::get('{teacher}', 'TeacherController@show');
        });

        Route::prefix('classes')->group(function () {
            Route::get('/search/', 'GroupController@query');
            Route::get('', 'GroupController@index');
            Route::get('/import-excel', 'GroupController@indexImport');
            Route::post('/import-excel/import', 'GroupController@import');
            Route::get('create', 'GroupController@create');
            Route::post('', 'GroupController@store');
            Route::post('destroy-all', 'GroupController@destroyAll');
            Route::get('{group}/edit', 'GroupController@edit');
            Route::put('{group}', 'GroupController@update');
            Route::delete('{group}', 'GroupController@destroy');
            Route::get('{group}', 'GroupController@show');
        });

        Route::prefix('exercises')->group(function () {
            Route::get('', 'ExerciseController@index');
            Route::get('create', 'ExerciseController@create');

            Route::get('/memory-game/{subject}', 'MemoryGameController@create');
            Route::post('/memory-game', 'MemoryGameController@store');


            Route::get('/drag-and-drop/{subject}', 'DragDropController@create');
            Route::post('/drag-and-drop', 'DragDropController@store');

            Route::get('/flashcard-with-images/{subject}', 'FlashcardImageController@create');
            Route::get('/flashcard/{exercise}', 'FlashcardImageController@edit');


            //Json Responses
            Route::post('/flashcard', 'FlashcardImageController@store');
            Route::delete('drag-and-drop/{id}', 'DragDropController@destroy');
            Route::delete('memory-game/{id}', 'MemoryGameController@destroy');
            Route::delete('flashcard-with-images/{id}', 'FlashcardImageController@destroy');
            Route::get('/exercise', 'ExerciseController@exerciseJson');
            Route::get('/subject', 'ExerciseController@subjectJson');
            Route::get('/type', 'ExerciseController@typeJson');
        });

        Route::prefix('exam')->group(function () {
            Route::get('/create', 'ExamController@create');
            Route::get('/list', 'ExamController@listExams');
            Route::post('', 'ExamController@store');
            Route::delete('/{exam}', 'ExamController@destroy');
        });

        Route::prefix('images')->group(function () {
            Route::get('', 'HomeController@images');
        });

        Route::prefix('axios')->group(function () {
            Route::get('/getDnd', 'StudentSideController@getDND');
            Route::get('/getTeacher', 'TeacherController@getTeacher');
            Route::get('/studentCount', 'StudentController@countStudents');
            Route::get('/classCount', 'GroupController@countClasses');
            Route::get('/examCount', 'ExamController@countExams');
            Route::get('/exerciseCount', 'ExerciseController@countExercises');
            Route::get('/exams', 'ExamController@index');
            Route::get('/exams/exercises/{id}', 'ExamController@getExamsExercises');
        });
    });

    Route::group(['middleware'=>'role:student'],function() {
        Route::prefix('student-side')->group(function () {
            Route::get('', 'StudentSideController@index');
            Route::get('{subject}', 'StudentSideController@selectType');
            Route::get('{subject}/drag-and-drop', 'StudentSideController@showDnd');
            Route::get('{subject}/{type}', 'StudentSideController@listExercise');
        });
        Route::prefix('axios')->group(function () {
            Route::get('/getTeacher', 'TeacherController@getTeacher');
            Route::get('/exams', 'ExamController@index');
        });
        Route::prefix('exercises')->group(function () {
            Route::get('/memory-game/solve/{exercise}', 'MemoryGameController@solve');
            Route::get('/flashcard-with-images/solve/{exercise}', 'FlashcardImageController@solve');
            Route::get('/drag-and-drop/solve/{exercise}', 'DragDropController@solve');
            Route::get('getDndById/{id}', 'DragDropController@getDndById');
        });
    });
});
