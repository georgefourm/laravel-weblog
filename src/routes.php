<?php
Route::group(['prefix' => config('weblog.route_prefix'), 'middleware' => config('weblog.middleware')],function(){
	Route::get('/', 'Georgesdoe\Weblog\WeblogController@view');
	Route::get('fetch', 'Georgesdoe\Weblog\WeblogController@data');
	Route::get('show', 'Georgesdoe\Weblog\WeblogController@show');
	Route::get('download', 'Georgesdoe\Weblog\WeblogController@download');
	Route::post('delete', 'Georgesdoe\Weblog\WeblogController@delete');
});
