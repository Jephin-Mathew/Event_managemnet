<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Event::class => \App\Policies\EventPolicy::class,
        \App\Models\Invitation::class => \App\Policies\InvitationPolicy::class,
        \App\Models\RequisitionItem::class => \App\Policies\RequisitionItemPolicy::class,
        \App\Models\Photo::class => \App\Policies\PhotoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
