<?php

namespace App\Http\Controllers;

use App\Approver;
use App\Profession;
use App\ProfessionApprover;
use App\User;
use Exception;
use Illuminate\Http\Request;

class ApproversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   /* public function __construct()
    {
        $this->middleware('verified');
    }*/

    public function index()
    {
        //
        $profession_approvers = ProfessionApprover::all()->sortBy('id');
        $professions = Profession::all()->sortBy('name');
        $users = User::all()->sortBy('name');
        return view('admin.approvers.index', compact('approvers','users','profession_approvers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.approvers.create');
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
            Approver::create(request()->validate([
                'name' => ['required', 'min:5']
            ]));

        } catch (Exception $e) {

            return back()->with('error_msg', 'Member with the same name already exist.');
        }

        return back()->with('message', 'Member added successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Approver $approver)
    {
        //
        return view('admin.approvers.show',compact('approver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Approver $approver)
    {
        //
        return view('admin.approvers.edit',compact('approver'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Approver $approver)
    {
        //
        $approver->update(request()->validate([
            'name'=>['required','min:5']
        ]));

        return redirect('/admin/approvers')->with('message','Member information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approver $approver)
    {
        //

        $member_name = $approver->name;
        $approver->delete();
        return redirect('/admin/approvers')->with('message',$member_name.' has been deleted from committee member list.');

    }
}
