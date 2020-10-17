<?php

namespace App\Http\Controllers;

use App\Prefix;
use App\Profession;
use Illuminate\Http\Request;

class PrefixesController extends Controller
{

    public function index()
    {
        //fetch all prefixes
        $prefixes = Prefix::all()->sortBy('name');
        return view('admin.prefixes.index', compact('prefixes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $professions = Profession::whereNotIn('id',[19])->get()->sortBy('name');

        return view('admin.prefixes.create', compact('professions'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        Prefix::create(request()->validate([
            'profession_id' => ['required'],
            'name' => ['required'],
            'last_reg' => ['required']
        ]));


        return redirect('/admin/prefixes/create')->with('message', 'Prefix added successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Prefix $prefix)
    {
        //
        return view('admin.prefixes.show', compact('prefix'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Prefix $prefix)
    {
        //
        $professions = Profession::whereNotIn('id',[19])->get()->sortBy('name');
        return view('admin.prefixes.edit', compact('prefix', 'professions'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Prefix $prefix)
    {
        //update the record with the ID provided
        $prefix->update(request()->validate([
            'profession_id' => ['required'],
            'name' => ['required'],
            'last_reg' => ['required']
        ]));



        return redirect('/admin/professions')->with('message', 'Prefix updated successfully.');


    }


    public function destroy(Prefix $prefix)
    {
        //
        $prefix->delete();
        return redirect('/admin/professions')->with('message', 'Prefix deleted successfully.');

    }


}
