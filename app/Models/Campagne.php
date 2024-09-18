<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campagne extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function participation():HasMany
    {

        return  $this->hasMany(Participation::class);

    }

}
