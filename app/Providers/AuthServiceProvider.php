<?php

namespace App\Providers;
use App\Models\Acao;
use App\Models\Area;
use App\Models\Discente;
use App\Models\Inscricao;
use App\Models\TipoAcao;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Policies\AcaoPolicy;
use App\Policies\ActivityPolicy;
use App\Policies\AreaPolicy;
use App\Policies\DiscentePolicy;
use App\Policies\InscricaoPolicy;
use App\Policies\TipoAcaoPolicy;
use App\Policies\UserPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Acao::class => AcaoPolicy::class,
        Area::class => AreaPolicy::class,
        Discente::class => DiscentePolicy::class,
        Inscricao::class => InscricaoPolicy::class,
        TipoAcao::class => TipoAcaoPolicy::class,
        User::class => UserPolicy::class, 
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        Activity::class => ActivityPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
