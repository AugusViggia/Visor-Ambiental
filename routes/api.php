<?php

use App\Http\Resources\PointResource;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Add protected api end points here
 */
Route::name('api.')->middleware('auth:sanctum')->group(function () {
    // @TODO create protected endpoints

    Route::get('/users/index', [\App\Http\Controllers\Api\UsersController::class, 'index'])
        ->name('users.index');

    Route::prefix('/points')->name('points.')->group(function () {
        Route::post('/import', [\App\Http\Controllers\Api\PointsController::class, 'import'])
            ->name('import');
    });

    Route::get(
        '/points/stats/user/{id}',
        [\App\Http\Controllers\Api\PointsController::class, 'getStatsUser']
    )->name('points.stats.user');

    Route::get(
        '/points/stats/admin',
        [\App\Http\Controllers\Api\PointsController::class, 'getStatsAdmin']
    )->name('points.stats.admin');

    Route::post(
        '/observation',
        [\App\Http\Controllers\Api\PointsController::class, 'processObservation']
    )->name('observations.process');
});

/**
 * Public access
 */
Route::get('/points/geojson', [\App\Http\Controllers\Api\PointsController::class, 'geojson'])
    ->name('api.points.geojson');

Route::get('/static/layers', [\App\Http\Controllers\Api\StaticLayersController::class, 'index'])
    ->name('api.static.layers.index');

Route::get('/static/layers/get', [\App\Http\Controllers\Api\StaticLayersController::class, 'show'])
    ->name('api.static.layers.show');
