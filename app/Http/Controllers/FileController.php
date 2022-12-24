<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Store a new file
     * 
     * @return The stored file row id
     */
    public static function store($upload) {

        $file = new File;

        $file->file_name = $upload->getClientOriginalName();
        $file->storage_name = $upload->hashName();
        $file->size = $upload->getSize();
        $file->extension = $upload->extension();
        $file->user_id = Auth::id();
        $file->type = $upload->getClientMimeType();
        
        $file->save();

        return $file->id;

    }


}
