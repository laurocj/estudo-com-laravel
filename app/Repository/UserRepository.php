<?php

namespace App\Repository;

use App\User;
use App\Repository\BaseRepository;


class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = User::class;
    }
}
