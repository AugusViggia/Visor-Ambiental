<?php

namespace App\Http\Controllers;

use App\Http\Requests\RejectUserRequest;
use App\Http\Requests\SearchUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Helpers\Alert\AlertType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserRequestController extends Controller
{
    public function index(SearchUserRequest $request)
    {
        $data = $request->validated();

        return Inertia::render(
            'Admin/UserRequests',
            [
                'requests' => UserResource::collection(
                    User::search($data)
                        ->requestType($data['type'] ?? null)
                        ->paginate()
                        ->withQueryString()
                ),
                'types' => collect(config('custom.admin.request_types'))
                    ->map(fn ($item) => array_merge($item, ['active' => $item['type'] === ($data['type'] ?? null)])),
                'filters' => !empty($request->except('page')) ? $request->except('page') : null,
            ]
        );
    }

    public function accept(User $user)
    {
        $user->approved_at = now();
        $user->save();
        $user->sendAccountApprovedNotification();
        flashAlert(__('messages.success', ['Action' => 'Habilitación', 'element' => 'Usuario']));

        return redirect()->route('userRequests.index', ['type' => 'pending']);
    }

    public function reject(RejectUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $user->rejection()->create(['reason' => $request->reason,'rejected_by' => Auth::user()->id]);
            $user->delete();
            DB::commit();
            flashAlert(__('messages.success', ['Action' => 'Rechazo', 'element' => 'Solicitud']));
        } catch (\Exception $exception) {
            DB::rollBack();
            logger($exception->getMessage());
            flashAlert(
                __('messages.failure', ['action' => 'Rechazo', 'element' => 'Solicitud']),
                AlertType::WARNING
            );
        }

        $user->sendAccountRejectedNotification();

        return redirect()->route('userRequests.index', ['type' => 'pending']);
    }

    public function deleteReject(User $user)
    {
        try {
            DB::beginTransaction();
            $user->rejection()->delete();
            $user->forceDelete();
            DB::commit();
            flashAlert(__('messages.success', ['Action' => 'Eliminación', 'element' => 'Solicitud de rechazo']));
        } catch (\Exception $exception) {
            DB::rollBack();
            logger($exception->getMessage());
            flashAlert(
                __('messages.failure', ['action' => 'Eliminación', 'element' => 'Solicitud de rechazo']),
                AlertType::WARNING
            );
        }

        return redirect()->route('userRequests.index', ['type' => 'rejected']);
    }
}
