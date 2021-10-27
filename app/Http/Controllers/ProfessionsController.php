<?php

namespace App\Http\Controllers;

use App\CdPoint;
use App\Prefix;
use App\Profession;

use Illuminate\Http\Request;

class ProfessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cdpoints = CdPoint::all()->sortByDesc('points');
        $prefixes = Prefix::all()->sortBy('name');
        $professions = Profession::all()->sortBy('name');


        return view('admin.professions.index',
            compact('professions','prefixes','cdpoints'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.professions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Profession::create(request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'plural' => ['required']
        ]));

        $message = "Profession added successfully.";
        return view('admin.professions.create',compact('message'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Profession $profession)
    {
        return view('admin.professions.show',compact('profession'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Profession $profession)
    {

        return view('admin.professions.edit',compact('profession'));

    }

    /**
     * Update the specified resource in storage.
     *x
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Profession $profession)
    {
        //update the profession
        $profession->update(request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'plural' => ['required']
        ]));


        return redirect('/admin/professions')->with('message','Profession updated successfully.');

        //return response()->view('admin.professions.edit',compact('profession','message'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profession $profession)
    {
        //
        $profession->delete();
        return redirect('/admin/professions')->with('message','Profession deleted successfully.');

    }
}
