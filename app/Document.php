<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //

    protected $guarded = [];

    public function practitioner(){
        return $this->belongsTo(Practitioner::class,'document_owner');
    }

    public function documentCategory(){
        return $this->belongsTo(DocumentCategory::class);
    }
}
