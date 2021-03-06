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
    return view('pages.home');
})->name('home')->middleware(['homemiddleware']);

Route::get('login', 'LoginController@getLogin')->name('login')->middleware(['homemiddleware']);
Route::post('login', 'LoginController@login');
Route::get('logout','LoginController@logout')->name('logout');

Route::get('signup', 'RegisterController@getSignup')->name('signup')->middleware(['homemiddleware']);
Route::post('signup', 'RegisterController@register');
Route::get('terms', function() {
    return view('pages.term');
});

Route::get('privacy', function() {
    return view('pages.policy');
});

// Route::get('email/verify','VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}','VerificationController@verify')->name('verification.verify');
// Route::get('email/resend','VerificationController@resend')->name('verification.resend');
Route::get('email/verify/{token}', 'RegisterController@verifyUser');
Route::get('email/resend', 'RegisterController@getResend')->middleware(['homemiddleware']);
Route::post('email/resend', 'RegisterController@postResend');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request')->middleware(['homemiddleware']);
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::group(['prefix'=>'user','middleware'=>'userlogin'], function(){
	Route::get('checkssl','SslController@getCheckSsl')->name('checkssl');
	Route::get('myssl','SslController@getMySsl')->name('myssl');
	Route::post('checkssl','SslController@checkSsl');
	Route::post('myssl','SslController@postMySsl');
	Route::post('addssl','SslController@addSsl');
	Route::post('addmultiplessl','SslController@addMultipleSsl');

	Route::get('detail/{id}','SslController@getDetail')->middleware(['mustbeownerssl']);

	Route::delete('detail/delete/{id}','SslController@getDelete')->middleware(['mustbeownerssl']);
	Route::post('detail/edit/{id}','SslController@postEdit')->middleware(['mustbeownerssl']);

	Route::get('setting','UserController@getSetting')->name('setting');
	Route::get('profile','UserController@getProfile')->name('profile');
	Route::post('edituser/{id}','UserController@editProfile')->middleware(['mustbeowner']);

	Route::post('addemail','UserController@addEmail');
	Route::post('addtele','UserController@addTele');
	Route::get('deltele/{id}','UserController@delTele')->middleware(['mustbeownertele']);

	Route::get('addemail/verify/{token}','UserController@verifyAddMail');
	Route::get('delmail/{id}','UserController@delMail')->middleware(['mustbeowneremail']);

	Route::post('ssl/disablenoti','AjaxController@disableNoti');
	Route::post('ssl/enablenoti','AjaxController@enableNoti');
	Route::post('ssl/deletessl','AjaxController@deleteSsl');

	Route::post('ssl/filter','SslController@filterSsl');

	Route::get('ssl/export/{id}','SslController@exportSsl')->middleware(['mustbeowner']);

	Route::get('ssl/exportcus/{expression}&{day}','SslController@exportCustom');

	Route::get('checkdomain','DomainController@getCheckDomain')->name('checkdomain');
	Route::post('checkdomain','DomainController@checkDomain');

	Route::get('mydomain','DomainController@getMyDomain')->name('mydomain');
	Route::post('mydomain','DomainController@postMyDomain');
	Route::post('adddomain','DomainController@addDomain');
	Route::post('addmultipledomain','DomainController@addMultiDomain');

	Route::post('domain/deletedomain','AjaxController@deleteDomain');
	Route::post('domain/disablenoti','AjaxController@disableNotiDomain');
	Route::post('domain/enablenoti','AjaxController@enableNotiDomain');

	Route::get('domain/export/{id}','DomainController@exportDomain');
	Route::post('domain/filter','DomainController@filterDomain');
	Route::get('domain/exportcus/{expression}&{day}','DomainController@exportCustom');

	Route::get('detaildomain/{id}','DomainController@getDetail')->middleware(['mustbeownerdomain']);
	Route::delete('detaildomain/delete/{id}','DomainController@getDelete')->middleware(['mustbeownerdomain']);
	Route::post('detaildomain/edit/{id}','DomainController@postEdit')->middleware(['mustbeownerdomain']);
});

// Route::get('test','DomainController@test');

Route::get('admin/login','LoginController@getAdminLogin')->name('admin_login')->middleware(['homemiddleware']);
Route::post('admin/login','LoginController@adminLogin');

Route::group(['prefix'=>'admin','middleware'=>'adminlogin'], function(){
	Route::get('/','AdminController@getHome')->name('adminhome');

	Route::get('user/list','AdminController@getUserList');
	Route::get('user/add','AdminController@getUserAdd');

	Route::post('user/edit/{id}','AdminController@editUser');
	Route::post('user/add','AdminController@addUser');

	Route::get('user/delete/{id}','AdminController@deleteUser');

	Route::get('ssl/list','AdminController@getSslList');
	Route::get('ssl/{id}','AdminController@findSslList');
	Route::get('ssl_all/{id}','AdminController@getSslAll');

	Route::get('sslall/list','AdminController@listAllSsl');

	Route::get('user/limit','AdminController@listLimit');
	Route::post('user/limit','AdminController@updateLimit');

	Route::post('user/noti','AdminController@updateNoti');

});