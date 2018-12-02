<?php

use Illuminate\Support\Facades\Auth;


Route::group(['middleware' => ['sessionValid']], function () {

    Route::get('/', function (){
        return view('auth.login', ['id' => '']);
    })->name('/');

    Route::post('login', [
        'as' => 'login',
        'uses' => 'LoginController@login'
    ]);

    Route::get('admin/agenda', [
        'as' => 'agenda',
        'uses' => 'AvisosController@index'
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

    Route::get('admin/subir-avisos/{agenda}/{delegacion}', [
        'as' => 'admin.avisos.subir',
        'uses' => 'UploadExcelController@index'
    ]);

    Route::post('admin/excel/upload', [
        'as' => 'admin.excel.upload',
        'uses' => 'UploadExcelController@upload'
    ]);

    Route::post('admin/agenda/download', [
        'as' => 'admin.agenda.download',
        'uses' => 'DownloadController@download'
    ]);

    Route::post('admin/avisos/upload', [
        'as' => 'admin.avisos.upload',
        'uses' => 'AvisosController@subirAvisos'
    ]);

    Route::get('admin/asginar-avisos/index/{agenda}/{delegacion}', 'AvisosController@cargaAvisosIndex')->name('asignar.avisos');

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

    Route::post('admin/agenda/save', [
        'as' => 'agenda.save',
        'uses' => 'AvisosController@saveAgenda'
    ]);

    Route::get('admin/agenda/delete/{agenda}', [
        'as' => 'agenda.delete',
        'uses' => 'AvisosController@deleteAgenda'
    ]);

    Route::get('admin/getAvisos', 'AvisosController@getAvisos');

});

Auth::routes();
