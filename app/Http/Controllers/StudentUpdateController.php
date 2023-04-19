<?php

namespace App\Http\Controllers;

use App\CertificateNumber;
use App\Http\Livewire\Student;
use App\Mail\FinalApproval;
use App\Mail\PractitionerApprovalStage1;
use App\Mail\PractitionerApprovalStage2;
use App\Mail\StudentFinalApproval;
use App\Notifications\AccountsApproval;
use App\Notifications\AccountsDisapproval;
use App\Notifications\ForSignOff;
use App\Notifications\MemberApproval;
use App\Notifications\MemberDisapproval;
use App\Notifications\OfficerApproval;
use App\Notifications\OfficerDisapproval;
use App\Notifications\RegistrarApproval;
use App\Notifications\RegistrarDisapproval;
use App\Notifications\StudentAccountsAproval;
use App\Notifications\StudentEcAproval;
use App\Notifications\StudentRegistrationsAproval;
use App\PaymentMethod;
use App\Practitioner;
use App\ProfessionApprover;
use App\RegisterCategory;
use App\RenewalCategory;
use App\StudentNumber;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StudentUpdateController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');

    }

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
        return view('admin.student_applications.approve', compact('practitioner'));
    }

    public function disapprove(Practitioner $practitioner)
    {
        return view('admin.student_applications.disapprove', compact('practitioner'));
    }

    //registration officer approval
    public function registrationOfficerApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        $ec_member = request('ec_member');
        $notes = '';
        //dd($practitioner->practitioner_student_approval->member);
        //check if the application has not bee approved already
        if ($practitioner->practitioner_student_approval->registration_officer == 0) {
            foreach (auth()->user()->notifications as $notification) {
                //dd((auth()->user()->notifications));
                //check if id is same as practitioner id and at stage ApplicationSubmitted
                if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\StudentSubmission') {
                    $practitioner->practitioner_student_approval->update(['registration_officer' => 1]);
                    if ($ec_member) {
                        $profession_approver = ProfessionApprover::
                        where('profession_id', $practitioner->profession_id)->first();
                        $user = $profession_approver->user;
                        if ($comment == null) {
                            $comment = 'There is a new application that requires your attention.';
                        }
                        $user->notify(
                            new StudentRegistrationsAproval($practitioner, $comment)
                        );
                    } else {
                        $practitioner->practitioner_student_approval->update(['member' => 1]);

                        if ($practitioner->practitioner_student_approval->registration_officer == 1 &&
                            $practitioner->practitioner_student_approval->accountant == 1 &&
                            $practitioner->practitioner_student_approval->member == 1) {
                            $registrar = User::where('role_id', 7)->first();
                            $registrar->notify(
                                new StudentRegistrationsAproval($practitioner, $comment)
                            );
                        }

                    }
                    //mark notification as read
                    $notification->markAsRead();
                }
            }
            return back()->with('message', 'Application has been approved successfully.');
        }

        if ($practitioner->practitioner_student_approval->registration_officer == 1) {
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

        if ($practitioner->practitioner_student_approval->registration_officer == 2) {
            return back()->with('message', 'You have already approved this Application.');
        }
    }

    //accountant approval
    public function accountantApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        $notes = '';
        if ($practitioner->practitioner_student_approval->accountant == 0) {
            foreach (auth()->user()->notifications as $notification) {
                //dd((auth()->user()->notifications));
                //check if id is same as practitioner id and at stage ApplicationSubmitted
                if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\StudentSubmission') {

                    $practitioner->practitioner_student_approval->update(['accountant' => 1]);

                    if ($practitioner->practitioner_student_approval->registration_officer == 1 &&
                        $practitioner->practitioner_student_approval->accountant == 1 &&
                        $practitioner->practitioner_student_approval->member == 1) {
                        $registrar = User::where('role_id', 7)->first();
                        $registrar->notify(
                            new StudentRegistrationsAproval($practitioner, $comment)
                        );
                    } else {
                        $registration_officer = User::where('role_id', 4)->first();
                        $registration_officer->notify(
                            new StudentAccountsAproval($practitioner, $comment)
                        );
                    }


                    //mark notification as read
                    $notification->markAsRead();
                }
            }
            return back()->with('message', 'Student Application has been approved successfully.');
        }

        if ($practitioner->practitioner_student_approval->accountant == 3) {

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
//member approval
    public function memberApproval(Practitioner $practitioner)
    {
        $comment = request('comment');
        $notes = '';

        foreach (auth()->user()->notifications as $notification) {
            if ($practitioner->practitioner_student_approval->member == 0) {
                //dd((auth()->user()->notifications));
                //check if id is same as practitioner id and at stage ApplicationSubmitted
                if ($practitioner->id == $notification->data['id'] && $notification->type == 'App\Notifications\StudentRegistrationsAproval') {
                    $practitioner->practitioner_student_approval->update(['member' => 1]);
                    if ($practitioner->practitioner_student_approval->registration_officer == 1 &&
                        $practitioner->practitioner_student_approval->accountant == 1 &&
                        $practitioner->practitioner_student_approval->member == 1) {

                        $registration_officer = User::where('role_id', 4)->first();
                        $registration_officer->notify(
                            new StudentEcAproval($practitioner, $comment)
                        );

                        $registrar = User::where('role_id', 7)->first();
                        $registrar->notify(
                            new ForSignOff($practitioner, $comment)
                        );

                    } else {
                        $registration_officer = User::where('role_id', 4)->first();
                        $registration_officer->notify(
                            new StudentEcAproval($practitioner, $comment)
                        );
                    }


                    //mark notification as read
                    $notification->markAsRead();
                }
            }
            return back()->with('message', 'Student Application has been approved successfully.');
        }

        return back()->with('message', 'Registration has been approved successfully.');

    }


    //registrar approval
    public function registrarApproval(Practitioner $practitioner)
    {
        $comment = request('comment');

        if ($practitioner->practitioner_student_approval->registrar == 0) {
            //dd((auth()->user()->notifications));
            //check if id is same as practitioner id and at stage ApplicationSubmitted

            $practitioner->practitioner_student_approval->update(['registrar' => 1]);
            $practitioner->update(['approval_status' => 1]);
            if ($practitioner->practitioner_student_approval->registration_officer == 1 &&
                $practitioner->practitioner_student_approval->accountant == 1 &&
                $practitioner->practitioner_student_approval->member == 1 &&
                $practitioner->practitioner_student_approval->registrar == 1) {


                if ($practitioner->renewals) {
                    $renewal = $practitioner->renewals->first();
                    $current_certificate_number = StudentNumber::where('renewal_period_id', $renewal->renewal_period_id)
                        ->first();
                    if ($current_certificate_number == null) {
                        $current_certificate_number = StudentNumber::create([
                            'renewal_period_id' => $renewal->renewal_period_id,
                            'student_number' => 0,
                        ]);
                    }
                    $certificate_number = $current_certificate_number->certificate_number + 1;
                    $current_certificate_number->update([
                        'student_number' => $certificate_number
                    ]);
                    $practitioner_id = $renewal->practitioner->id;
                    $renewal->update([
                        'certificate' => 2,
                        'student_number' => $certificate_number
                    ]);
                }

                $registration_officer = User::where('role_id', 4)->first();
                $registration_officer->notify(
                    new \App\Notifications\StudentFinalApproval($practitioner, $comment)
                );

                $accountant = User::where('role_id', 5)->first();
                $accountant->notify(
                    new \App\Notifications\StudentFinalApproval($practitioner, $comment)
                );

                if ($practitioner->contact->email != null) {
                    Mail::to($practitioner->contact->email)
                        ->send(new StudentFinalApproval($practitioner));
                }

            }
        }
        return back()->with('message', 'Student Application has been approved successfully.');


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


    public function upgrade(Practitioner $practitioner){

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

//registration officer approval
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
