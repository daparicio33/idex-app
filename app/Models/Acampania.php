<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acampania extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function campania(){
        return $this->belongsTo(Campania::class);
    }
    public function estudiante(){
        return $this->belongsTo(Estudiante::class);
    }
}
