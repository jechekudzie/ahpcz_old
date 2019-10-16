<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PractitionerRequirement extends Model
{
    //

    protected $guarded = [];

    public function practitioner()
    {

        return $this->belongsTo(Practitioner::class);
    }

    public function requirement()
    {

        return $this->belongsTo(Requirement::class);
    }


    //update
    public function complete($status = true)
    {

        $this->update(compact('status'));
    }

    public function incomplete()
    {

        $this->complete(false);
    }


//update member status
    public function completeMember($member_status = true)
    {

        $this->update(compact('member_status'));
    }

    public function incompleteMember()
    {

        $this->completeMember(false);
    }


}
