<?php

Route::group([
    'middleware' => 'api',
], function () {
});
Route::post('login', 'ApiController@login');
Route::post('avisos/getVisitas', 'ApiController@getAvisos');
