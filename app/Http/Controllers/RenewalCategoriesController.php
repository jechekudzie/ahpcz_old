<?php

namespace App\Http\Controllers;

use App\CpdCriteria;
use App\EmploymentLocation;
use App\EmploymentStatus;
use App\Profession;
use App\RenewalCategory;
use App\RenewalCriteria;
use Illuminate\Http\Request;

class RenewalCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
        $renewal_categories = RenewalCategory::all()->sortBy('name');
        $employment_statuses = EmploymentStatus::all()->sortBy('name');
        $employment_locations = EmploymentLocation::all()->sortBy('name');
        $renewal_criteria = RenewalCriteria::all();
        $professions = Profession::all()->sortBy('name');
        $cpd_criterias = CpdCriteria::all()->sortByDesc('renewal_category_id');
        return view('admin.renewal_categories.index',
            compact('renewal_categories','employment_statuses',
                'employment_locations','renewal_criteria','professions','cpd_criterias'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.renewal_categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        RenewalCategory::create(request()->validate([
            'name' => ['required'],
            'description' => ['required', 'min:10']
        ]));

        $message = "Renewal Category added successfully.";
        return view('admin.renewal_categories.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RenewalCategory $renewalCategory)
    {
        //
        return view('admin.renewal_categories.show',compact('renewalCategory'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RenewalCategory $renewalCategory)
    {
        //
        return view('admin.renewal_categories.edit',compact('renewalCategory'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RenewalCategory $renewalCategory)
    {
        //
        //update the record with the ID provided
        $renewalCategory->update(request()->validate([
            'name' => ['required'],
            'description' => ['required','min:10']
        ]));

        return redirect('/admin/renewal_categories')->with('message','Renewal Category updated successfully.');



    }


    public function destroy(RenewalCategory $renewalCategory)
    {
        //
        $renewalCategory->delete();
        return redirect('/admin/renewal_categories')->with('message','Renewal category deleted successfully.');

    }

}
