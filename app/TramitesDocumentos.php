<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TramitesDocumentos extends Model
{
    protected $table = 'tramites_documentos';

    public function tramite(){
        return $this->belongsTo('App\Tramite', 'id_tramite');
    }

    public function documento(){
        return $this->belongsTo('App\Documento', 'id_documento');
    }
}
