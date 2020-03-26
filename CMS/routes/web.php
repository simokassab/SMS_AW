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

Route::get('/', function () {
    return view('campaigns.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'PagesController@users');
Route::get('/campaigns', 'PagesController@campaigns');
Route::get('/sender', 'PagesController@sender');
Route::get('/credits', 'PagesController@credits');

Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('login');
});

Route::resource('/users', 'UserController');
Route::resource('/campaigns', 'CampaignController');
Route::resource('/sender', 'SenderController');
Route::resource('/credits', 'CreditsController');

Route::get('/users/activate/{id}', 'UserController@activate');
Route::get('/users/download/{id}', 'UserController@downloadZip');
Route::post('/users/updatestatus/{id}', 'UserController@updateStatus');
Route::get('/users/{id}/approvedoc', 'UserController@approveDocs');
Route::get('/users/destroy/{id}', 'UserController@destroy');
Route::get('/users/delete/{id}', 'UserController@deleteUser');
Route::get('/getLast', 'CampaignController@getLast');
Route::get('/campaigns/{id}/approveIt', 'CampaignController@approveIt');
Route::get('/campaigns/{id}/declineIt', 'CampaignController@declineIt');
Route::get('/credits/{id}/addcredits', 'CreditsController@edit');