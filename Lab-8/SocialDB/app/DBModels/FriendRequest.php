<?php

namespace App\DBModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    protected $table = 'friend_requests';

    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'user_id_from');
    }

    public function recipient()
    {
        return $this->hasOne(User::class, 'id', 'user_id_to');
    }

}
