<?php

namespace App\Http\Controllers;

use App\CdPoint;
use App\Profession;
use Exception;
use Illuminate\Http\Request;

class CdPointsController extends Controller
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
        return view('admin.cdpoints.create', compact('professions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
       $attributes =  request()->validate([
            'profession_id' => 'required',
            'points' => ['required', 'numeric'],
            'placement' => ['required', 'numeric']
        ]);

        try{
            CdPoint::create($attributes);

        } catch (Exception $e) {

            return redirect('/admin/cdpoints/create')->with('error','This Profession has already been assigned points.');
        }


        return redirect('/admin/cdpoints/create')->with('message','Points added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(CdPoint $cdpoint)
    {
        //
        return view('admin.cdpoints.show',compact('cdpoint'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CdPoint $cdpoint)
    {
        $professions = Profession::whereNotIn('id',[19])->get()->sortBy('name');

        return view('admin.cdpoints.edit',compact('cdpoint','professions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CdPoint $cdpoint)
    {
        //
        $cdpoint->update(request()->validate([
            'profession_id' => ['required'],
            'points' => ['required','numeric'],
            'placement' => ['required','numeric']
        ]));
        return redirect('/admin/professions')->with('message','Points updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CdPoint $cdpoint)
    {
        //
        $cdpoint->delete();
        return redirect('/admin/professions')->with('message','Points deleted successfully.');

    }
}
