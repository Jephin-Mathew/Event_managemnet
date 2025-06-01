<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
    Livewire::component('event-gallery-view', \App\Livewire\EventGalleryView::class);
    Livewire::component('event-gallery-upload', \App\Livewire\EventGalleryUpload::class);
}
}
