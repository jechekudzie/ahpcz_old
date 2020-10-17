<?php

namespace App\Http\Controllers;

use App\Notifications\FullPayment;
use App\Notifications\PartPayment;
use App\Payment;
use App\PaymentChannel;
use App\PaymentItem;
use App\PaymentItemCategory;
use App\PaymentMethod;
use App\PaymentType;
use App\Practitioner;
use App\PractitionerCpdpoint;
use App\PractitionerPlacement;
use App\Registration;
use App\RegistrationFee;
use App\Renewal;
use App\RenewalCategory;
use App\RenewalFee;
use App\RenewalPeriod;
use App\Vat;
use Illuminate\Http\Request;

class RenewalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //list all renewal yearly payments
    public function index(Renewal $renewal)
    {
        return view('admin.practitioner_payments.payments_list', compact('renewal'));
    }


    //payments requirements
    public function paymentsRequirementUpdate(Practitioner $practitioner)
    {
        $practitioner->update(request()->validate([
            'payment_method_id' => 'required',
            'renewal_category_id' => 'required',
            'register_category_id' => 'required',
        ]));

        /**here after updating the payment methods, check to see if this practitioner has
         * anything in renewals, if yes redirect to renewal checkStatus, if not go to registration route
         */

        return redirect('/admin/practitioners/renewals/' . $practitioner->id . '/create');


    }

    public function checkPaymentStatus(Practitioner $practitioner)
    {
        if ($practitioner->payment_method_id == null && $practitioner->renewal_category_id == null) {
            return redirect('/admin/practitioners/payment_requirement/' . $practitioner->id . '/update');
        }

        return redirect('/admin/practitioners/renewals/' . $practitioner->id . '/create');




    }

    //Initial renewal payment
    public function create(Practitioner $practitioner)
    {

        $vat = Vat::where('id', 1)->first();
        $renewal_fee = RenewalFee::whereRenewal_category_idAndProfession_id($practitioner->renewal_category_id, $practitioner->profession_id)->first();
        $payment_types = PaymentType::all()->sortBy('name');
        $payment_channels = PaymentChannel::all();
        $renewal_periods = RenewalPeriod::all()->sortByDesc('period');

        return view('admin.practitioner_payments.create', compact(
            'practitioner', 'payment_channels', 'payment_types',
            'renewal_periods', 'renewal_fee', 'vat'));

    }

    //Store initial payment and create yearly subscription
    public function store(Practitioner $practitioner)
    {
        $payment = request()->validate([
            'payment_date' => 'required',
            'renewal_period_id' => 'required',
            'payment_channel_id' => 'required',
            'amount_paid' => 'required',
            'receipt_number' => ['required','digits_between:4,8','numeric','unique:payments'],
            'pop' => 'nullable',
        ]);

        /** get @var $renewal_fee */
        $renewal_fee = RenewalFee::where('renewal_category_id', '=', $practitioner->renewal_category_id, 'AND', 'profession_id', '=', $practitioner->profession_id)->first();

        /** get the renewal period @var $renewal_period_id */
        $renewal_period_id = request('renewal_period_id');

        /** calculate balance  @var $renewal_balance */
        /*$renewal_balance = $renewal_fee->fee - request('amount_paid');*/
        $renewal_balance = request('amount_invoiced') - request('amount_paid');

        /** add attributes to @var $renewals */
        $renewals['renewal_period_id'] = request('renewal_period_id');
        $renewals['payment_method_id'] = $practitioner->payment_method_id;
        $renewals['renewal_category_id'] = $practitioner->renewal_category_id;
        $renewals['balance'] = $renewal_balance;

        /** check renewal balance to update status either paid or owing @var $renewal_balance */
        if ($renewal_balance > 0) {

            $renewals['renewal_status_id'] = 3;

        } else {
            $renewals['renewal_status_id'] = 1;
        }

        $renewals['payment_type_id'] = 1;

        //temporarily pdate the placement, cpd points
        $renewals['cdpoints'] = 1;
        $renewals['placement'] = 1;

        $submitted_receipt_number = request('receipt_number');

        //check for receipt_number in payment before proceeding
        $receipt_number = Payment::whereReceipt_number($submitted_receipt_number)->first();

        if ($receipt_number) {
            return back()->with('message', 'Receipt number already taken');
        }

        /**check if renewal with the same renewal period/year already exist with the same practitioner*/
        $check_renewal = Renewal::whereRenewal_period_idAndPractitioner_id($renewal_period_id, $practitioner->id)->first();
        if ($check_renewal == null) {
            /** create registration */
            $renewal = $practitioner->addRenewal($renewals);
            $month = date('m');
            $day = date('d');

            //add attributes to payments
            $payment['month'] = $month;
            $payment['day'] = $day;
            $payment['practitioner_id'] = $practitioner->id;
            $payment['balance'] = $renewal_balance;
            /*$payment['amount_invoiced'] = $renewal_fee->fee;*/
            $payment['amount_invoiced'] = request('amount_invoiced');
            $payment['payment_item_category_id'] = 1;
            $payment['payment_item_id'] = 33;
            $new_renewal_payment = $renewal->addPayments($payment);

            if ($renewal_balance > 0) {
                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $new_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }
            } else {

                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $new_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }

            }

            //update approval statuses
            if(
                $practitioner->approval_status == 0 && $practitioner->registration_officer == 0
                && $practitioner->accountant == 0 && $practitioner->member == 0
                && $practitioner->registrar == 0

            ) {
                $practitioner->update([
                    'approval_status' => 1,
                    'registration_officer' => 2,
                    'accountant' => 1,
                    'member' => 1,
                    'registrar' => 1
                ]);
            }


            $practitioner_requirements = $practitioner->practitionerRequirements;
            foreach ($practitioner_requirements as $practitioner_requirement){

                $practitioner_requirement->update([
                    'status'=>1,
                    'member_status'=>1
                ]);

            }

            return redirect('/admin/practitioners/' . $practitioner->id)->with('message', 'Payment completed successfully.');

        } else {
            return back()->with('message', 'A renewal subscription for the selected period is already active, not that if this a regular payment click the payment link to proceed');
        }
    }

    
    //Create renewal payments (fetch form)
    public function createPayment(Renewal $renewal)
    {
        $payment_items = PaymentItem::all()->sortBy('name');
        $payment_channels = PaymentChannel::all()->sortBy('name');
        $payment_item_categories = PaymentItemCategory::all()->sortBy('name');
        return view('admin.practitioner_payments.renewal_payments',
            compact('renewal', 'payment_items', 'payment_channels', 'payment_item_categories')
        );


    }


    //make and store renewals payments (store data)
    public function makePayment(Renewal $renewal)
    {

        $payment = request()->validate([

            'payment_channel_id' => ['required'],
            'amount_invoiced' => ['required'],
            'amount_paid' => ['required'],
            'payment_date' => ['required'],
            'receipt_number' => ['required','digits_between:4,8','numeric','unique:payments'],
            'payment_item_category_id' => 'required',
            'payment_item_id' => 'required',
            'pop' => 'nullable',
        ]);

        //get payment type
        $payment_item_id = request('payment_item_id');

        //assign month and day
        $month = date('m');
        $day = date('d');

        $balance = request('amount_invoiced') - request('amount_paid');
        $payment['month'] = $month;
        $payment['day'] = $day;
        $payment['renewal_period_id'] = $renewal->renewal_period_id;
        $payment['practitioner_id'] = $renewal->practitioner->id;
        $payment['balance'] = $balance;

        /** check if there is a payment with the same payment id
         * for that particular period for that practitioner */


        if ($payment_item_id != 33 && $payment_item_id != 34 && $balance > 0) {

            return back()->with('message', 'Please note that for the selected item, only full payment is allowed');
        }

        foreach ($renewal->payments as $payments) {
            if ($payments->balance > 0) {
                $payments->update(['balance' => 0]);
            }
        }

        $renewal->addPayments($payment);

        if ($balance <= 0) {
            $renewal->update([
                'renewal_status_id' => 1,
                'balance' => $balance
            ]);
        } else {
            $renewal->update([
                'renewal_status_id' => 3,
                'balance' => $balance
            ]);
        }

        return redirect('/admin/practitioners/renewals/' . $renewal->id . '/payments_list')->with('message', 'Payment was successful.');
    }


    public function practitionerBalances(Practitioner $practitioner)
    {
        $balances = Payment::wherePractitioner_id($practitioner->id)
            ->Where('balance', '>', 0)->get();

        return view('admin.practitioner_payments.balances', compact('balances', 'practitioner'));
    }

    
    
    
    
    
    
    //check cd points
    public function cdpoints(Practitioner $practitioner)
    {
        $cdpoints = $practitioner->profession->cdpoint;
        return view('admin.practitioner_payments.cdpoints', compact('practitioner', 'cdpoints'));
    }

    //check placement
    public function createPlacement(Practitioner $practitioner)
    {
        $cdpoints = $practitioner->profession->cdpoint;
        return view('admin.practitioner_internship.placement', compact('practitioner', 'cdpoints'));
    }

    //store cd points
    public function storeCdpoints(Practitioner $practitioner)
    {
        $path = '';
        $renewal_period_id = request('renewal_period_id');

        $checkExist = PractitionerCpdpoint::wherePractitioner_idAndRenewal_period_id($practitioner->id, $renewal_period_id)->first();
        if ($checkExist) {
            return back()->with('message', 'CPD points for this period have already been submitted');
        } else {

            if (request()->hasfile('file')) {

                $file = request()->file('file');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $path = $file->move('cpdpoints', $file_name);

            }

            $yearly_cdpoints['renewal_period_id'] = request('renewal_period_id');
            $yearly_cdpoints['practitioner_id'] = $practitioner->id;
            $yearly_cdpoints['points'] = request('points');
            $yearly_cdpoints['path'] = $path;
            //get set cd points
            $cdpoints = $practitioner->profession->cdpoint;
            //get submitted cd points
            $points = request('points');
            if ($points == $cdpoints->points) {
                $practitioner->addCdPoints($yearly_cdpoints);
                //now check if cpd points renewal_period_id matches with a renewal_period_id
                //in the renewals table

                $checkRenewalExist = Renewal::wherePractitioner_idAndRenewal_period_id($practitioner->id, $renewal_period_id)->first();
                if ($checkRenewalExist) {
                    $checkRenewalExist->update([
                        'cdpoints' => 1,
                    ]);
                }
                return back()->with('message', 'Cd Points added successfully');
            } else {
                return back()->with('message', 'Cd Points do not match the required CPD Points');

            }
        }


    }

    //store placement
    public function storePlacement(Practitioner $practitioner)
    {
        $path = '';
        $renewal_period_id = request('renewal_period_id');

        $checkExist = PractitionerPlacement::wherePractitioner_idAndRenewal_period_id($practitioner->id, $renewal_period_id)->first();
        if ($checkExist) {
            return back()->with('message', 'Placement for this renewal period has already been submitted');
        } else {

            if (request()->hasfile('file')) {

                $file = request()->file('file');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $path = $file->move('placements', $file_name);

            }

            $yearly_placement['renewal_period_id'] = request('renewal_period_id');
            $yearly_placement['practitioner_id'] = $practitioner->id;
            $yearly_placement['path'] = $path;

            //get set placement status for that profession
            $placement = $practitioner->profession->cdpoint;
            //get submitted cd points
            if ($placement->placement == 1) {
                $practitioner->addPlacement($yearly_placement);
                //now check if placement renewal_period_id matches with a renewal_period_id
                //in the renewals table
                $checkRenewalExist = Renewal::wherePractitioner_idAndRenewal_period_id($practitioner->id, $renewal_period_id)->first();
                if ($checkRenewalExist) {
                    $checkRenewalExist->update([
                        'placement' => 1,
                    ]);
                }
                return back()->with('message', 'Placement letter uploaded successfully ');
            } else {
                return back()->with('message', 'Placement letter could not be uploaded');

            }
        }


    }

    //view placement letter
    public function viewPlacement($id){
        $placement = PractitionerPlacement::find($id);
        return view('admin.practitioner_placement.view',compact('placement'));
    }

    //invoice balance
    public function invoiceBalances(Practitioner $practitioner)
    {
        $vat = Vat::where('id', 1)->first();
        $renewal_fee = RenewalFee::whereRenewal_category_idAndProfession_id($practitioner->renewal_category_id, $practitioner->profession_id)->first();

        $fee = ($renewal_fee->fee * $vat->vat) + $renewal_fee->fee;


        return view('admin.practitioner_payments.renewal_invoice_balances', compact('practitioner', 'fee'));
    }

    //invoice Renewals
    public function invoiceRenewal(Practitioner $practitioner)
    {
        $vat = Vat::where('id', 1)->first();
        $renewal_fee = RenewalFee::whereRenewal_category_idAndProfession_id($practitioner->renewal_category_id, $practitioner->profession_id)->first();

        $fee = ($renewal_fee->fee * $vat->vat) + $renewal_fee->fee;
        return view('admin.practitioner_payments.renewal_invoice',
               compact('practitioner', 'renewal_fee', 'vat', 'fee'));

    }

}
