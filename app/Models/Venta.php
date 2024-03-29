<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $primaryKey = 'idVenta';
    public $timestamps = false;
    public function detalles(){
        return $this->hasMany(VentaDetalle::class,'idVenta');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class,'idCliente');
    }
}
