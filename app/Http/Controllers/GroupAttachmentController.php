<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupAttachment;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class GroupAttachmentController extends Controller
{
    
    /**
     * Delete group attachment
     */
    public function delete($id, $file) {
        
        $attachment = GroupAttachment::where(['group_id' => $id, 'file_id' => $file])->firstOrFail();
        Storage::delete("groups/$id/" . $attachment->file->storage_name);
        $attachment->delete();
        $attachment->file->delete();

        return back()->with('success', 'Le fichier a été bien supprimé');

    }

    /**
     * 
     */
    public function download($id, $attachment) {

        $file = File::find($attachment);
        return Storage::download("groups/$id/" . $file->storage_name, $file->file_name);


    }


}
