<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PractitionerStudentApproval extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function practitioner(){
        return $this->belongsTo(Practitioner::class);
    }
}
