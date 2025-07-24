<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActSignature extends Model
{
    protected $fillable = [
        'role',
        'status',
        'signed_at',
        'comment',
        'cms',
        'actable_id',
        'actable_type',
        'user_id',
    ];

    public function actable()
    {
        return $this->morphTo();
    }

    protected $casts = [
        'signed_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
