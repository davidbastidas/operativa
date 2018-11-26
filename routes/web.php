<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::group(['middleware' => ['sessionValid']], function () {

    Route::get('/', function (){
       return view('auth.login', ['id' => '']);
    })->name('/');

    Route::post('login', [
        'as' => 'login',
        'uses' => 'LoginController@login'
    ]);

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

    Route::post('logout', 'LoginController@logout')->name('logout');

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

    Route::get('admin/download-avisos', 'DownloadController@index')->name('download.avisos');

    Route::get('admin/carga-avisos', 'AvisosController@cargaAvisosIndex')->name('carga.avisos');

    Route::post('admin/asignar-avisos', [
        'as' => 'admin.asignar.avisos',
        'uses' => 'AvisosController@cargarAvisos'
    ]);

    Route::post('admin/vaciar-carga', [
        'as' => 'admin.vaciar.carga',
        'uses' => 'AvisosController@vaciarCarga'
    ]);

    Route::post('admin/getIndicadores', [
        'as' => 'admin.getIndicadores',
        'uses' => 'AvisosController@getIndicadores'
    ]);

    Route::get('admin/getAvisos', 'AvisosController@getAvisos');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
