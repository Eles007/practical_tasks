<?php

namespace App\Services\Interfaces;

use App\Enums\UserRole;

interface UserServiceInterface
{
    public function changeRole(int $id, UserRole $role): bool;
}
