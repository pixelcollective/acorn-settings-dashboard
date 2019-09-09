<?php
namespace TinyPixel\Settings\Providers;

use function \Roots\config_path;
use \Illuminate\Support\Collection;
use \Roots\Acorn\ServiceProvider;
use \TinyPixel\Settings\Dashboard;

/**
 * Admin menu services provider
 *
 * @author Kelly Mears <kelly@tinypixel.dev>
 * @license MIT
 * @since   0.0.1
 */
class DashboardServiceProvider extends ServiceProvider
{
    /**
      * Register any application services.
      *
      * @return void
      */
    public function register()
    {
        $this->app->singleton('wordpress.dashboard', function () {
            return new Dashboard($this->app);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $config = __DIR__ . '/../config/wordpress/dashboard.php';

        $this->publishes([$config => config_path('wordpress/dashboard.php')]);

        $this->app->make('wordpress.dashboard')->init(Collection::make(
            $this->app['config']->get('wordpress.dashboard')
        ));
    }
}
