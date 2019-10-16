<?php

namespace App\Http\Controllers;

use App\Practitioner;

use Illuminate\Http\Request;

class PractitionerApplicationsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        $practitioner =  new Practitioner();

        return view('admin.practitioner_applications.index',compact('practitioner'));
    }

    public function viewApplication(Practitioner $practitioner, $application){
        $notification = auth()->user()->notifications()->find($application);
        if($notification) {
            $notification->markAsRead();
        }

        return redirect('/admin/practitioners/'.$practitioner->id);
    }


}
