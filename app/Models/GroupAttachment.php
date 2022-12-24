<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupAttachment extends Model
{
    use HasFactory;

    /**
     * Get file row
     * 
     */
    public function file() {
        return $this->belongsTo(File::class);
    }

}
