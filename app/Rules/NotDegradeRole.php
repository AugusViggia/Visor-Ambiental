<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\RoleService;
use App\Models\User;

class NotDegradeRole implements Rule
{
    private RoleService $roleService;
    private User $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(User $user, RoleService $service = new RoleService())
    {
        $this->user = $user;
        $this->roleService = $service;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->roleService->isBackendRole($value)) {
            return true;
        }

        // Is trying to downgrade role?
        if ($this->roleService->hasBackendRole($this->user)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No es posible degradar un rol administrativo.';
    }
}
