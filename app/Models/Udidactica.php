<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Udidactica extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'creditos',
        'horas',
        'ciclo',
        'moodle',
        'mformativo_id',
        'tipo',
        'orden'
    ];
    public function modulo(){
        return $this->belongsTo(Mformativo::class,'mformativo_id');
    }
    public function equivalencia(){
        return $this->belongsTo(Udidactica::class,'udidactica_id');
    }
    public function old(){
        return $this->hasOne(Udidactica::class,'udidactica_id');
    }
}
