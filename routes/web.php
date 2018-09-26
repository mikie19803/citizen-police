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

Route::get('password/reset/phone','Auth\ResetPasswordController@getResetViewSms'); //get view to enter phone number
Route::post('password/reset/phone','Auth\ResetPasswordController@sendResetSms'); // sends code to number
Route::get('password/resetPassword','Auth\ResetPasswordController@getResetPasswordView');
Route::post('password/resetPassword','Auth\ResetPasswordController@resetPassword'); //resets password
Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('dashboard','DashboardController@dashboard');
Route::get('/index', 'HomeController@index')->name('home');
Route::get('/register/verify/{code}/{status}','Auth\RegisterController@verify');


Route::post('confirm/code','Auth\RegisterController@activate');
Route::get('/confirm/code',function(){
    return view('confirm');
});
Route::get('sendNotification','NotificationsController@create');
Route::post('sendNotification','NotificationsController@store');
Route::get('backupDatabase','NotificationsController@backupDatabase');

Route::get('report/all','ReportController@getAllReports');
Route::get('report/{id}/assign','ReportController@getCaseOfficers'); // returns view where admin can assign officers to case
Route::post('verifyAssignedOfficer','ReportController@verifyAssignedOfficer');
Route::post('report/{id}/assign','ReportController@assignOfficersToCase');
Route::post('report/{id}/close','ReportController@closeCase');
Route::resource('report','ReportController');
Route::get('getLocations','ReportController@getLocations');
Route::post('postComment','ReportController@postComment');
Route::post('addCollaborator/{addBy}','ReportController@addCollaborator');
Route::post('attachToAccount','ReportController@attachToAccount');
Route::post('invitation','ReportController@processInvitation');
Route::post('unassignOfficer','ReportController@unassignOfficer');
Route::get('user/{id}/case','ReportController@getOfficersCases');
Route::post('findByCode','ReportController@findByCode');



Route::resource('user','UsersController');
Route::resource('category','CategoriesController');
Route::resource('location','LocationController');

Route::get('profile','CitizensController@edit');
Route::patch('/citizen/{id}','CitizensController@update');



//test scripts
Route::get('testEmail/{toEmail}','TestScriptsController@testEmail');
Route::get('testSms','TestScriptsController@testSms');
Route::get('test','ReportController@test');
