<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(
            parent::share($request),
            [
                'application' => [
                    'name' => config('app.name'),
                    'app_logo' => asset('images/logo.svg'),
                    'bg_image' => asset('images/bg.png'),
                    'oa_logo' => asset('images/oa-logo.png'),
                    'app_developers' => env('APP_DEVELOPERS'),
                    'app_developers_site' => env('APP_DEVELOPERS_SITE'),
                    'app_organization_full' => env('APP_ORGANIZATION_FULL'),
                    'app_organization_site' => env('APP_ORGANIZATION_SITE'),
                    'app_version' => env('APP_VERSION', '0.0.0-beta-release'),
                    'can_search' => false,
                ],
                'alert' => getAlert(),
                'breadcrumbs' => $request->route()->breadcrumbs()->jsonSerialize(),
                'language' => function () {
                    return loadTranslations();
                },
                'locale' => function () {
                    return app()->getLocale();
                },
                'auth.roles' => fn () => $request->user()
                    ? $request->user()->getRoleNames()
                    : [],
                'auth.permissions' => fn () => $request->user()
                    ? $request->user()->getAllPermissions()->pluck('name')
                    : [],
            ]
        );
    }
}
