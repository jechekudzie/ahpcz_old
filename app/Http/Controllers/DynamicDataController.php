<?php

namespace App\Http\Controllers;

use App\Accreditation;
use App\City;
use App\DiscreditedInstitution;
use App\District;
use App\PaymentItem;
use App\PaymentItemFee;
use App\Practitioner;
use App\Prefix;
use App\Profession;
use App\ProfessionalQualification;
use App\Renewal;
use http\Client\Response;
use Illuminate\Http\Request;

class DynamicDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*public function __construct()
    {
        $this->middleware('verified');
    }*/

    public function districts($province_id)
    {

        $districts = City::where('province_id', $province_id)->get();

        $response = "<option value=''>Select District</option>";
        foreach ($districts as $district) {
            $response .= '<option value=' . $district->id . '>' . $district->name . '</option>';
        }

        echo $response;


    }


    public function districtEdit($province_id,$my_id)
    {
        $districts = City::where('province_id', $province_id)->get();

        $response = "<option value=''>Select District</option>";
        foreach ($districts as $district) {

            if($district->id == $my_id) {

                $response .= '<option value=' . $district->id . ' selected>' . $district->name . '</option>';
            }
            else{
                $response .= '<option value=' . $district->id . '>' . $district->name . '</option>';

            }
        }

        echo $response;


    }

    public function professionalQualifications($profession_id)
    {
        $professional_qualifications = ProfessionalQualification::where('profession_id', $profession_id)->get();

        $response = "<option value=''>Select Professional Qualification</option>";
        foreach ($professional_qualifications as $professional_qualification) {
            $response .= '<option value=' . $professional_qualification->id . '>' . $professional_qualification->name . '</option>';
        }
        echo $response;

    }

    public function professionalQualificationsEdit($profession_id,$pq_id)
    {
        $professional_qualifications = ProfessionalQualification::where('profession_id', $profession_id)->get();

        $response = "<option value=''>Select Professional Qualification</option>";
        foreach ($professional_qualifications as $professional_qualification) {
            if($professional_qualification->id == $pq_id){

                $response .= '<option value=' . $professional_qualification->id . ' selected>' . $professional_qualification->name . '</option>';

            }else{
                $response .= '<option value=' . $professional_qualification->id . '>' . $professional_qualification->name . '</option>';

            }
        }
        echo $response;

    }


    public function accreditedInstitutions($professional_qualification_id)
    {

        $accredited_institutions = Accreditation::where('professional_qualification_id', $professional_qualification_id)->get();

        $response = "<option value=''>Select Accredited Institutions</option>";

        foreach ($accredited_institutions as $accredited_institution) {
            $response .= '<option value=' . $accredited_institution->accredited_institution_id . '>' . $accredited_institution->accreditedInstitution->name . '</option>';
        }

        echo $response;

    }



    public function accreditedInstitutionsEdit($professional_qualification_id,$accreInst_id)
    {
        $accredited_institutions = Accreditation::where('professional_qualification_id', $professional_qualification_id)->get();

        $response = "<option value=''>Select Accredited Institutions</option>";

        foreach ($accredited_institutions as $accredited_institution) {
            if($accredited_institution->accredited_institution_id == $accreInst_id)
            {
                $response .= '<option value=' . $accredited_institution->accredited_institution_id . ' selected>' . $accredited_institution->accreditedInstitution->name . '</option>';

            }else{
                $response .= '<option value=' . $accredited_institution->accredited_institution_id . '>' . $accredited_institution->accreditedInstitution->name . '</option>';

            }
        }

        echo $response;

    }

    public function search($txt)
    {
        $response = '';

        $discredited_institutions = DiscreditedInstitution::where('name', 'LIKE', "%{$txt}%")->get();

        $response .= '<table style="width:100%;border-spacing: 5px;">
                          <tr>
                            <th style="text-align:left">University name</th>
                            <th style="text-align:left">Status</th>
                          </tr>

                    ';
        foreach ($discredited_institutions as $discredited_institution) {

            $response .= '<tr>
                            <td style="text-align:left">'.$discredited_institution->name.'</td>
                            <td style="text-align:left">Discredited</td>
                          </tr>
                          ';

        }
        $response.='</table>';
        echo $response;


    }

    public function districtsEdit($province_id)
    {

        $districts = City::where('province_id', $province_id)->get();


        $response = "<option value=''>Select District</option>";
        foreach ($districts as $district) {

            $response .= '<option value=' . $district->id . '>' . $district->name . '</option>';
        }

        echo $response;


    }


//get payment items based on category
    public function paymentItem($payment_item_category_id)
    {

        $paymentItems= PaymentItem::where('payment_item_category_id', $payment_item_category_id)->get();

        $response = "<option value=''>Select Payment Items</option>";
        foreach ($paymentItems as $paymentItem) {
            $response .= '<option value=' . $paymentItem->id . '>' . $paymentItem->name . '</option>';
        }

        echo $response;


    }

    //get the payment item fee
    public function paymentItemFee($payment_item_id,Renewal $renewal)
    {

        $fee = PaymentItem::Where('id',$payment_item_id )->first();

        $response = "";

        if($payment_item_id == 33 || $payment_item_id == 34){
            $amount_invoiced  = $renewal->balance;
            $response.=$amount_invoiced;

        }
        else{
            $amount_invoiced  = ($fee->fee *0.15) + $fee->fee;
            $response.=$amount_invoiced;
        }

        echo $response;


    }





}
