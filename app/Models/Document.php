<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function tipo(){
        return $this->belongsTo(Tdocument::class,'tdocument_id');
    }
    public function movimientos(){
        return $this->hasMany(Dmove::class,'document_id');
    }
    public function servicio(){
        return $this->belongsTo(Servicio::class,'servicio_id','idServicio');
    }
    public function responsable(){
        return $this->belongsTo(User::class,'responsable_id','id');
    }
    public function usuario(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
