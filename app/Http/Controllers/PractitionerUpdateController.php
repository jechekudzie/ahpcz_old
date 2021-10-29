<?php

namespace App\Http\Controllers;

;

use App\CertificateNumber;
use App\Mail\FinalApproval;
use App\Mail\FullPayment;
use App\Mail\PractitionerApprovalStage1;
use App\Mail\PractitionerApprovalStage2;
use App\Notifications\AccountsApproval;
use App\Notifications\AccountsDisapproval;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\ApprovalUpdate;
use App\Notifications\ForSignOff;
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
use Illuminate\Support\Facades\Mail;

class PractitionerUpdateController extends Controller
{
    public function sessions()
    {
        $practitioners = Practitioner::all();
        foreach ($practitioners as $practitioner) {
            $practitioner->update([
                'registration_officer' => 1,
                'member' => 1,
                'registrar' => 1,
            ]);
        }
        dd('done');
    }

    //update payment methods
    public function paymentMethodsUpdate(Practitioner $practitioner)
    {
        $payment_methods = PaymentMethod::all()->sortBy('name');
        $renewal_categories = RenewalCategory::all()->sortBy('name');
        $register_categories = RegisterCategory::all()->sortBy('name');
        return view('admin.practitioner_payments.payment_requirement_fields', compact('payment_methods', 'renewal_categories', 'register_categories', 'practitioner'));

    }

    public function approve(Practitioner $practitioner)
    {
        return view('admin.practitioner_applications.approve', compact('practitioner'));
    }

    public function disapprove(Practitioner $practitioner)
    {
        return view('admin.practitioner_applications.disapprove', compact('practitioner'));
    }

    //registration officer approval
    public function registrationOfficerApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        $ec_member = request('ec_member');
        $notes = '';
        //check if the application has not bee approved already
        if ($practitioner->registration_officer == 0) {
            foreach (auth()->user()->notifications as $notification) {
                //dd((auth()->user()->notifications));
                //check if id is same as practitioner id and at stage ApplicationSubmitted
                if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\ApplicationSubmitted') {
                    $practitioner->update(['registration_officer' => 1]);
                    if ($ec_member) {
                        $profession_approver = ProfessionApprover::
                        where('profession_id', $practitioner->profession_id)->first();
                        $user = $profession_approver->user;
                        if ($comment == null) {
                            $comment = 'There is a new application that requires your attention.';
                        }
                        $user->notify(
                            new OfficerApproval($practitioner, $comment)
                        );
                    } else {
                        $practitioner->update(['member' => 1]);

                        if ($practitioner->registration_officer == 1 && $practitioner->accountant == 1 &&
                            $practitioner->member == 1) {
                            if ($practitioner->contact->email != null) {
                                Mail::to($practitioner->contact->email)
                                    ->send(new PractitionerApprovalStage1($practitioner));
                            }
                        }

                    }
                    //mark notification as read
                    $notification->markAsRead();
                }
            }
            return back()->with('message', 'Application has been approved successfully.');
        }

        if ($practitioner->registration_officer == 1) {
            foreach (auth()->user()->notifications as $notification) {
                //check if id is same as practitioner id and at stage ApplicationSubmitted
                if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\MemberApproval') {
                    $practitioner->update(['registration_officer' => 2]);
                    //mark notification as read
                    $notification->markAsRead();
                    $user = User::where('role_id', 7)->first();
                    $user->notify(
                        new OfficerApproval($practitioner, $comment)
                    );
                }

            }
            return back()->with('message', 'Application has been approved successfully.');
        }

        if ($practitioner->registration_officer == 2) {
            return back()->with('message', 'You have already approved this Application.');
        }
    }

    //member approval
    public function memberApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        $notes = '';
        foreach (auth()->user()->notifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\OfficerApproval') {
                $practitioner->update(['member' => 1]);
                $notification->markAsRead();
            }
        }

        if ($practitioner->registration_officer == 1 && $practitioner->accountant == 0) {
            $notes = 'Make sure the account has approved the payment from their end.';
            $registration_officer = User::where('role_id', 4)->first();//send notification to registration officer
            if ($comment == null) {
                $comment = 'Application approved by Educational committee member. ' . $notes;
            }
            $registration_officer->notify(
                new MemberApproval($practitioner, $comment)
            );
        }

        if ($practitioner->registration_officer == 1 && $practitioner->accountant == 1) {
            $registration_officer = User::where('role_id', 4)->first();//send notification to registration officer

            $registration_officer->notify(
                new MemberApproval($practitioner, $comment)
            );
            if ($practitioner->contact->email != null) {
                Mail::to($practitioner->contact->email)
                    ->send(new PractitionerApprovalStage1($practitioner));
            }
        }

        return back()->with('message', 'Registration has been approved successfully.');

    }

    //accountant approval
    public function accountantApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        $notes = '';
        if ($practitioner->accountant == 0) {
            foreach (auth()->user()->notifications as $notification) {
                if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\RegistrationPayment') {
                    $practitioner->update(['accountant' => 1]);
                    $notification->markAsRead();
                }
            }

            $registration_officer = User::where('role_id', 4)->first();//send notification to registration officer
            if ($comment == null) {
                $comment = 'Application payment approved by accountant. ';
            }
            $registration_officer->notify(
                new AccountsApproval($practitioner, $comment)
            );

            if ($practitioner->registration_officer == 1 && $practitioner->accountant == 1 && $practitioner->member == 1) {
                if ($practitioner->contact->email != null) {
                    $email = $practitioner->contact->email;
                    Mail::to($practitioner->contact->email)
                        ->send(new PractitionerApprovalStage1($practitioner));
                }
            }


        }

        if ($practitioner->accountant == 3) {

            $practitioner->update([
                'accountant' => 2,
                'registration_officer' => 2
            ]);
            $registrar = User::where('role_id', 7)->first();//send notification to registration officer

            $registrar->notify(
                new ForSignOff($practitioner, $comment)
            );

        }
        return back()->with('message', 'Registration  payment has been approved successfully.');

    }

    /**  GO BACK TO REGISTRATION OFFICER
     * At this stage the application goes back to the registration officer before registra, refer to the
     * registration officer function
     */

    //registrar approval
    public function registrarApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        /*foreach (auth()->user()->notifications as $notification) {*/

           /* if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\ForSignOff') {*/
                $practitioner->update([
                    'registrar' => 1,
                    'registration_officer' => 2,
                    'approval_status' => 1
                ]);
                //$notification->markAsRead();
            /*}*/
        /*}*/
        /*if ($practitioner->renewals) {
            $renewal = $practitioner->renewals->first();
            $current_certificate_number = CertificateNumber::where('renewal_period_id', $renewal->renewal_period_id)
                ->first();
            if ($current_certificate_number == null) {
                $current_certificate_number = CertificateNumber::create([
                    'renewal_period_id' => $renewal->renewal_period_id,
                    'certificate_number' => 0,
                ]);
            }
            $certificate_number = $current_certificate_number->certificate_number + 1;
            $current_certificate_number->update([
                'certificate_number' => $certificate_number
            ]);
            $practitioner_id = $renewal->practitioner->id;
            $renewal->update([
                'certificate' => 2,
                'certificate_number' => $certificate_number
            ]);
        }*/

        $registration_officer = User::whereRole_id(4)->first();//registration officer
        $accountant = User::whereRole_id(5)->first();//accountant

        $registration_officer->notify(
            new RegistrarApproval($practitioner, $comment)
        );

        $accountant->notify(
            new RegistrarApproval($practitioner, $comment)
        );

        if ($practitioner->contact->email != null) {
            Mail::to($practitioner->contact->email)
                ->send(new PractitionerApprovalStage2($practitioner));
        }

        return back()->with('message', 'Registration Application has been approved successfully.');

    }

    /** Disapproval logic*/

    public function final_payment(Practitioner $practitioner)
    {
        $comment = request('comment');
        $practitioner->update([
            'accountant' => 2,
            'approval_status' => 1,
        ]);

        $renewal = $practitioner->renewals->first();
        $renewal->update([
            'renewal_status_id' => 1,
            'cdpoints' => 1,
            'certificate' => 2,
        ]);

        $current_certificate_number = CertificateNumber::where('renewal_period_id', $renewal->renewal_period_id)
            ->first();
        if ($current_certificate_number == null) {
            $current_certificate_number = CertificateNumber::create([
                'renewal_period_id' => $renewal->renewal_period_id,
                'certificate_number' => 0,
            ]);
        }
        $certificate_number = $current_certificate_number->certificate_number + 1;
        $current_certificate_number->update([
            'certificate_number' => $certificate_number
        ]);
        $practitioner_id = $renewal->practitioner->id;
        $renewal->update([
            'certificate' => 2,
            'certificate_number' => $certificate_number
        ]);

        if ($practitioner->contact->email != null) {
            Mail::to($practitioner->contact->email)
                ->send(new FinalApproval($practitioner));
        }

        return back()->with('message', 'Registration Application has been approved successfully.');

    }



    /** Disapproval logic*/
//Read notification and view application
    public
    function viewNotification(Practitioner $practitioner, $notification_id)
    {
        //
        foreach (auth()->user()->unreadNotifications as $notification) {
            if ($practitioner->id == $notification->data['id'] && $notification->id == $notification_id) {
                $notification->markAsRead();
            }
        }

        return redirect('/admin/practitioners/' . $practitioner->id);
    }


//registration officer disapproval
    public
    function registrationOfficerDisApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->notifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\ApplicationSubmitted') {
                $practitioner->update(['registration_officer' => 0]);
                $notification->markAsRead();
            }

        }
        $users = User::whereRole_id(3)->get();
        foreach ($users as $user) {
            $user->notify(
                new OfficerDisapproval($practitioner, $comment)
            );
        }
        return back()->with('message', 'Application has been disapproved.');

    }

//accountant disapproval
    public
    function accountantDisApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {
            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\OfficerApproval') {
                $practitioner->update([
                    'registration_officer' => 0
                ]);
                $notification->markAsRead();
            }
        }
        $users = User::whereRole_id(4)->get();//registration officer

        foreach ($users as $user) {
            $user->notify(
                new AccountsDisapproval($practitioner, $comment)
            );
        }


        return back()->with('message', 'Application has been disapproved.');
    }


//member disapproval
    public
    function memberDisApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->unreadNotifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\AccountsApproval') {
                $practitioner->update([
                    'member' => 0,
                    'registration_officer' => 0
                ]);
                $notification->markAsRead();
            }
        }

        $users = User::whereRole_id(4)->get();//registration officer
        foreach ($users as $user) {
            $user->notify(
                new MemberDisapproval($practitioner, $comment)
            );
        }
        return back()->with('message', 'Application has been disapproved.');

    }

//registrar disapproval
    public
    function registrarDisApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        foreach (auth()->user()->notifications as $notification) {

            if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\MemberApproval') {
                $practitioner->update([
                    'registrar' => 0,
                    'registration_officer' => 0,
                    'member' => 0,
                ]);
                $notification->markAsRead();
            }
        }
        $users = User::whereRole_id(4)->first();//registration officer

        foreach ($users as $user) {
            $user->notify(
                new RegistrarDisapproval($practitioner, $comment)
            );
        }
        return back()->with('message', 'Application has been approved.');

    }


}
