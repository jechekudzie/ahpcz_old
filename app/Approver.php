<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    //

    protected $guarded = [];

    public function professionApprover(){

        return $this->hasMany(ProfessionApprover::class);
    }


}
