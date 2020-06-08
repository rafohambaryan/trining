<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackendProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $models = glob(app_path('Models').'/'.'*.php');
        foreach ($models as $index => $item) {
            $model = pathinfo($item, PATHINFO_FILENAME);
            if (file_exists(app_path("Repository/Backend/Interfaces/{$model}RepositoryInterfaces.php")) &&
                file_exists(app_path("Repository/Backend/{$model}Repository.php"))) {
                $this->app->bind(
                    "App\Repository\Backend\Interfaces\\{$model}RepositoryInterfaces",
                    "App\Repository\Backend\\{$model}Repository"
                );
            }
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}



