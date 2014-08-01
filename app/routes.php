<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

/*

  Public Routes

*/

Route::get('/', 'HomeController@showHome');
Route::get('login', 'HomeController@showLogin');

//testing different oauth packages
Route::get('test1', 'JESSENGERSController@test'); // JESSENGERS
Route::get('test2', 'artdarekController@testfb'); // artdarek
Route::get('test3', 'artdarekController@testtumblr'); // artdarek



/*

  AUTH Routes

*/

Route::get('login/tumblr', 'AuthController@doTumblrAuthStep1');
Route::get('login/tumblr/callback', 'AuthController@doTumblrAuthStep2');
Route::get('logout', 'AuthController@doLogout');

/*

  USER Routes

*/

Route::group(array('before' => 'auth'), function() {

  //Resource API
  Route::resource('users', 'UserController');

});
