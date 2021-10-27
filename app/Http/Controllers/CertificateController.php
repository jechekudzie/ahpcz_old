<?php

namespace App\Http\Controllers;

use App\Practitioner;
use App\Renewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
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
               $register_category = $practitioner->practitioner_payment_information->register_category->description;
            }else{
                $register_category = 'Nill';
            }
        }
        $qr_code = QrCode::size(150)->generate('http://ahpcz.co.zw/verify_certificate/' . $practitioner->id);
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

    public function manual_certificate(Renewal $renewal)
    {
        $practitioner = $renewal->practitioner;
        $register_category = '';
        if($practitioner->practitioner_payment_information){
            if($practitioner->practitioner_payment_information->register_category){
               $register_category = $practitioner->practitioner_payment_information->register_category->description;
            }else{
                $register_category = 'Nill';
            }
        }
        $qr_code = QrCode::size(150)->generate('http://ahpcz.co.zw/verify_certificate/' . $practitioner->id);
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

    public function registration_certificate(Practitioner $practitioner)
    {

        $register_category = '';
        if($practitioner->practitioner_payment_information){
            if($practitioner->practitioner_payment_information->register_category){
               $register_category = $practitioner->practitioner_payment_information->register_category->description;
               $register_name = $practitioner->practitioner_payment_information->register_category->name;
                $register_prefix = $practitioner->practitioner_payment_information->register_category->registration;
                //$plural_profession = Str::plural($practitioner->profession->name);

            }else{
                $register_category = 'Nill';
                $register_name = 'Nill';
                $register_prefix = 'Nill';
                //$plural_profession = '';
            }
        }
        $qr_code = QrCode::size(150)->generate('http://ahpcz.co.zw/verify_certificate/' . $practitioner->id);
        $html = '<img src="data:image/svg+xml;base64,' . base64_encode($qr_code) . '"  width="100" height="100" />';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(view('registration_certificate')
            ->with('html', $html)
            ->with('practitioner', $practitioner)
            ->with('register_category', $register_category)
            ->with('register_prefix', $register_prefix)
            ->with('register_name', $register_name))
            ->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function id_card(Renewal $renewal)
    {
        $practitioner = $renewal->practitioner;
        $register_category = '';
        if($practitioner->practitioner_payment_information){
            if($practitioner->practitioner_payment_information->register_category){
               $register_category = $practitioner->practitioner_payment_information->register_category->description;
            }else{
                $register_category = 'Nill';
            }
        }
        $qr_code = QrCode::size(150)->generate('http://ahpcz.co.zw/verify_certificate/' . $practitioner->id);
        $html = '<img src="data:image/svg+xml;base64,' . base64_encode($qr_code) . '"  width="50" height="50" />';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(view('id_card')
            ->with('html', $html)
            ->with('practitioner', $practitioner)
            ->with('register_category', $register_category)
            ->with('renewal', $renewal))
            ->setPaper('a6', 'landscape');
        return $pdf->stream();
    }

    public function student_confirmation(Practitioner $practitioner)
    {
        $qualification = '';
        $university = '';
       if($practitioner->practitionerQualifications){
            $qualification_details = $practitioner->practitionerQualifications->first();
            $qualification = $qualification_details->professionalQualification->name;

            if($qualification_details->qualification_category_id == 1){

                $university = $qualification_details->accreditedInstitution->name;

            }
        }
        $register_category = '';
        if($practitioner->practitioner_payment_information){
            if($practitioner->practitioner_payment_information->register_category){
               $register_category = $practitioner->practitioner_payment_information->register_category->description;
            }else{
                $register_category = 'Nill';
            }
        }
        $qr_code = QrCode::size(150)->generate('http://ahpcz.co.zw/verify_certificate/' . $practitioner->id);
        $html = '<img src="data:image/svg+xml;base64,' . base64_encode($qr_code) . '"  width="50" height="50" />';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(view('student_confirmation')
            ->with('html', $html)
            ->with('practitioner', $practitioner)
            ->with('register_category', $register_category)
            ->with('qualification', $qualification)
            ->with('university', $university))
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
