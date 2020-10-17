<?php

namespace App\Http\Controllers;

use App\Practitioner;
use App\Prefix;
use App\ProfessionalQualification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\BinaryOp\Concat;

class APIController extends Controller
{
    public function index(Request $request)
    {
        $practitioners = Practitioner::all();
        $users = User::all();

        if ($request->is('api/json/practitioners')) {
            return response()->json([
                'practitioners' => $practitioners->toArray(),
                'users' => $users->toArray()
            ]);

        }


    }

    public function show(Request $request, Practitioner $practitioner)
    {
        //get practitioner current renewal infor
        $practitioner->profession;
        $practitioner->currentRenewal;
        $practitioner->professionalQualification;

        if ($request->is('/api/json/practitioners/' . $practitioner->id)) {
            return response()->json([
                'practitioners' => $practitioner->toArray(),
            ]);

        }


    }


    ///registration number digit only
    public function byRegID(Request $request, $registration_number, $id_number)
    {
        $result = Practitioner::whereRegistrationNumberAndIdNumber($registration_number, $id_number)->first();

        //convert practitioner array to eloquent model
        $practitioner = Practitioner::find($result->id);

        //get practitioner current renewal infor
        $practitioner->profession;
        $practitioner->currentRenewal;
        $practitioner->professionalQualification;


        if ($request->is('api/json/practitioners/' . $registration_number . '/' . $id_number)) {
            return response()->json([
                'practitioners' => $practitioner->toArray(),

            ]);

        }


    }


    //registration number string
    public function byRegString(Request $request, $registration_number)
    {
        $registration = str_replace('*', '/', $registration_number);

        $result = Practitioner::whereRaw("CONCAT(`prefix`, `registration_number`) = ?", [$registration])->first();

        //convert practitioner array to eloquent model
        $practitioner = Practitioner::find($result->id);

        //get practitioner current renewal infor
        $practitioner->profession;
        $practitioner->currentRenewal;
        $practitioner->professionalQualification;


        if ($practitioner != null) {

            if ($request->is('api/json/practitioner_reg_number/' . $registration_number)) {
                return response()->json([
                    'practitioner' => $practitioner->toArray(),
                ]);

            }
        } else {
            return response()->json([
                'message' => "Details do not match our record, please check registration and id "
            ]);
        }


    }


    public function byRegIdString(Request $request, $registration_number, $id_number)
    {
        $registration = str_replace('*', '/', $registration_number);

        $result = Practitioner::whereRaw("CONCAT(`prefix`, `registration_number`) = ? AND id_number = ?", [$registration, $id_number])->first();

        //convert practitioner array to eloquent model
        $practitioner = Practitioner::find($result->id);

        //get practitioner current renewal infor
        $practitioner->profession;
        $practitioner->currentRenewal;
        $practitioner->professionalQualification;


        if ($practitioner != null) {
            if ($request->is('api/json/practitioner_string/' . $registration_number . '/' . $id_number)) {
                return response()->json([
                    'practitioner' => $practitioner->toArray(),
                ]);

            }
        } else {
            return response()->json([
                'message' => "Details do not match our record, please check registration and id "
            ]);
        }


    }






    public function testBoth()
    {

        $reg_number = "A/PSY0412";
        $id_number  = "63915996H26";

        /*$reg_number = "A/AT0004";
        $id_number  = "43125772P";*/

        $reg_number = strtoupper($reg_number);
        $id_number = strtoupper($id_number);

        $fa = str_replace("/", "*", $reg_number);

        return redirect('/api/json/practitioner_string/' . $fa.'/'.$id_number);

    }

    public function testSingle()
    {

        $pqs = Prefix::all();

        foreach ($pqs as $pq){
            echo '["id"=>"'.$pq->id.'","profession_id"=>"'.$pq->profession_id.'","name"=>"'.$pq->name.'","created_at"=>now(),"updated_at"=>now()],<br/>';

        }


        //$reg_number = "A/SU0026";

        //$reg_number = "A/AT0115";

        //$reg_number = "A/AT0004";


        //$reg_number = strtoupper($reg_number);


        //$fa = str_replace("/", "*", $reg_number);

        //return redirect('/api/json/practitioner_reg_number/' . $fa);


    }

}
