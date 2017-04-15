<?php
Route::get('logs', 'Georgesdoe\Weblog\WeblogController@index');
Route::get('logs/show', 'Georgesdoe\Weblog\WeblogController@show');
Route::get('logs/download', 'Georgesdoe\Weblog\WeblogController@download');
Route::post('logs/delete', 'Georgesdoe\Weblog\WeblogController@delete');