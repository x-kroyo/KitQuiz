<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'due_to' => 'datetime',
        'start_at' => 'datetime',
        'close_on' => 'datetime',
    ];

    /**
     * Get group creator user
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get group members list
     */
    public function members() {
        return $this->hasManyThrough(User::class, GroupMember::class, 'group_id', 'id', 'id', 'user_id');
    }

    /**
     * Get group attached files
     */
    public function files() {
        return $this->hasManyThrough(File::class, GroupAttachment::class, 'group_id', 'id', 'id', 'file_id');
    }

    /**
     * Get group answers
     */
    public function answers() {
        return $this->hasMany(Answer::class);
    }

}
