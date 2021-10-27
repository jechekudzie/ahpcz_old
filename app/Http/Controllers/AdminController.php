<?php

namespace App\Http\Controllers;

use App\City;
use App\Nationality;
use App\OperationalStatus;
use App\Practitioner;
use App\Profession;
use App\Province;
use App\QualificationCategory;
use App\RegisterCategory;
use App\RegistrationFee;
use App\RenewalCategory;
use App\RenewalFee;
use App\RenewalStatus;
use App\StudentRegistrationFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //

        $professions = Profession::count();
        $qualification_categories = QualificationCategory::count();
        $register_categories = RegisterCategory::count();
        $renewal_categories = RenewalCategory::count();
        $renewal_statuses = RenewalStatus::count();
        $operational_statuses = OperationalStatus::count();
        $nationalities = Nationality::count();
        $provinces = Province::count();
        $cities = City::count();
        $registration_fees = RegistrationFee::count();
        $renewal_fees = RenewalFee::count();
        $student_registration_fees = StudentRegistrationFee::count();

        return view('admin.index', compact(
            'professions', 'qualification_categories',
            'register_categories', 'renewal_categories',
            'renewal_statuses', 'operational_statuses',
            'nationalities','provinces','cities','registration_fees',
            'renewal_fees','student_registration_fees'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Practitioner $practitioner, $id)
    {
        //
        return view('portal_permissions',compact('practitioner','id'));

    }

    public function portal_permissions()
    {
        //
        $practitioner_id = request('practitioner_id');
        $id = request('id');
        $response = Http::post('http://localhost:8000/api/practitioners/verify', [
            'practitioner_id' => $practitioner_id,
            'id' => $id,
        ]);

        if ($response->body()) {
            $data = json_decode($response);
            session()->flash('message', $data->message);
            return redirect('/admin/practitioners/'.$practitioner_id);
        }





    }


}
