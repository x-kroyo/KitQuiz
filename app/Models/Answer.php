<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    /**
     * Get group attached files
     * 
     * @return
     */
    public function files() {
        return $this->hasManyThrough(File::class, AnswerAttachment::class, 'answer_id', 'id', 'id', 'file_id');
    }

    /**
     * Get the answer user who submit it
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
