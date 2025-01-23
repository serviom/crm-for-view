<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\ErrorLogModel;
use App\Models\LandOwnership;
use App\Models\LandPurpose;
use App\Models\RoomPurpose;
use App\Models\RoomType;
use App\Models\User;
use App\Policies\ClientPolicy;
use App\Policies\ErrorLogPolicy;
use App\Policies\LandOwnershipPolicy;
use App\Policies\LandPurposePolicy;
use App\Policies\RolePolicy;
use App\Policies\RoomPurposePolicy;
use App\Policies\RoomTypePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
         Client::class => ClientPolicy::class,
         User::class => UserPolicy::class,
         Role::class => RolePolicy::class,
         ErrorLogModel::class => ErrorLogPolicy::class,
         LandPurpose::class => LandPurposePolicy::class,
         RoomType::class => RoomTypePolicy::class,
         RoomPurpose::class => RoomPurposePolicy::class,
         LandOwnership::class => LandOwnershipPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('SuperAdmin') ? true : null;
        });
    }
}
