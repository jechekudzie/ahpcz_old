<?php

namespace App\Http\Controllers;

use App\Renewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

//Use Barryvdh\DomPDF\PDF;
use PDF;

class CertificateController extends Controller
{
    //
    public function certificate(Renewal $renewal)
    {
        $practitioner = $renewal->practitioner;
        $register_category = '';
        if($practitioner->practitioner_payment_information){
            if($practitioner->practitioner_payment_information->register_category){
               $register_category = $practitioner->practitioner_payment_information->register_category->name;
            }else{
                $register_category = 'Nill';
            }
        }
        $qr_code = QrCode::size(150)->generate('http://portal.ahpcz.co.zw/verify_certificate/' . $practitioner->id);
        $html = '<img src="data:image/svg+xml;base64,' . base64_encode($qr_code) . '"  width="100" height="100" />';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(view('certificate')
            ->with('html', $html)
            ->with('practitioner', $practitioner)
            ->with('register_category', $register_category)
            ->with('renewal', $renewal))
            ->setPaper('a4', 'portrait');
        return $pdf->stream();
    }



   /* public function certificate(Renewal $renewal)
    {
        $practitioner = $renewal->practitioner;
        $qr_code = QrCode::size(150)->generate('http://portal.ahpcz.co.zw/verify_certificate/' . $practitioner->id);
        $html = '<img src="data:image/svg+xml;base64,' . base64_encode($qr_code) . '"  width="100" height="100" />';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(view('certificate')
            ->with('html', $html)
            ->with('practitioner', $practitioner)
            ->with('renewal', $renewal))
            ->setPaper('a4', 'portrait');
        return $pdf->stream();
    }*/


}
