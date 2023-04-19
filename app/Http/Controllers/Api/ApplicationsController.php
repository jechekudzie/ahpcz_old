<?php

namespace App\Http\Controllers\Api;

use App\Application;
use App\ApplicationDocument;
use App\Http\Controllers\Controller;
use App\PaymentItem;
use App\PaymentItemCategory;
use App\Practitioner;
use App\Rate;
use App\Renewal;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    //

    public function payment_item_categories()
    {
        $payment_item_categories = PaymentItemCategory::whereNotIn('id', [1, 2])->get();
        foreach ($payment_item_categories as $payment_item_category) {
            if ($payment_item_category->paymentItems) {
                $payment_item_category->paymentItems;
            }
        }
        return response()->json([
            'payment_item_categories' => $payment_item_categories,
        ]);
    }

    public function payment_items(PaymentItemCategory $paymentItemCategory)
    {
        if ($paymentItemCategory->paymentItems) {
            $paymentItemCategory->paymentItems;
        }
        return response()->json([
            'payment_item_category' => $paymentItemCategory,
        ]);

    }

    public function payment_item(PaymentItem $paymentItem)
    {
        if ($paymentItem->payment_item_requirements) {
            $paymentItem->payment_item_requirements;
        }
        $rate = Rate::find(1)->rate;
        return response()->json([
            'payment_item' => $paymentItem,
            'rate' => $rate,
        ]);

    }

    public function make_application_payment()
    {
        $data = request()->validate([
            'practitioner_id' => 'required',
            'amount_invoiced' => 'required',
            'amount_paid' => 'required',
            'currency' => 'required',
            'payment_channel_id' => 'required',
            'payment_item_category_id' => 'required',
            'payment_item_id' => 'required',
            'period' => 'required',
            'rate' => 'required',
            'pop' => 'nullable',
        ]);

        $practitioner = Practitioner::find($data['practitioner_id']);

        $pop = '';
        $status = 0;
        $balance = $data['amount_invoiced'] - $data['amount_paid'];
        //save renewal_balance in USD
        if ($data['currency'] == 1) {
            $balance = $balance;
        }
        if ($data['currency'] == 0) {
            $balance = $balance / $data['rate'];
        }
        if ($renewal = Renewal::where('practitioner_id', $practitioner->id)->where('renewal_period_id', $data['period'])->first()) {
            $status = 1;
            //get Pop
            if (request()->hasfile('pop')) {
                //get the file field data and name field from form submission
                $file = request()->file('pop');

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;

                //upload the file to a directory in Public folder
                $pop = $file->move('pops', $file_name);
            }

            $payments['renewal_period_id'] = $data['period'];
            $payments['renewal_id'] = $renewal->id;
            $payments['month'] = date('m');
            $payments['day'] = date('d');
            $payments['practitioner_id'] = $practitioner->id;
            $payments['balance'] = $balance;
            $payments['amount_invoiced'] = $data['amount_invoiced'];
            $payments['amount_paid'] = $data['amount_paid'];
            $payments['payment_channel_id'] = $data['payment_channel_id'];
            $payments['rate'] = $data['rate'];
            $payments['currency'] = $data['currency'];
            $payments['payment_item_category_id'] = $data['payment_item_category_id'];
            $payments['payment_date'] = now();
            $payments['payment_item_id'] = $data['payment_item_id'];
            $payments['proof'] = $pop;
            $add_renewal_payment = $renewal->addPayments($payments);


            $application['practitioner_id'] = $add_renewal_payment->practitioner_id;
            $application['payment_item_id'] = $add_renewal_payment->payment_item_id;
            $application['payment_id'] = $add_renewal_payment->id;
            if ($balance > 0) {
                $application['payment_status'] = 3;
            } else {
                $application['payment_status'] = 1;
            }
            $add_application = Application::create($application);
            if ($add_application->payment_item) {
                if ($add_application->payment_item->payment_item_requirements) {
                    $add_application->payment_item->payment_item_requirements;
                }
            }
            //update previous balances to 0
            if ($balance > 0) {
                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }
            } else {
                if (count($practitioner->payments)) {
                    foreach ($practitioner->payments as $existing_payment) {
                        if ($existing_payment->id != $add_renewal_payment->id) {
                            $existing_payment->update(['balance' => 0]);
                            $existing_payment->renewal->update(['balance' => 0]);
                            $existing_payment->renewal->update(['renewal_status_id' => 1]);
                        }
                    }
                }
            }

            return response()->json([
                'response_status' => 1,
                'message' => 'Application payment was successful.',
                'application' => $add_application,
            ]);
        }
        else {
            return response()->json([
                'response_status' => 0,
                'message' => 'You can not proceed with this payment because you do not have
                a current renewal subscription.',
                'practitioner_id'=>$practitioner->id,
            ]);
        }
    }

    public function submit_documents()
    {
        $application_id = request('application_id');
        $payment_item_id = request('payment_item_id');
        $payment_item = PaymentItem::where('id', request('payment_item_id'))->first();
        $payment_item_requirements = $payment_item->payment_item_requirements;

        $get_files = array();
        $file_name = '';

        if (request()->hasfile('file')) {

            $files = request()->file('file');
            //get the file field data and name field from form submission

            foreach ($files as $file) {

                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name = time() . $name;
                $path = $file->move('application_documents', $file_name);
                $get_files[] = $path;
            }
            //upload the file to a directory in Public folder

            foreach ($payment_item_requirements as $k => $payment_item_requirement) {
                ApplicationDocument::create([
                    'application_id' => $application_id,
                    'payment_item_id' => $payment_item_id,
                    'payment_item_requirement_id' => $payment_item_requirement->id,
                    'path' => $get_files[$k],
                ]);
            }

        }
        return response()->json([
            'response_status' => 1,
            'message' => 'Application documents were successfully uploaded. Will let you know once verification process is complete.',
            'application' => $application_id,
        ]);
    }



}
