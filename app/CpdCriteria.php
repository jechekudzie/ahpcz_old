<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpdCriteria extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function profession(){
        return $this->belongsTo(Profession::class);
    }

    public function employment_status(){
        return $this->belongsTo(EmploymentStatus::class);
    }
}
