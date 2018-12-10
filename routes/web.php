<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


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

    Route::get('admin/mapas', [
        'as' => 'mapas',
        'uses' => 'AvisosController@visitaMapa'
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

    Route::get('admin/subir-avisos/{agenda}', [
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

    Route::get('admin/asignar-avisos/index/{agenda}', 'AvisosController@listaAvisosIndex')->name('asignar.avisos');

    Route::post('admin/asignar-avisos', [
        'as' => 'admin.asignar.avisos',
        'uses' => 'AvisosController@cargarAvisos'
    ]);

    Route::post('admin/asignarall', [
        'as' => 'admin.asignarall',
        'uses' => 'AvisosController@asignarAllAvisos'
    ]);

    Route::post('admin/vaciar-carga', [
        'as' => 'admin.vaciar.carga',
        'uses' => 'AvisosController@vaciarCarga'
    ]);

    Route::post('admin/agenda/save', [
        'as' => 'agenda.save',
        'uses' => 'AvisosController@saveAgenda'
    ]);

    Route::get('admin/agenda/delete/{agenda}', [
        'as' => 'agenda.delete',
        'uses' => 'AvisosController@deleteAgenda'
    ]);

    Route::get('admin/avisos/editar/{aviso}', [
        'as' => 'aviso.editar',
        'uses' => 'AvisosController@editarAviso'
    ]);

    Route::post('admin/avisos/save', [
        'as' => 'aviso.editar.save',
        'uses' => 'AvisosController@saveAviso'
    ]);

    Route::get('admin/getAvisos', 'AvisosController@getAvisos');

    Route::post('admin/dashboard/getAvancePorGestor', [
        'as' => 'admin.dashboard.getAvancePorGestor',
        'uses' => 'DashboardController@getAvancePorGestor'
    ]);

    Route::post('admin/dashboard/getAvanceDiario', [
        'as' => 'admin.dashboard.getAvanceDiario',
        'uses' => 'DashboardController@getAvanceDiario'
    ]);

    Route::post('admin/dashboard/getPointMapGestores', [
        'as' => 'admin.dashboard.getPointMapGestores',
        'uses' => 'DashboardController@getPointMapGestores'
    ]);

    Route::get('admin/avisos/delete/{aviso}', [
        'as' => 'aviso.eliminar',
        'uses' => 'AvisosController@deleteAviso'
    ]);

    Route::get('admin/avisos/delete/all', [
        'as' => 'aviso.eliminar.all',
        'uses' => 'AvisosController@deleteAvisoPorSeleccion'
    ]);

    Route::post('admin/avisos/getPointMapVisita', [
        'as' => 'admin.avisos.getPointMapVisita',
        'uses' => 'AvisosController@getPointMapVisita'
    ]);
});

Auth::routes();
