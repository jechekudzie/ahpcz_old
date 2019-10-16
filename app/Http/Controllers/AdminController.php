<?php

namespace App\Http\Controllers;

use App\City;
use App\Nationality;
use App\OperationalStatus;
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

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('verified');
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
