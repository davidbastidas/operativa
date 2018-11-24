<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::group(['middleware' => ['sessionValid']], function () {

    Route::match(['get', 'post'], '/admin',
        [
            'as' => 'admin',
            'uses' => 'AdminController@index'
        ]
    );

    Route::get('admin/dashboard/{id}', [
        'as' => 'admin.dashboard',
        'uses' => 'AdminController@dashboard'
    ]);

    Route::get('admin/logout', 'AdminController@logout');


    Route::match(['get', 'post'], 'admin/img-panel',
        [
            'as' => 'admin.img',
            'uses' => 'ImagesController@index'
        ]
    );

    Route::get('admin/excel/index', [
        'as' => 'admin.excel.index',
        'uses' => 'UploadExcelController@index'
    ]);

    Route::post('admin/excel/upload', [
        'as' => 'admin.excel.upload',
        'uses' => 'UploadExcelController@upload'
    ]);

    Route::post('admin/excel/download', [
        'as' => 'admin.excel.download',
        'uses' => 'DownloadController@download'
    ]);


    Route::post('admin/avisos/upload', [
        'as' => 'admin.avisos.upload',
        'uses' => 'AvisosController@subirAvisos'
    ]);

    Route::get('admin/download-avisos', 'DownloadController@index');

    Route::get('admin/carga-avisos', 'AvisosController@cargaAvisosIndex');

    Route::post('admin/asignar-avisos', [
        'as' => 'admin.asignar.avisos',
        'uses' => 'AvisosController@cargarAvisos'
    ]);

    Route::get('admin/getAvisos', 'AvisosController@getAvisos');

});
