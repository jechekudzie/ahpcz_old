<?php

namespace App\Http\Controllers;

use App\Approver;
use App\Profession;
use App\ProfessionApprover;
use App\User;
use Illuminate\Http\Request;
use Exception;

class ProfessionApproversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $profession_approvers = ProfessionApprover::all()->sortBy('id');
        return view('admin.profession_approvers.index', compact('profession_approvers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $professions = Profession::all()->sortBy('name');
        $users = User::where('role_id', 6)->get();
        return view('admin.profession_approvers.create', compact('users', 'professions'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        try {

            ProfessionApprover::create(request()->validate([

                'profession_id' => 'required|not_in:0',
                'user_id' => 'required|not_in:0'
            ]));

        } catch (Exception $e) {

            return redirect('/admin/profession_approvers/create')->with('message', 'Profession has already been assigned a member.');

        }

        return redirect('admin/profession_approvers/create')->with('message', 'Approval rights assigned successfully');

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
    public function edit(ProfessionApprover $professionApprover)
    {
        //
        $professions = Profession::all()->sortBy('name');
        $users = User::where('role_id', 6)->get();

        return view('admin.profession_approvers.edit', compact('users', 'professions', 'professionApprover'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfessionApprover $professionApprover  )
    {
        //
        try {

            $professionApprover->update(request()->validate([

                'profession_id' => 'required|not_in:0',
                'user_id' => 'required|not_in:0'
            ]));

        } catch (Exception $e) {

            return redirect('/admin/profession_approvers/'.$professionApprover->id.'/edit')->with('message', 'Profession has already been assigned a member.');

        }

        return redirect('admin/profession_approvers')->with('message', 'Approval rights has been updated successfully');

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
