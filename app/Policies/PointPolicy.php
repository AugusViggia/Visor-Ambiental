<?php

namespace App\Policies;

use App\Models\Point;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PointPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can process the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function process(User $user, Point $point)
    {
        $statusList = [
            config('custom.points.status.pending'),
            config('custom.points.status.denounced'),
        ];
        return in_array($point->status_id, $statusList);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, Point $point)
    {
        if (!$user->hasRole('ADM')) {
            return true;
        }

        $statusList = [
            config('custom.points.status.approved'),
            config('custom.points.status.rejected'),
            config('custom.points.status.denounced'),
        ];
        return in_array($point->status_id, $statusList);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Point $point)
    {

        $statusList = [
            config('custom.points.status.approved'),
            config('custom.points.status.pending'),
            config('custom.points.status.denounced'),
        ];

        return in_array($point->status->id, $statusList);
    }

    /**
     * Determine whether the user can readOnly form.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function readOnly(User $user, Point $point)
    {
        return $user->hasRole('USI') &&
            $point->was_approved &&
            $point->status->id === config('custom.points.status.approved');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Point $point)
    {

        if ($user->hasRole('ADM')) {
            return in_array($point->status->id, config('custom.points.deleteAdmin'));
        }

        return in_array($point->status->id, config('custom.points.deleteUser'));
    }
}
