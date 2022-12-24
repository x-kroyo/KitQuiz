<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use App\Models\Group;
use App\Models\GroupAttachment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{

    /**
     * 
     */
    public function index(Request $request) {

        // Get user concerned groups
        $groups = auth()->user()->groups();

        $now = Carbon::now()->toDateTimeString();

        // Filter groups
        switch($request->category):
            case 'completed': $groups = $groups->where('due_to', '<=', $now); break;
            case 'sheduled': $groups = $groups->where('start_at', '>=', $now); break;
            default: $groups = $groups->where('due_to', '>=', $now)->where('start_at', '<=', $now); break;
        endswitch;

        $groups = $groups->get();

        return view('group.index', compact('groups'));

    }

    /**
     * 
     * 
     */
    public function show($id) {
        $group = Group::findOrFail($id);
        $answer = Answer::where([ 'group_id' => $group->id, 'user_id' => auth()->id() ])->first();
        $closed = $group->close_on && Carbon::now()->gt($group->close_on);
        return view('group.about', compact('group', 'answer', 'closed'));
    }


    /**
     * 
     * 
     */
    public function create() {
        return view('group.create');
    }
    
    /**
     * 
     */
    public function store(Request $request) {


        $validator = Validator::make($request->all(), [
            'title'         => 'required|min:3',
            'instructions'  => 'nullable',
            'due_to_date'   => 'required|date_format:Y-m-d',
            'due_to_time'   => 'required|date_format:H:i',
            'is_closed'     => 'nullable',
            'publish'       => 'nullable',
            'points'        => 'nullable|numeric|min:0',
            'attachments.*' => [ 'nullable', File::types(['docx', 'doc', 'pdf', 'jpeg', 'jpg', 'png'])->max(2 * 1024) ]
        ], [
            'title.required' => 'Le titre d\'examen est obligatoire',
            'title.min' => 'Le titre doit être composé au mois par 3 caractères',
            
            'due_to_date.required' => 'La date de termination est obligatoire',
            'due_to_date.date_format' => 'La format de la date est invalide',
            'due_to_time.required' => 'Le temps de termination est obligatoire',
            'due_to_time.date_format' => 'La format du temps de termination est invalide',
            
            'close_at_date.required' => 'La date de cloture est obligatoire',
            'close_at_date.date_format' => 'La format de la date de cloture est invalide',
            'close_at_time.required' => 'Le temps de cloture est obligatoire',
            'close_at_time.date_format' => 'La format du temps de cloture est invalide',
            
            'shedule_date.required' => 'La date de publication est obligatoire',
            'shedule_date.date_format' => 'La format de la date de publication est invalide',
            'shedule_time.required' => 'Le temps de publication est obligatoire',
            'shedule_time.date_format' => 'La format du temps de publication est invalide',

            'points.numeric' => 'Les points d\'examen doit être un nombre',
            'points.min' => 'Le minimum des points doit être : 0'
        ]);

        // Validate the close at date and time if and only if it must be closed
        $validator->sometimes('close_at_date', 'required|date_format:Y-m-d', fn() => $request->is_closed);
        $validator->sometimes('close_at_time', 'required|date_format:H:i', fn() => $request->is_closed);
        
        $validator->sometimes('shedule_date', 'required|date_format:Y-m-d', fn() => $request->publish);
        $validator->sometimes('shedule_time', 'required|date_format:H:i', fn() => $request->publish);

        
        $validator->validate();

        $due =  Carbon::createFromTimeString($request->due_to_date . ' ' . $request->due_to_time);
        $close = $request->is_closed ? Carbon::createFromTimeString($request->close_at_date . ' ' . $request->close_at_time) : null;
        $publish = $request->publish ? Carbon::createFromTimeString($request->shedule_date . ' ' . $request->shedule_time) : null;

        if ($due->lt(now())) {
            return back()->withInput()->withErrors(['due_date' => 'La date de termination d\'examen est illogique']);
        }

        if ($request->publish && $publish->gt($due)) {
            return back()->withInput()->withErrors(['publish_date' => 'La date de publication doit être inférieur à la date de termination d\'examen']);
        }

        if ($request->is_closed && $close->lt($due)) {
            return back()->withInput()->withErrors(['close_date' => 'La date de cloture d\'examen doit être supéieur à la date de termination']);
        }

        $group = new Group();
        $group->title = $request->title;
        $group->code = uniqid();
        $group->instructions = $request->instructions;
        $group->points = $request->points;
        $group->user_id = auth()->id();
        $group->due_to = $due->toDateTimeString();
        $group->close_on = $request->is_closed ? $close->toDateTimeString() : null;
        $group->start_at = $request->publish ? $publish->toDateTimeString() : null;
        $group->save();

        // Save group attachments
        if($request->attachments) {
            foreach($request->attachments as $upload) {
                
                $fid = FileController::store($upload); // Store the file
                
                $attachment = new GroupAttachment;
                $attachment->group_id = $group->id;
                $attachment->file_id = $fid;
                $attachment->save();

                // Store the file intro global directory groups
                $upload->store('groups/' . $group->id);

            }
        }

        return redirect()->route('group.index')->with('success', "L'examen a été ajouté avec success. Son code est : <b>" . $group->code . "</b>");

    }


    /**
     * De
     * 
     * @return Illuminate\Http\Request
     */
    public function delete($id) {

        $group = Group::findOrFail($id);
        $group->files()->delete(); // Delete all files records on database
        Storage::deleteDirectory('groups/' . $group->id); // Delete group files on storage
        $group->delete(); // Delete the group
        return redirect()->route('group.index')->with('success', 'L\'examen a été supprimer avec succès');

    }

    /**
     * Edit an group assignment
     */
    public function edit($id) {
        $group = Group::findOrFail($id);
        return view('group.edit', compact('group'));
    }

    /**
     * 
     */
    public function update(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
            'title'         => 'required|min:3',
            'instructions'  => 'nullable',
            'due_to_date'   => 'required|date_format:Y-m-d',
            'due_to_time'   => 'required|date_format:H:i',
            'is_closed'     => 'nullable',
            'points'        => 'nullable|numeric|min:0',
        ]);

        // Validate the close at date and time if and only if it must be closed
        $validator->sometimes('close_at_date', 'required|date_format:Y-m-d', fn() => $request->is_closed);
        $validator->sometimes('close_at_time', 'required|date_format:H:i', fn() => $request->is_closed);
        
        $validator->validate();

        $due =  Carbon::createFromTimeString($request->due_to_date . ' ' . $request->due_to_time);
        $close = $request->is_closed ? Carbon::createFromTimeString($request->close_at_date . ' ' . $request->close_at_time) : null;
        $publish = $request->publish ? Carbon::createFromTimeString($request->shedule_date . ' ' . $request->shedule_time) : null;

        if ($due->lt(now())) {
            return back()->withInput()->withErrors(['due_date' => 'La date de termination d\'examen est illogique']);
        }

        if ($request->publish && $publish->gt($due)) {
            return back()->withInput()->withErrors(['publish_date' => 'La date de publication doit être inférieur à la date de termination d\'examen']);
        }

        if ($request->is_closed && $close->lt($due)) {
            return back()->withInput()->withErrors(['close_date' => "Date de cloture d'examen doit être supérieur à la date due"]);
        }
        

        $group = Group::find($id);
        $group->title = $request->title;
        $group->instructions = $request->instructions;
        $group->points = $request->points;
        $group->due_to = $due->toDateTimeString();
        $group->close_on = $request->is_closed ? $close->toDateTimeString() : null;
        $group->start_at = $request->publish ? $publish->toDateTimeString() : null;
        $group->save();

        // Save group attachments
        if ($request->attachments) {
            foreach($request->attachments as $upload) {
                    
                $attachment = new GroupAttachment;
                $attachment->group_id = $group->id;
                $attachment->file_id = FileController::store($upload);
                $attachment->save();
    
                // Store the file intro global directory groups
                $upload->store('groups/' . $group->id);
    
            }
        }
        
        return redirect()->route('group.index')->with('success', 'L\'examen a été bien modifier');
        

    }


}
