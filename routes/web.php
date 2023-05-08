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

Route::get('/', function () {
    return view('login');
})->name('login');


Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('checklists','ChecklistController');
    Route::get('/getChecklists', 'ChecklistController@getChecklists');
    Route::post('getChartInfo','ChecklistController@getChartInfo');
    Route::resource('tasks','TaskController');
    Route::get('index/{checklist_id}', 'TaskController@index');
    Route::post('getTasks','TaskController@getTasks');
    Route::post('getUncompletedTasks','TaskController@getUncompletedTasks');
    Route::post('endTask','TaskController@endTask');
    Route::post('activateTask','TaskController@activateTask');

});

Route::resource('ajaxproducts','ProductAjaxController');

