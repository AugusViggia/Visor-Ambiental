<?php

namespace App\Models\Traits;

use App\Models\Rejection;
use App\Notifications\UserRequestAccepted;
use App\Notifications\UserRequestRejected;

/**
 * MustBeApproved
 */
trait MustBeApproved
{
    public function rejection()
    {
        return $this->hasOne(Rejection::class);
    }

    public function scopeRequestType($query, $type = null)
    {
        $types = collect(config('custom.admin.request_types'))
            ->keyBy('type');

        $selected = $types->get($type, $types->first());

        $scope = $selected['type'];

        return $query->$scope($query)
            ->orderBy($selected['order_field'], $selected['order_type']);
    }

    public function scopePending($query)
    {
        return $query->whereNull('approved_at');
    }

    public function scopeRejected($query)
    {
        return $query->withTrashed()
            ->pending()
            ->with(['rejection', 'rejection.user', 'rejection.userWhoApproved'])
            ->has('rejection');
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function hasBeenApproved()
    {
        return $this->approved_at !== null;
    }

    public function sendAccountApprovedNotification()
    {
        $this->notify(new UserRequestAccepted());
    }

    public function sendAccountRejectedNotification()
    {
        if ($this->fresh()->deleted_at) {
            $this->notify(new UserRequestRejected());
        }
    }

    public function getEmailForRequest()
    {
        return $this->email;
    }
}
