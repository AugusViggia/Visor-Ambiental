<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Services\Helpers\Alert\AlertType;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class UsersController extends Controller
{
    public function index(SearchUserRequest $request, UserService $service)
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => UserResource::collection(
                $service->mainQuery($request->validated(), [
                    'roles',
                ])
                ->approved()
                ->paginate(config('custom.pagination.default_limit'))
                ->withQueryString()
            ),
            'filters' => !empty($request->except('page')) ? $request->except('page') : null,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Users/CreatePage', [
            'roles' => RoleResource::collection(Role::all()),
        ]);
    }

    public function store(StoreUserRequest $request, UserService $service)
    {
        $data = $request->validated();
        try {
            $user = DB::transaction(function () use ($service, $data) {
                return $service->createByAdmin($data);
            });
        } catch (\Exception $error) {
            DB::rollBack();
            logger()->error($error);
            flashAlert(
                __('messages.failure', ['action' => 'Alta', 'element' => 'Usuario']),
                AlertType::DANGER
            );
            redirect(route('users.index'));
            return;
        }
        Password::sendResetLink(['email' => $user->email]);
        flashAlert(__('messages.success', ['Action' => 'Alta', 'element' => 'Usuario']));
        return redirect(route('users.index'));
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/EditPage', [
            'user' => new UserResource($user->load('roles')),
            'roles' => RoleResource::collection(Role::all()),
        ]);
    }

    public function update(
        User $user,
        UpdateUserRequest $request,
        UserService $service
    ) {
        try {
            DB::transaction(function () use ($user, $service, $request) {
                return $service->update($user, $request->validated());
            });
        } catch (\Exception $error) {
            DB::rollBack();
            logger()->error($error);
            flashAlert(
                __('messages.failure', ['action' => 'Actualización', 'element' => 'Usuario']),
                AlertType::DANGER
            );
            redirect(route('users.index'));
            return;
        }
        flashAlert(__('messages.success', ['Action' => 'Actualización', 'element' => 'Usuario']));
        return redirect(route('users.index'));
    }
}
