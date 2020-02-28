<?php

namespace App\Repository;

use App\User;
use App\Repository\GenericRepository;


class UserRepository
{
    use GenericRepository;

    public function getModel()
    {
        return User::class;
    }
}