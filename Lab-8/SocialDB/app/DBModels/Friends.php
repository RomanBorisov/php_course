<?php

namespace App\DBModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
