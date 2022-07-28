<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\QuestionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// All Resource form Question
Route::resource('/question', QuestionController::class);
// Get Questions from Moodle
Route::get('/questions', [QuestionController::class, 'questions'])->name('question.moodle');

// All Resource form Answe
Route::resource('/answer', AnswerController::class);
// Get Answer by Question From Moodle
Route::get('/answers', [AnswerController::class, 'answers'])->name('answer.moodle');
// Checking Answer by Question From Moodle
Route::get('/checking', [AnswerController::class, 'checking'])->name('answer.checking');

// All Resource form Grade
Route::resource('/grade', GradeController::class);
// Post Grade to Moodle Database
Route::post('/grading', [QuestionController::class, 'grading'])->name('grade.moodle');