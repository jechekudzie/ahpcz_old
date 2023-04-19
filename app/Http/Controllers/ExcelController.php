<?php

namespace App\Http\Controllers;

use App\Exports\PractExport;
use App\Imports\PractImport;
use App\Pract;
use App\Practitioner;
use App\PractitionerPaymentInformation;
use App\Profession;
use App\RegisterCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    //
    public function importExportView()
    {
        return view('import');
    }

    public function import(Request $request)
    {
        $path = $request->file('file')->getRealPath();

        $path1 = $request->file('file')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        $data = \Excel::import(new PractImport, $path);

        $results = Pract::all();
        return $results;

    }

    public function export()
    {
        return Excel::download(new PractExport(), 'users.xlsx');
    }

    //get data and update renewal items
    public function update_practitioners(Request $request)
    {
        $on_list = array();
        $not_on_list = array();
        $data = collect();
        $practs = Pract::all();
        foreach ($practs as $pract) {
            $profession = $pract->profession;
            $practitioner = Practitioner::whereRaw("CONCAT(prefix, '',registration_number) = ?", $pract->reg_number)->first();
            if ($practitioner != null) {
                $on_list[] = $pract;
            } else {
                $data->push($pract);
                $not_on_list[] = $pract;
            }

        }
        return Excel::download(new PractExport($data), 'notinsystem.xlsx');

        /* echo json_encode($on_list);
         echo 'System match ' . count($on_list) . ' not in the system ' . count($not_on_list);*/

    }

    public function update_practitioner_renewal(Request $request)
    {
        $on_list = array();
        $not_on_list = array();

        $with_renewal = array();
        $without_renewal = array();
        $data = collect();
        $practs = Pract::all();
        foreach ($practs as $pract) {
            $profession = $pract->profession;
            $practitioner = Practitioner::whereRaw("CONCAT(prefix,'',registration_number) = ?", $pract->reg_number)
                ->first();
            if ($practitioner != null) {
                if ($practitioner->renewals->where('renewal_period_id', 2021)->first()) {
                    $renewal = $practitioner->renewals->where('renewal_period_id', 2021)->first();
                    $with_renewal[] = $renewal->practitioner;
                    $data->push($renewal->practitioner);

                    //update register category
                    if ($practitioner->practitioner_payment_information) {
                        $register_category = RegisterCategory::where('name', $pract->register)->first();
                        $practitioner->practitioner_payment_information->update([
                            'register_category_id' => $register_category->id
                        ]);
                    }

                    //first update practitioner contents
                    $practitioner->update([
                        'registration_officer' => 2,
                        'member' => 1,
                        'accountant' => 2,
                        'registrar' => 1,
                    ]);
                    $renewal->update([
                        'renewal_status_id' => 1,
                        'placement' => 1,
                        'cdpoints' => 1,
                        'certificate' => 2,
                        'balance' => 0,
                        'certificate_request' => 1,
                        'currency' => 0,
                        'payment_type_id' => 1,
                    ]);
                    foreach ($practitioner->payments as $existing_payment) {
                        $existing_payment->update([
                            'balance' => 0,
                            'payment_item_id' => 33,
                        ]);
                    }
                } else {
                    $without_renewal[] = $practitioner;
                    $data->push($practitioner);
                    //update register category
                    if ($practitioner->practitioner_payment_information) {
                        $register_category = RegisterCategory::where('name', $pract->register)->first();
                        $practitioner->practitioner_payment_information->update([
                            'register_category_id' => $register_category->id
                        ]);
                    }
                    //first update practitioner contents
                    $practitioner->update([
                        'registration_officer' => 2,
                        'member' => 1,
                        'accountant' => 2,
                        'registrar' => 1,
                    ]);
                    $renewal = $practitioner->addRenewal([
                        'renewal_period_id' => 2021,
                        'practitioner_id' => $practitioner->id,
                        'payment_method_id' => 1,
                        'renewal_category_id' => 1,
                        'renewal_status_id' => 1,
                        'placement' => 1,
                        'cdpoints' => 1,
                        'certificate' => 2,
                        'balance' => 0,
                        'certificate_request' => 1,
                        'currency' => 0,
                        'payment_type_id' => 1,
                    ]);
                    $renewal->addPayments([
                        'renewal_period_id' => 2021,
                        'practitioner_id' => $practitioner->id,
                        'payment_date' => now(),
                        'month' => date('m'),
                        'day' => date('d'),
                        'payment_channel_id' => 1,
                        'amount_invoiced' => 0,
                        'amount_paid' => 0,
                        'payment_item_id' => 33,
                        'payment_item_category_id' => 1,
                        'balance' => 0,
                    ]);
                }
            }
        }

        return Excel::download(new PractExport($data), 'withrenewals.xlsx');

    }

    //update renewal
    public function update_practitioner_registration(Request $request)
    {
        $on_list = array();
        $not_on_list = array();

        $with_renewal = array();
        $without_renewal = array();
        $data = collect();
        $practs = Pract::all();

        foreach ($practs as $pract) {
            $first_name = $pract->first_name;
            $last_name = $pract->last_name;
            $prefix = $pract->prefix;
            $number = $pract->number;
            //get profession
            $profession = Profession::where('name', $pract->profession)->first();

            //get register
            $register_category = RegisterCategory::where('name', $pract->register)->first();

            $practitioner = Practitioner::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'prefix' => $prefix,
                'registration_number' => $number,
                'profession_id' => $profession->id,
            ]);

            //first update practitioner contents
            $practitioner->update([
                'registration_officer' => 2,
                'member' => 1,
                'accountant' => 2,
                'registrar' => 1,
                'approval_status' => 1,
            ]);

           //update payment information = register category
            PractitionerPaymentInformation::create([
                'practitioner_id' => $practitioner->id,
                'register_category_id'=>$register_category->id
            ]);

            //add renewal
            $renewal = $practitioner->addRenewal([
                'renewal_period_id' => 2021,
                'practitioner_id' => $practitioner->id,
                'payment_method_id' => 1,
                'renewal_category_id' => 1,
                'renewal_status_id' => 1,
                'placement' => 1,
                'cdpoints' => 1,
                'certificate' => 2,
                'balance' => 0,
                'certificate_request' => 1,
                'currency' => 0,
                'payment_type_id' => 1,
            ]);

            //add renewal payment
            $renewal->addPayments([
                'renewal_period_id' => 2021,
                'practitioner_id' => $practitioner->id,
                'payment_date' => now(),
                'month' => date('m'),
                'day' => date('d'),
                'payment_channel_id' => 1,
                'amount_invoiced' => 0,
                'amount_paid' => 0,
                'payment_item_id' => 33,
                'payment_item_category_id' => 1,
                'balance' => 0,
            ]);

            //save to list of processed data
            $data->push($practitioner);

        }

        return Excel::download(new PractExport($data), 'newdata.xlsx');

    }


    public function auto_renewal(Practitioner $practitioner)
    {
        $on_list = array();
        $not_on_list = array();

        $with_renewal = array();
        $without_renewal = array();
        $data = collect();
        $practs = Pract::all();
        foreach ($practs as $pract) {
            $profession = $pract->profession;
            $practitioner = Practitioner::whereRaw("CONCAT(prefix,'',registration_number) = ?", $pract->reg_number)
                ->first();
            if ($practitioner != null) {
                if ($practitioner->renewals->where('renewal_period_id', 2021)->first()) {
                    $renewal = $practitioner->renewals->where('renewal_period_id', 2021)->first();
                    $with_renewal[] = $renewal->practitioner;
                    $data->push($renewal->practitioner);

                    //update register category
                    if ($practitioner->practitioner_payment_information) {
                        $register_category = RegisterCategory::where('name', $pract->register)->first();
                        $practitioner->practitioner_payment_information->update([
                            'register_category_id' => $register_category->id
                        ]);
                    }

                    //first update practitioner contents
                    $practitioner->update([
                        'registration_officer' => 2,
                        'member' => 1,
                        'accountant' => 2,
                        'registrar' => 1,
                    ]);
                    $renewal->update([
                        'renewal_status_id' => 1,
                        'placement' => 1,
                        'cdpoints' => 1,
                        'certificate' => 2,
                        'balance' => 0,
                        'certificate_request' => 1,
                        'currency' => 0,
                        'payment_type_id' => 1,
                    ]);
                    foreach ($practitioner->payments as $existing_payment) {
                        $existing_payment->update([
                            'balance' => 0,
                            'payment_item_id' => 33,
                        ]);
                    }
                } else {
                    $without_renewal[] = $practitioner;
                    $data->push($practitioner);
                    //update register category
                    if ($practitioner->practitioner_payment_information) {
                        $register_category = RegisterCategory::where('name', $pract->register)->first();
                        $practitioner->practitioner_payment_information->update([
                            'register_category_id' => $register_category->id
                        ]);
                    }
                    //first update practitioner contents
                    $practitioner->update([
                        'registration_officer' => 2,
                        'member' => 1,
                        'accountant' => 2,
                        'registrar' => 1,
                    ]);
                    $renewal = $practitioner->addRenewal([
                        'renewal_period_id' => 2021,
                        'practitioner_id' => $practitioner->id,
                        'payment_method_id' => 1,
                        'renewal_category_id' => 1,
                        'renewal_status_id' => 1,
                        'placement' => 1,
                        'cdpoints' => 1,
                        'certificate' => 2,
                        'balance' => 0,
                        'certificate_request' => 1,
                        'currency' => 0,
                        'payment_type_id' => 1,
                    ]);
                    $renewal->addPayments([
                        'renewal_period_id' => 2021,
                        'practitioner_id' => $practitioner->id,
                        'payment_date' => now(),
                        'month' => date('m'),
                        'day' => date('d'),
                        'payment_channel_id' => 1,
                        'amount_invoiced' => 0,
                        'amount_paid' => 0,
                        'payment_item_id' => 33,
                        'payment_item_category_id' => 1,
                        'balance' => 0,
                    ]);
                }
            }
        }

        return Excel::download(new PractExport($data), 'withrenewals.xlsx');

    }




}


