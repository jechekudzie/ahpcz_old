<?php

namespace App\Http\Controllers;

use App\Models\ProductSpecification;
use App\ProfessionTire;
use Illuminate\Http\Request;

class ProfessionTireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $professionTire = (request()->validate([
            'tire_id' => ['required'],
            'profession_id' => ['required'],

        ],
            [
                'profession_id.required' => 'Please first select the profession(s) you want to add to this tire!',

            ]
        ));

        $professions = request('profession_id');

        foreach ($professions as $profession) {
            $professionTires['tire_id'] = $professionTire['tire_id'];
            $professionTires['profession_id'] = $profession;
            ProfessionTire::create($professionTires);
        }

        return back()->with('message', 'Professions successfully added to this tire.');
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
    public function destroy()
    {
        //
        $professionTire = (request()->validate([
            'profession_tire_id' => ['required'],
            'tire_id' => ['required'],

        ], [
                'profession_tire_id.required' => 'Please first select the profession(s) you want to delete from this tire!',

            ]
        ));

        $profession_tires = request('profession_tire_id');

        foreach ($profession_tires as $profession_tire) {
            $delete_profession_tire = ProfessionTire::where('id', $profession_tire)->first();
            $delete_profession_tire->delete();

        }

        return redirect('/admin/tires/' . $professionTire['tire_id'])->with('message', 'professions successfully removed from this tire.');

    }
}
