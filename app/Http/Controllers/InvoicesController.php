<?php

namespace App\Http\Controllers;

use App\Practitioner;
use App\RenewalFee;
use App\Vat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    //

    /*public function __construct()
    {
        $this->middleware('verified');
    }*/

    public function invoice()
    {
        $pdf = new \App\Invoice;
        $output = $pdf->generate();
        Storage::put('invoice.pdf', $output);

    }

    public function downloadInvoice()
    {
        $payment = "test";
        $user = 2;
        $pdf = new \App\Invoice;
        $output = $pdf->generate();
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="invoice.pdf"'
        ];

        return response($output)->withHeaders($headers);
    }

    public function viewInvoice(Practitioner $practitioner)
    {
        $pdf = new \App\Invoice;
        $output = $pdf->generate();
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="invoice.pdf"'
        ];
        return response($output)->withHeaders($headers);
    }

    public function shortCodeInvoice(Practitioner $practitioner)
    {

        $vat = Vat::where('id', 1)->first();

        $renewal_fee = RenewalFee::whereRenewal_category_idAndProfession_id($practitioner->renewal_category_id, $practitioner->profession_id)->first();

        $fee = ($renewal_fee->fee * $vat->vat) + $renewal_fee->fee;

        $pdf = new \App\Invoice;

        $pdf->generate($practitioner,$vat,$fee,$renewal_fee);
    }
}
