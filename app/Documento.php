<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    public function tipo(){
        return $this->belongsTo('App\Tipo', 'id_tipo');
    }
}
