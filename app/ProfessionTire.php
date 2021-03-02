<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionTire extends Model
{
    use HasFactory;

    protected $guarded = [];

    public  function profession(){
        return $this->belongsTo(Profession::class);
    }

    public  function tire(){
        return $this->belongsTo(Tire::class);
    }
}
