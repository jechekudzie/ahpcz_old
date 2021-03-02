<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tire extends Model
{
    use HasFactory;

    protected $guarded = [];

    public  function profession_tires(){
        return $this->hasMany(ProfessionTire::class);
    }
}
