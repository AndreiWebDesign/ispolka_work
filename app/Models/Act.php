<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Act extends Model
{
    public function signatures()
    {
        return $this->hasMany(ActSignature::class, 'actable_id')
            ->where('actable_type', '=', self::class);
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class);
    }

}
