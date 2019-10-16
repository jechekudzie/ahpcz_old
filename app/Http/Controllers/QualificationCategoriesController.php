<?php

namespace App\Http\Controllers;

use App\QualificationCategory;
use Illuminate\Http\Request;

class QualificationCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $qualification_categories = QualificationCategory::all()->sortBy('name');
        return view('admin.qualification_categories.index',compact('qualification_categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Display the create qualification category form
        return view('admin.qualification_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        QualificationCategory::create(request()->validate([
            'name' => ['required'],
            'description' => ['required', 'min:10']
        ]));

        $message = "Qualification Category added successfully.";
        return view('admin.qualification_categories.create',compact('message'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(QualificationCategory $qualificationCategory)
    {
        //
        return view('admin.qualification_categories.show',compact('qualificationCategory'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(QualificationCategory $qualificationCategory)
    {
        //
        return view('admin.qualification_categories.edit',compact('qualificationCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QualificationCategory $qualificationCategory)
    {
        //update the record with the ID provided
        $qualificationCategory->update(request()->validate([
            'name' => ['required'],
            'description' => ['required','min:10']
        ]));

        return redirect('/admin/qualification_categories')->with('message','Qualification Category updated successfully.');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualificationCategory $qualificationCategory)
    {
        //
        $qualificationCategory->delete();
        return redirect('/admin/qualification_categories')->with('message','Qualification category deleted successfully.');

    }
}
