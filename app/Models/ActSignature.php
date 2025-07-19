<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActSignature extends Model
{
    protected $fillable = [
        'hidden_work_id', 'user_id', 'role', 'signed_at', 'file_path'
    ];
}
