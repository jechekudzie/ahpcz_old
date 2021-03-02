<?php

namespace App\Http\Controllers;

use App\CpdCriteria;
use App\EmploymentStatus;
use App\Profession;
use Illuminate\Http\Request;

class CpdCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $professions = Profession::all()->sortBy('name');
        return view('admin.cpd_criterias.index', compact( 'professions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Profession $profession)
    {
        //
        $check = CpdCriteria::where('profession_id',$profession->id)->first();

        $employment_statuses = EmploymentStatus::all();
        return view('admin.cpd_criterias.create', compact('employment_statuses', 'profession','check'));
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
        $employment_statuses = request('item');
        $profession = request('profession');
        $profession_id = request('profession_id');

       // dd($employment_statuses);
        foreach ($employment_statuses as $employment_status) {
            $cpd_criteria['profession_id'] = $employment_status['profession_id'];
            $cpd_criteria['employment_status_id'] = $employment_status['employment_status_id'];
            $cpd_criteria['points'] = $employment_status['points'];
            CpdCriteria::create($cpd_criteria);
        }

        return redirect('admin/cpd_criterias/index')->with('message',$profession.' CPD Criteria added successfully');
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
