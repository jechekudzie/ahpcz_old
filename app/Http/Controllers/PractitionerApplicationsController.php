<?php

namespace App\Http\Controllers;

use App\Practitioner;

use App\ProfessionApprover;
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
        $user = auth()->user();
        $count = 0;
        $practitioners = new Practitioner();

        if ($user_role == 4) {
            $practitioners = Practitioner::where('registration_officer',0)->get();
            //whereRegistration_officerOrRegistration_officerAndAccountantAndMember(0, 1, 1, 1)->get();
        }

        if ($user_role == 5) {
            $practitioners = Practitioner::where('accountant',0)->get();
            //whereRegistration_officerOrRegistration_officerAndAccountantAndMember(0, 1, 1, 1)->get();
        }
        if ($user_role == 6) {
            $profession_approvers = ProfessionApprover::where('user_id',$user->id)->get();
            foreach ($profession_approvers as $profession_approver){
                $practitioners = Practitioner::where('registration_officer',1)
                    ->where('member',0)
                    ->where('profession_id',$profession_approver->profession_id)
                    ->get();
            }
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
