<?php

namespace App\Http\Controllers;

use App\RegisterCategory;
use Illuminate\Http\Request;

class RegisterCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $register_categories = RegisterCategory::all()->sortBy('name');
        return view('admin.register_categories.index',compact('register_categories'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.register_categories.create');

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

        RegisterCategory::create(request()->validate([
            'name' => ['required'],
            'description' => ['required', 'min:10']
        ]));

        $message = "Register Category added successfully.";
        return view('admin.register_categories.create',compact('message'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RegisterCategory $registerCategory)
    {
        //
        return view('admin.register_categories.show',compact('registerCategory'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RegisterCategory $registerCategory)
    {
        //
        return view('admin.register_categories.edit',compact('registerCategory'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegisterCategory $registerCategory)
    {
        //
        //update the record with the ID provided
        $registerCategory->update(request()->validate([
            'name' => ['required'],
            'description' => ['required','min:10']
        ]));

        return redirect('/admin/register_categories')->with('message','Register Category updated successfully.');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegisterCategory $registerCategory)
    {
        //
        $registerCategory->delete();
        return redirect('/admin/register_categories')->with('message','Register category deleted successfully.');

    }
}
