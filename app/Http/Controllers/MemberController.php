<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Group;

class MemberController extends Controller
{
    
    /**
     * 
     * 
     */
    public function index($id) {
        $group = Group::findOrFail($id);
        $members = $group->members()->paginate(20);
        return view('member.index', compact('group', 'members'));
    }


    /**
     * 
     * 
     */
    public function add() {
        return view('member.add');
    }

    /**
     * Ajouter l'utilisateur à examen à partir d'un code donné
     */
    public function store(Request $request) {
        
        $request->validate([
            'code' => 'required|exists:groups,code'
        ], [
            'code.required' => 'Le code d\'examen est obligatoire',
            'code.exists' => 'Ce code d\'examen n\'existe pas'
        ]);

        $group = Group::where([ 'code' => $request->code ])->firstOrFail();

        if (GroupMember::where(['group_id' => $group->id, 'user_id' => auth()->id()])->exists()) {
            return back()->with('info', 'Vous êtres déja un membre de cette examen');
        }

        $member = new GroupMember;
        $member->group_id = $group->id;
        $member->user_id = auth()->id();
        $member->save();

        return redirect()->route('group.index')->with('success', "Vous êtes maintenant concerné de l'examen <b>" . $group->title . "</b>");

    }


    /**
     * 
     * 
     */
    public function delete($id, $member_id) {
        
        $member = GroupMember::where([ 'group_id' => $id, 'user_id' => $member_id ])->firstOrFail();
        $member->delete();
        return back()->with('success', 'L\'étudiant a été supprimé avec succés');


    }
    

}
