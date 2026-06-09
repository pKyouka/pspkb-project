<?php

namespace App\Providers;

use App\Services\MenuService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->shareFrontendLayoutData();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function shareFrontendLayoutData(): void
    {
        View::composer('layouts.frontend', function ($view): void {
            $menuService = app(MenuService::class);

            $view->with([
                'headerMenu' => $view->getData()['headerMenu'] ?? $menuService->findByLocation('header'),
                'footerMenu' => $view->getData()['footerMenu'] ?? $menuService->findByLocation('footer'),
            ]);
        });
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
