<?php


namespace App\DAO;


use App\DBModels\User;
use Illuminate\Database\Eloquent\Collection;

class UserDAO
{
    /**
     * @return User[]|Collection
     */
    public function getAll()
    {
        return User::all();
    }
}
