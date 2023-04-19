<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireProfession extends Model
{
    use HasFactory;

    protected $guarded = [];

    public  function professions(){
        return $this->belongsTo(Profession::class);
    }

    public  function tire(){
        return $this->belongsTo(Tire::class);
    }
}
