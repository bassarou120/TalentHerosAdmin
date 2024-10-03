<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participation extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function campagne(): BelongsTo
    {
        return $this->belongsTo(Campagne::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
