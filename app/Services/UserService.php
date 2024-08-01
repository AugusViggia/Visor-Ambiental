<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class UserService
{
    public function mainQuery(array $searchParams, array $includes): Builder
    {
        return User::search($searchParams)->with($includes);
    }

    public function updateLastAccess(User $user): void
    {
        $user->last_access = now();
        $user->save();
    }

    public function create(array $payload): User
    {
        $role = Role::findOrFail($payload['role_id']);
        $user = User::create($payload);
        $user->assignRole($role);
        return $user;
    }

    public function createByAdmin(array $payload): User
    {
        $payload['approved_at'] = now();
        $payload['enabled'] = true;
        return $this->create($payload);
    }

    public function block(User $user): void
    {
        $user->update([
            'enabled' => false,
        ]);
    }

    public function enable(User $user): void
    {
        $user->update([
            'enabled' => true,
        ]);
    }

    public function update(User $user, array $payload)
    {
        $payload = collect($payload);
        if ($payload->get('role_id')) {
            $role = Role::findOrFail($payload->get('role_id'));
            $user->syncRoles([$role]);
        }

        $user->update($payload->except('role_id')->toArray());
    }
}
