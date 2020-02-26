<?php

namespace App\Repository;

use App\User;
use App\Repository\GenericRepository;


class UserRepository extends GenericRepository
{

    public function __construct()
    {
        parent::__construct(User::class);
    }
}