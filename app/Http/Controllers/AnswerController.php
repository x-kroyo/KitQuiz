<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use App\Models\Answer;
use App\Models\Group;
use App\Models\AnswerAttachment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class AnswerController extends Controller

{

    public function index($id) {

        $group = Group::findOrFail($id);
        $answers = $group->answers()->paginate();

        return view('response.index', compact('group', 'answers'));

    }
    

    public function store(Request $request, $id) {

        $group = Group::findOrFail($id);

        if ($group->close_on && Carbon::now()->gt($group->close_on)) {
            return back()->with(['closed' => 'Désolé, la session d\'examen est fermé']);
        }

        $request->validate([
            'attachments'   => 'required',
            'attachments.*' => [ File::types(['docx', 'doc', 'pdf', 'jpeg', 'jpg', 'png'])->max(2 * 1024) ]
        ], [
            'attachments.required' => 'Veuillez ajouter les fichier de votre travail'
        ]);

        $answer = new Answer();
        $answer->user_id = auth()->id();
        $answer->group_id = $group->id;
        $answer->save();

        foreach ($request->attachments as $upload) {

            $file = FileController::store($upload); // Store the file on database
            $attachment = new AnswerAttachment();
            $attachment->file_id = $file;
            $attachment->answer_id = $answer->id;
            $attachment->save();
        
            $upload->store('answers/' . $answer->id);

        }

        return back()->with('success', 'Votre réponse a été rendu avec succès');

    }


    /**
     * 
     * 
     */
    public function delete($id) {

        $answer = Answer::where([ 'user_id' => auth()->id(), 'group_id' => $id ])->firstOrFail();
        $answer->files()->delete();
        Storage::deleteDirectory('answers/' . $answer->id);
        $answer->delete();
        return back()->with('success', 'Votre réponse d\'examen est annulé');
        
    }

    public function download($id, $answer) {

        $ans = Answer::find($answer);

        $zip = new \ZipArchive();
        $zip->open("reponce.zip", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach($ans->files as $file){
            $zip->addFile(Storage::path("answers\\$answer\\" . $file->storage_name), $file->file_name);
        }
        
        $zip->close();

        return response()->download("reponce.zip");


    }

}
