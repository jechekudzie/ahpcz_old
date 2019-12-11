<?php

namespace App\Http\Controllers;

use App\Practitioner;

use Illuminate\Http\Request;

class PractitionerApplicationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }
    public function index()
    {
        $user_role = auth()->user()->role_id;
        $count = 0;
        $practitioners = new Practitioner();

        if ($user_role == 4) {
            $practitioners = Practitioner::whereRegistration_officerOrRegistration_officerAndAccountantAndMember(0, 1, 1, 1)->get();
        }

        if ($user_role == 5) {
            $practitioners = Practitioner::whereRegistration_officerAndAccountant(1, 0)->get();

        }

        if ($user_role == 6) {
            $practitioners = Practitioner::whereRegistration_officerAndAccountantAndMember(1, 1, 0)->get();

        }

        if ($user_role == 7) {
            $practitioners = Practitioner::whereRegistration_officerAndAccountantAndMemberAndRegistrar(2, 1, 1, 0)->get();
        }

        if ($user_role == 3) {

            $practitioners = [];
        }
        if ($user_role == 2) {

            $practitioners = [];
        }
        if ($user_role == 1) {

            $practitioners = [];
        }

        //$practitioners = $practitioners->get();
        //dd($practitioners);
        return view('admin.practitioner_applications.index', compact('practitioners'));
    }

    public function viewApplication(Practitioner $practitioner, $application)
    {
        $notification = auth()->user()->notifications()->find($application);
        if ($notification) {
            $notification->markAsRead();
        }

        return redirect('/admin/practitioners/' . $practitioner->id);
    }


}
