<?php

/*
 |--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('test-page-2', array( 'as'=>'test-page-2','uses' => 'Rapidweb\Admin\Controllers\AdminController@o_package_test'));

//Route::get('test-page-2', array( 'as'=>'test-page-2','uses' => 'AdminController@o_package_test'));

Route::get('test-page', ['as' => 'test-page', function()
{
	echo 'Hello world';
	die;
}]);

/*Route::get('/inline', function(){

new \Rapidweb\Admin\AdminController();

});*/

//Route::get('test-page-2', array( 'as'=>'test-page-2','uses' => 'Rapidweb\Admin\Controllers\AdminController@o_marks_test'));



Route::group(array('namespace' => 'Rapidweb\Admin\Controllers'), function()
{
	Route::get('test-page-3', array('as' => 'testpage3', 'uses' => 'AdminController@o_package_test'));
	Route::get('test-page-4', array('as' => 'testpage4', 'uses' => 'AdminController@o_event_test'));

});