<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Services\Helpers\Alert\AlertType;

class UsersBlockController extends Controller
{
    public function block(User $user, UserService $service)
    {
        try {
            $service->block($user);
            flashAlert(__('messages.success', ['Action' => 'Bloqueo', 'element' => 'Usuario']));
        } catch (\Exception $e) {
            logger()->error($e);
            flashAlert(
                __('messages.failure', ['action' => 'Bloqueo', 'element' => 'Usuario']),
                AlertType::DANGER
            );
        }
        return redirect()->route('users.index');
    }

    public function enable(User $user, UserService $service)
    {
        try {
            $service->enable($user);
            flashAlert(__('messages.success', ['Action' => 'Desbloqueo', 'element' => 'Usuario']));
        } catch (\Exception $e) {
            logger()->error($e);
            flashAlert(
                __('messages.failure', ['action' => 'Desbloqueo', 'element' => 'Usuario']),
                AlertType::DANGER
            );
        }
        return redirect()->route('users.index');
    }
}
