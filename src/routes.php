<?php
Route::get('logs', 'Georgesdoe\Weblog\WeblogController@view');
Route::get('logs/fetch', 'Georgesdoe\Weblog\WeblogController@data');
Route::get('logs/show', 'Georgesdoe\Weblog\WeblogController@show');
Route::get('logs/download', 'Georgesdoe\Weblog\WeblogController@download');
Route::post('logs/delete', 'Georgesdoe\Weblog\WeblogController@delete');