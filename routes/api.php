<?php

use Illuminate\Http\Request;

Route::prefix('quiz')->group(function(){
    Route::get('/categories', 'QuizController@getCategories');
    Route::get('/categories/{id}/questions', 'QuizController@getQuestionsByCategory');
});
