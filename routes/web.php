<?php

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

Route::get('/', 'HomeController@index')->name('home');

// Social Auth
Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

// Quizzes
Route::resource('quizzes', 'QuizController')->except(['show']);
Route::post('quizzes/image/upload', 'QuizController@uploadImage')->name('quizzes.image.upload');
Route::delete('quizzes/image/{quizImage}', 'QuizController@destroyImage')->name('quizzes.image.destroy');

// Load random quizzes
Route::get('quizzes/random', 'QuizController@random')->name('quizzes.random');

// View Quiz
Route::get('quiz/{slug}', 'QuizController@show')->name('quiz.show');
// View Quiz
Route::post('quiz/{slug}', 'QuizController@doQuiz')->name('quiz.do-quiz');
// Quiz result
Route::get('quiz/{slug}/{id}', 'QuizController@quizResult')->name('quiz.result');
