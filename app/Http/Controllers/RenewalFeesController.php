<?php

namespace App\Http\Controllers;

use App\Profession;
use App\ProfessionTire;
use App\Rate;
use App\RenewalCategory;
use App\RenewalFee;
use App\Tire;
use Illuminate\Http\Request;

class RenewalFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $renewal_fees = RenewalFee::all();
        $tires = Tire::all();
        $rate = Rate::find(1);
        $profession_tires = ProfessionTire::all();
        return view('admin.renewal_fees.index',
            compact('renewal_fees','profession_tires',
                'tires','rate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $professions = Profession::whereNotIn('id',[19])->get()->sortBy('name');
        $renewal_categories = RenewalCategory::all()->sortBY('name');
        return view('admin.renewal_fees.create',compact('professions','renewal_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        RenewalFee::create(request()->validate([
            'profession_id' => ['required'],
            'renewal_category_id' => ['required'],
            'fee' => ['required','numeric']
        ]));


        return redirect('/admin/renewal_fees/create')->with('message', 'Renewal Fee added successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RenewalFee $renewal_fee)
    {
        //
        return view('admin.renewal_fees.show',compact('renewal_fee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RenewalFee $renewal_fee)
    {
        //
        $professions = Profession::whereNotIn('id',[19])->get()->sortBy('name');
        $renewal_categories = RenewalCategory::all()->sortBY('name');
        return view('admin.renewal_fees.edit', compact('renewal_fee','professions','renewal_categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RenewalFee $renewal_fee)
    {
        //
        $renewal_fee->update(request()->validate([
            'profession_id' => ['required'],
            'renewal_category_id' => ['required'],
            'fee' => ['required','numeric']
        ]));
        return redirect('/admin/renewal_fees')->with('message', 'Renewal fee updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RenewalFee $renewal_fee)
    {
        //
        $renewal_fee->delete();
        return redirect('/admin/renewal_fees')->with('message', 'Renewal fee deleted successfully.');

    }
}
