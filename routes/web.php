<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\ObservationsController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PointSolicitudeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Front routes and common routes for authenticated users
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'approved',
    'checkBanned',
])->group(function () {

    // Points on map
    Route::patch('map/{point:resource_id}/denounce', [MapController::class, 'denounce'])
        ->name('map.denounce')
        ->can('points.report');

    // Points Routes
    Route::prefix('/puntos')->name('points.')->group(function () {

        Route::get('/', [PointsController::class, 'index'])
            ->name('index')
            ->middleware('can:points.list')
            ->breadcrumb('Puntos');

        Route::get('/ver/{point}', [PointsController::class, 'show'])
            ->name('show')
            ->middleware('can:points.show')
            ->middleware('can:show,point')
            ->breadcrumb('Ver punto', 'points.index');

        Route::get('/procesar/{point}', [PointsController::class, 'process'])
            ->name('process')
            ->middleware('can:points.approve')
            ->middleware('can:process,point')
            ->breadcrumb('Procesar punto', 'points.index');

        Route::get('/create', [PointsController::class, 'create'])
            ->name('create')
            ->middleware('can:points.create')
            ->breadcrumb('Nuevo Punto', 'points.index');

        Route::post('/', [PointsController::class, 'store'])
            ->name('store');

        Route::get('/edit/{point}', [PointsController::class, 'edit'])
            ->name('edit')
            ->middleware('can:points.edit')
            ->breadcrumb('Editar Punto', 'points.index');
        ;

        Route::patch('/{point}', [PointsController::class, 'update'])
            ->name('update');

        Route::delete('/{point}', [PointsController::class, 'delete'])
            ->name('delete')
            ->middleware('can:points.destroy');

        Route::get('/generate', [PointsController::class,'generateExcel'])
            ->name('generateExcel');

        Route::prefix('importacion')->name('importacion.')->group(function () {

            Route::get('/', [PointsController::class, 'importPage'])
                ->name('index')
                ->breadcrumb('Importar Excel', 'points.index');

            Route::post('/', [PointsController::class, 'import'])
                ->name('store');

            Route::get('/download-excel-template', [PointsController::class, 'downloadExcelTemplate'])
                ->name('download-excel-template');
        });

        Route::put('/aprobar/{point}', [PointSolicitudeController::class, 'approve'])
            ->name('approve')
            ->middleware('can:points.approve');

        Route::put('/rechazar/{point}', [PointSolicitudeController::class, 'reject'])
            ->name('reject')
            ->middleware('can:points.approve');
    });

    // Observation Routes

    Route::prefix('/observation')->name('observations.')->group(function () {

        Route::post('/store/{point}', [ObservationsController::class, 'storeObservation'])
            ->name('store');

        Route::delete('/{observation}', [ObservationsController::class, 'deleteObservation'])
            ->name('delete');

        Route::delete('/reject/{observation}', [ObservationsController::class, 'reject'])
            ->name('reject');
    });

    // Manueales Routes

    Route::prefix('manuales')->name('manuales.')->group(function () {

        Route::get('/admin', function () {
            return Storage::download('manuales/manual-de-ayuda-back.docx');
        })
        ->middleware(['role:ADM'])
        ->name('admin');

        Route::get('/consulta', function () {
            return Storage::download('manuales/manual-de-ayuda-front.docx');
        })
        ->name('consulta');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('categories', CategoryController::class);
});

/**
 * Administrative routes
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'checkBanned',
])->group(function () {
    Route::get('solicitudes', [\App\Http\Controllers\UserRequestController::class, 'index'])
        ->name('userRequests.index')
        ->middleware('can:users.requestsList')
        ->breadcrumb(
            fn () => 'Solicitudes ' .
                collect(config('custom.admin.request_types'))
                    ->keyBy('type')
                    ->get(request()->get('type', 'pending'))['name']
        );
    Route::patch(
        'solicitudes/{user}/accept',
        [\App\Http\Controllers\UserRequestController::class, 'accept']
    )->name('userRequests.accept');

    Route::delete(
        'solicitudes/{user}/reject',
        [\App\Http\Controllers\UserRequestController::class, 'reject']
    )->name('userRequests.reject');

    // Delete Rejeted request
    Route::delete(
        'solicitudes/delete/{user}/reject',
        [\App\Http\Controllers\UserRequestController::class, 'deleteReject']
    )->name('userRequests.reject.delete')->withTrashed();


    /* User Routes */
    Route::prefix('/users')->name('users.')->group(function () {

        Route::get('/', [\App\Http\Controllers\UsersController::class, 'index'])
            ->name('index')
            ->middleware('can:users.list')
            ->breadcrumb('Consulta de usuarios');

        Route::get('/create', [\App\Http\Controllers\UsersController::class, 'create'])
            ->name('create')
            ->middleware('can:users.create')
            ->breadcrumb('Nuevo usuario', 'users.index');

        Route::post('/', [\App\Http\Controllers\UsersController::class, 'store'])
            ->name('store')
            ->middleware('can:users.create');

        Route::get('/edit/{user}', [\App\Http\Controllers\UsersController::class, 'edit'])
            ->name('edit')
            ->middleware('can:users.edit')
            ->breadcrumb('Editar usuario', 'users.index');

        Route::put('/update/{user}', [\App\Http\Controllers\UsersController::class, 'update'])
            ->name('update')
            ->middleware('can:users.edit');

        Route::put('/block/{user}', [\App\Http\Controllers\UsersBlockController::class, 'block'])
            ->name('block')
            ->middleware('can:users.blockEnable');

        Route::put('/enable/{user}', [\App\Http\Controllers\UsersBlockController::class, 'enable'])
            ->name('enable')
            ->middleware('can:users.blockEnable');
    });
});

/**
 * Public access
 */
Route::get('/', [MapController::class, 'index'])
    ->middleware('checkBanned')
    ->name('map.index')
    ->breadcrumb('Mapa');
