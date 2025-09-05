<?php

namespace App\Providers;

use App\AccessControl\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $this->loadViewsFrom(base_path('app/access-control/resources/views'), 'access-control');
        $this->loadViewsFrom(base_path('app/application/resources/views'), 'application');

        $modules = glob(app_path() . '/*', GLOB_ONLYDIR);
        foreach ($modules as $module) {
            if (is_dir("$module/Database/Migrations")) {
                $this->loadMigrationsFrom("$module/Database/Migrations");
            }
        }

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            $model = class_basename($modelName);
            $paths = [
                'App\\AccessControl\\Database\\Factories\\' . $model . 'Factory',
                'App\\Application\\Database\\Factories\\' . $model . 'Factory',
                'Database\\Factories\\' . $model . 'Factory',
            ];

            foreach ($paths as $factoryClass) {
                if (class_exists($factoryClass)) {
                    return $factoryClass;
                }
            }

            return null;
        });

        Factory::guessModelNamesUsing(function (Factory $factoryClass) {
            $factoryName = $factoryClass::class;
            $modelName = Str::replaceLast('Factory', '', $factoryName);

            // Exemplo: App\AccessControl\Database\Factories\UserRoleFactory
            $parts = explode('\\', $factoryName);

            // Pega o namespace do módulo (ex: AccessControl)
            $module = $parts[1] ?? null;

            // Pega o nome da classe sem o "Factory"
            $modelName = Str::replaceLast('Factory', '', class_basename($factoryName));

            // Monta o caminho completo da Model
            return "App\\$module\\Models\\$modelName";
        });

        Blade::directive('manifest', function ($expression) {
            return "<?php echo manifest_asset($expression); ?>";
        });
    }
}
