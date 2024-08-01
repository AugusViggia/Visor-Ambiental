<?php

namespace App\Services;

use App\Models\User;

class RoleService
{
    private array $backendRoles;
    private array $frontendRoles;

    public function __construct()
    {
        $this->backendRoles = config('custom.roles.backend');
        $this->frontendRoles = config('custom.roles.frontend');
    }

    public function isBackendRole(int $roleId): bool
    {
        return in_array($roleId, $this->backendRoles);
    }

    public function isFrontendRole(int $roleId): bool
    {
        return in_array($roleId, $this->frontendRoles);
    }

    public function hasBackendRole(User $user): bool
    {
        return $this->isBackendRole($user->roles()->first()->id);
    }

    public function hasFrontendRole(User $user): bool
    {
        return $this->isFrontendRole($user->roles()->first()->id);
    }
}
