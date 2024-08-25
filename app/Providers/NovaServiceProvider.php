<?php

namespace App\Providers;

use App\Nova\CPU;
use App\Nova\NVR;
use App\Nova\User;
use App\Nova\Svich;
use App\Nova\Assign;
use App\Nova\Branch;
use App\Nova\Laptop;
use App\Nova\Company;
use App\Nova\History;
use App\Nova\IpPhone;
use App\Nova\Printer;
use App\Nova\Version;
use App\Nova\Firewall;
use Laravel\Nova\Nova;
use App\Nova\Biometric;
use App\Nova\Processor;
use App\Nova\Department;
use App\Nova\NetworkNVR;
use App\Nova\SmartPhone;
use App\Nova\AccessPoint;
use App\Nova\Manufacturer;
use App\Nova\NetworkSwitch;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        parent::boot();

        Nova::mainMenu(function (Request $request) {
            return [

                MenuSection::make('Quick Actions',[
                    MenuItem::resource(Assign::class),
                    MenuItem::resource(History::class),
                  ])->icon('user')->collapsable(),
                MenuSection::make('Inventory', [
                    MenuItem::resource(Laptop::class),
                    MenuItem::resource(IpPhone::class),
                    MenuItem::resource(SmartPhone::class),
                    MenuItem::resource(CPU::class),
                    MenuItem::resource(AccessPoint::class),
                    MenuItem::resource(Biometric::class),
                    MenuItem::resource(NetworkNVR::class),
                    MenuItem::resource(NetworkSwitch::class),
                    MenuItem::resource(Firewall::class),
                    MenuItem::resource(Printer::class),






                 ])->icon('user')->collapsable(),


                MenuSection::make('Predefined', [
                    MenuItem::resource(Manufacturer::class),
                    MenuItem::resource(Processor::class),
                    MenuItem::resource(Version::class),
                    MenuItem::resource(Branch::class),
                    MenuItem::resource(Department::class),
                    MenuItem::resource(Company::class),
                 ])->icon('user')->collapsable(),


                MenuSection::make('User',[
                    MenuItem::resource(User::class),
                ])->icon('user')->collapsable(),
            ];

        });

        Nova::footer(function(){
            return Blade::render('<div><section class="">
  <!-- Footer -->
  <footer class="text-center text-white" style="background-color: #E30016;">
    <!-- Grid container -->
    <div class="container p-4 pb-0">
      <!-- Section: CTA -->
      <section class="">
        <p class="d-flex justify-content-center align-items-center">
          <span class="me-3">Inventory Management Software </span>
          <button data-mdb-ripple-init type="button" class="btn btn-outline-light btn-rounded">

          </button>
        </p>
      </section>
      <!-- Section: CTA -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
           <a class="text-white" href="www.linkedin.com/in/yudhvir001">Developed by Yudhvir Singh with love🤍🤍 </a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
</section></div>');
        });


    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes(default: true)
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
