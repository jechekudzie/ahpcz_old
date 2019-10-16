<?php

namespace App\Http\Controllers;

use App\Notifications\AccountsApproval;
use App\Notifications\AccountsDisapproval;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\MemberApproval;
use App\Notifications\MemberDisapproval;
use App\Notifications\OfficerApproval;
use App\Notifications\OfficerDisapproval;
use App\Notifications\RegistrarApproval;
use App\Notifications\RegistrarDisapproval;
use App\PaymentMethod;
use App\Practitioner;
use App\ProfessionApprover;
use App\RegisterCategory;
use App\RenewalCategory;
use App\User;
use Illuminate\Http\Request;

class PractitionerUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function approve(Practitioner $practitioner)
    {
        return view('admin.practitioner_applications.approve', compact('practitioner'));
    }

    public function disapprove(Practitioner $practitioner)
    {
        return view('admin.practitioner_applications.disapprove', compact('practitioner'));
    }


    //update payment methods
    public function paymentMethodsUpdate(Practitioner $practitioner)
    {
        $payment_methods = PaymentMethod::all()->sortBy('name');
        $renewal_categories = RenewalCategory::all()->sortBy('name');
        $register_categories = RegisterCategory::all()->sortBy('name');
        return view('admin.practitioner_payments.payment_requirement_fields', compact('payment_methods', 'renewal_categories', 'register_categories', 'practitioner'));
    }




    //registration officer approval
    public function registrationOfficerApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\ApplicationSubmitted') {
                $practitioner->update(['registration_officer' => 1]);
                $notification->markAsRead();
            }
        }
        $user = User::whereRole_id(5)->first();//registration officer

        $user->notify(
            new OfficerApproval($practitioner, $comment)
        );

        return back()->with('message', 'Registration/Renewal has been approved successfully.');

    }

    //accountant approval
    public function accountantApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {
            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\OfficerApproval') {
                $practitioner->update(['accountant' => 1]);
                $notification->markAsRead();
            }
        }
        $user = User::whereRole_id(6)->first();//registration officer

        $profession = $practitioner->profession_id;
        $profession_approver = ProfessionApprover::whereProfession_id($profession)->first();
        $profession_approver->user->notify(
            new AccountsApproval($practitioner, $comment)
        );


        return back()->with('message', 'Registration/Renewal has been approved successfully.');
    }

    //member approval
    public function memberApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\AccountsApproval') {
                $practitioner->update(['member' => 1]);
                $notification->markAsRead();
            }
        }
        $user = User::whereRole_id(7)->first();//registration officer

        $user->notify(
            new MemberApproval($practitioner, $comment)
        );

        return back()->with('message', 'Registration/Renewal has been approved successfully.');

    }

    //registrar approval
    public function registrarApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\MemberApproval') {
                $practitioner->update([
                    'registrar' => 1,
                    'approval_status' => 1
                ]);
                $notification->markAsRead();
            }
        }
        $user = User::whereRole_id(4)->first();//registration officer

        $user->notify(
            new RegistrarApproval($practitioner, $comment)
        );

        return back()->with('message', 'Registration/Renewal has been approved successfully.');

    }


    /** Disapproval logic*/

    //Read notification and view application
    public function viewNotification(Practitioner $practitioner, $notification_id)
    {
        //
        foreach (auth()->user()->unreadNotifications as $notification) {
            if ($practitioner->id == $notification->data['id'] && $notification->id == $notification_id) {
                $notification->markAsRead();
            }
        }

        return redirect('/admin/practitioners/' . $practitioner->id);
    }

    //registration officer approval
    public function registrationOfficerDisApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\ApplicationSubmitted') {
                $practitioner->update(['registration_officer' => 0]);
                $notification->markAsRead();
            }
        }
        $user = User::whereRole_id(3)->first();//registration officer

        $user->notify(
            new OfficerDisapproval($practitioner, $comment)
        );

        return back()->with('message', 'Registration/Renewal has been disapproved.');

    }

    //accountant approval
    public function accountantDisApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {
            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\OfficerApproval') {
                $practitioner->update(['accountant' => 0]);
                $notification->markAsRead();
            }
        }
        $user = User::whereRole_id(4)->first();//registration officer

        $user->notify(
            new AccountsDisapproval($practitioner, $comment)
        );


        return back()->with('message', 'Registration/Renewal has been disapproved.');
    }

    //member approval
    public function memberDisApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\AccountsApproval') {
                $practitioner->update(['member' => 0]);
                $notification->markAsRead();
            }
        }
        $user = User::whereRole_id(5)->first();//registration officer

        $user->notify(
            new MemberDisapproval($practitioner, $comment)
        );

        return back()->with('message', 'Registration/Renewal has been disapproved.');

    }

    //registrar approval
    public function registrarDisApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\MemberApproval') {
                $practitioner->update(['registrar' => 0]);
                $notification->markAsRead();
            }
        }
        $user = User::whereRole_id(4)->first();//registration officer

        $user->notify(
            new RegistrarDisapproval($practitioner, $comment)
        );

        return back()->with('message', 'Registration/Renewal has been approved.');

    }


}
