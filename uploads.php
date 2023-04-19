<?php

use App\Document;
use App\Http\Controllers\Controller;
use App\Project;

class ProjectDocumentsController extends Controller
{

    public function create(Project $project)
    {
        $docs = new Document();

        request()->validate([
            'file' => 'required',
            'name' => 'required'
        ]);

        if(request()->hasfile('file')) {
            //get the file field data and name field from form submission
            $document_name = request('name');
            $file = request()->file('file');

            //get file original name
            $name = $file->getClientOriginalName();

            //create a unique file name using the time variable plus the name
            $file_name = time() . $name;

            //upload the file to a directory in Public folder
            $path = $file->move('upload', $file_name);

        }
        //save document
        Document::create([
            'project_id' => $project->id,
            'name' => $document_name,
            'file_name' => $file_name,
            'path' => $path
        ]);

        /*        return Redirect::route('projects.show', compact('project'));*/
        return back()->with('message', 'Document added successfully');

        //return view('projects.docs',compact('documents'));

    }

    public function destroy(Document $document)
    {
        $id = $document->project_id;
        $path = $document->path;
        unlink($path);
        $document->delete();
        return redirect('projects/' . $id)->with('message', 'Document deleted successfully');
    }
}