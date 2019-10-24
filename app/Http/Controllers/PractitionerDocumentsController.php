<?php

namespace App\Http\Controllers;

use App\Document;
use App\DocumentCategory;
use App\Practitioner;
use App\PractitionerQualification;
use App\Requirement;
use Illuminate\Http\Request;

class PractitionerDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*public function __construct()
    {
        $this->middleware('verified');
    }*/

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Practitioner $practitioner)
    {
        //
        if($practitioner->qualification_category_id ==1){
            $documents_categories = DocumentCategory::whereNotIn('group',['foreigners'])->get();
        }else{
            $documents_categories = DocumentCategory::all()->sortBy('name');
        }

        return view('admin.practitioner_documents.create',
            compact('practitioner', 'documents_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Practitioner $practitioner)
    {
        request()->validate([
            'file' => 'required',
            'document_category_id' => 'required'
        ]);

        $practitioner_id = $practitioner->id;
        $document_category_id = '';
        $path = '';

        if (request()->hasfile('file')) {

            $document_category_id = request('document_category_id');

            $file = request()->file('file');

            //get file original name
            $name = $file->getClientOriginalName();

            //create a unique file name using the time variable plus the name
            $file_name = time() . $name;

            //upload the file to a directory in Public folder
            $path = $file->move('documents', $file_name);

        }
        Document::create([
            'document_owner' => $practitioner_id,
            'document_category_id' => $document_category_id,
            'path' => $path
        ]);

        return back()->with('message', 'Document uploaded successfully');
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
    public function edit(Document $document)
    {


        $documents_categories = DocumentCategory::all()->sortBy('name');
        return view('admin.practitioner_documents.edit',compact('documents_categories','document'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Document $document)
    {

        $old_path = $document->path;
        if ($old_path != null) {
            unlink($old_path);
        }

        request()->validate([
            'file' => 'required',
            'document_category_id' => 'required',
        ]);
        $document_category_id = request('document_category_id');

        if (request()->hasfile('file')) {
            //get the file field data and name field from form submission
            $file = request()->file('file');

            //get file original name
            $name = $file->getClientOriginalName();

            //create a unique file name using the time variable plus the name
            $file_name = time() . $name;

            //upload the file to a directory in Public folder
            $path = $file->move('documents', $file_name);
        }

        $document->update([
            'document_category_id' => $document_category_id,
            'path' => $path
        ]);
        return back()->with('message','Document updated succesffully');
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
