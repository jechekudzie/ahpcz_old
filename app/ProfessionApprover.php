<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessionApprover extends Model
{
    //
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }




}


