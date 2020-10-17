<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    //

    protected $guarded = [];

    public function document(){
        return $this->hasMany(Document::class);
    }
}
