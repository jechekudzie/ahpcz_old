<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\OtherApplication;
use App\OtherDocuments;
use Illuminate\Http\Request;

class OtherDocumentsController extends Controller
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
    public function create(OtherApplication $otherApplication)
    {
        return view('admin/practitioner_other_docs.create',compact('otherApplication'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OtherApplication $otherApplication)
    {
        request()->validate([
            'file' => 'required',
        ]);

        $other_application_id = $otherApplication->id;

        $files = request()->file('file');

        $number = 0;
        if (request()->hasfile('file')) {

            //get the file field data and name field from form submission
            foreach ($files as $file) {
                //get file original name
                $name = $file->getClientOriginalName();

                //create a unique file name using the time variable plus the name
                $file_name =  $number.time() . $name ;

                //upload the file to a directory in Public folder
                $path = $file->move('otherDocs', $file_name);

                OtherDocuments::create([
                    'other_application_id' => $other_application_id,
                    'name' => $name,
                    'path' => $path
                ]);

                $number = $number + 1;
            }

        }

        return redirect('/admin/practitioners/apps/'.$otherApplication->id.'/show')->with('message', 'Document uploaded successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
