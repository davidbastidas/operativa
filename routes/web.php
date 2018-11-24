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

    Route::get('/', function () {
        return "Ok";
    });

    /*Route::get('api/getData', ['middleware' => 'cors', function () {
        return " {\"id\": \"3\", \"label\": \"JSP\"}";
    }]);

    Route::post('api/novedad', ['middleware' => 'cors', function (Request $request) {
        $controller = new \App\Http\Controllers\NovedadController();
        return $controller->saveNovedad($request);
    }]);

    Route::post('api/mensaje', ['middleware' => 'cors', function (Request $request) {
        $controller = new \App\Http\Controllers\MensajesController();
        return $controller->sendMensajeToServer($request);
    }]);

    Route::post('api/getMensajes', ['middleware' => 'cors', function (Request $request) {
        $controller = new \App\Http\Controllers\MensajesController();
        return $controller->getMensajes($request);
    }]);

    Route::post('api/getRequisitos', ['middleware' => 'cors', function (Request $request) {
        $controller = new \App\Http\Controllers\TramitesController();
        return $controller->getRequisitos($request);
    }]);

    Route::post('api/setViewItem', ['middleware' => 'cors', function (Request $request) {
        $controller = new \App\Http\Controllers\MensajesController();
        return $controller->setViewItem($request);
    }]);

    Route::get('api/getBanners', ['middleware' => 'cors', function () {
        $controller = new \App\Http\Controllers\ImagesController();
        return $controller->getBanners();
    }]);

    Route::post('api/getDerechos', ['middleware' => 'cors', function (Request $request) {
        $controller = new \App\Http\Controllers\DerechosController();
        return $controller->getDerechos($request);
    }]);*/




    Route::get('admin/dashboard/{id}', [
        'as' => 'admin.dashboard',
        'uses' => 'AdminController@dashboard'
    ]);

    Route::get('admin/pendientes', [
        'as' => 'admin.pendientes',
        'uses' => 'AdminController@pendientes'
    ]);

    Route::get('admin/logout', 'AdminController@logout');

    Route::get('admin/response/{id}', [
        'as' => 'admin.response',
        'uses' => 'AdminController@response'
    ]);

    Route::get('admin/solved/{id}', [
        'as' => 'admin.solved',
        'uses' => 'AdminController@solved'
    ]);

    Route::get('admin/getResueltos/{id}', [
        'as' => 'admin.getResueltos',
        'uses' => 'AdminController@getResueltos'
    ]);

    Route::post('admin/sendResponse', [
        'as' => 'admin.sendResponse',
        'uses' => 'MensajesController@sendMensajeToClient'
    ]);


    Route::get('admin/graph', [
        'as' => 'admin.graph',
        'uses' => 'GraphController@index'
    ]);

    Route::get('admin/graph/getCiudades', [
        'as' => 'admin.getCiudades',
        'uses' => 'GraphController@getCiudades'
    ]);

    Route::get('admin/graph/getTotalesDashboard', [
        'as' => 'admin.graph.getTotalesDashboard',
        'uses' => 'GraphController@getTotalesDashboard'
    ]);

    Route::match(['get', 'post'], 'admin/img-panel',
        [
            'as' => 'admin.img',
            'uses' => 'ImagesController@index'
        ]
    );

    Route::get('admin/graph/getFiveDays/{fecha}/{numdias}', [
        'as' => 'admin.getFiveDays',
        'uses' => 'GraphController@getFiveDays'
    ]);

    Route::get('admin/excel/index', [
        'as' => 'admin.excel.index',
        'uses' => 'UploadExcelController@index'
    ]);

    Route::post('admin/excel/upload', [
        'as' => 'admin.excel.upload',
        'uses' => 'UploadExcelController@upload'
    ]);

    Route::get('admin/excel/download', [
        'as' => 'admin.excel.download',
        'uses' => 'UploadExcelController@download'
    ]);

    Route::post('admin/avisos/upload', [
        'as' => 'admin.avisos.upload',
        'uses' => 'AvisosController@subirAvisos'
    ]);
});
