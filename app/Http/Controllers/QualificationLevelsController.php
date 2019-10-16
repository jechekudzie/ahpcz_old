<?php

namespace App\Http\Controllers;

use App\QualificationLevel;
use Illuminate\Http\Request;

class QualificationLevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $qualification_levels = QualificationLevel::all()->sortBy('name');
        return view('admin.qualification_levels.index',compact('qualification_levels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.qualification_levels.create');
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
        QualificationLevel::create(request()->validate([
            'name' => ['required']
        ]));

        $message = 'Qualification level added successfully';
        return view('admin.qualification_levels.create',compact('message'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(QualificationLevel $qualificationLevel)
    {
        //
        return view('admin.qualification_levels.show',compact('qualificationLevel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(QualificationLevel $qualificationLevel)
    {
        //
        return view('admin.qualification_levels.edit',compact('qualificationLevel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QualificationLevel $qualificationLevel)
    {
        //
        $qualificationLevel->update(request()->validate([
            'name' => ['required']
        ]));
        return redirect('/admin/qualification_levels')->with('message','Qualification level updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualificationLevel $qualificationLevel)
    {
        //
        $qualificationLevel->delete();
        return redirect('/admin/qualification_levels')->with('message','Qualification level deleted successfully.');

    }
}
