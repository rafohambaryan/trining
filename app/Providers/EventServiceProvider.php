<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $models = glob(app_path('Models') . '/' . '*.php');
        foreach ($models as $index => $item) {
            $model = pathinfo($item, PATHINFO_FILENAME);
            if (file_exists(app_path("Events/{$model}Event.php")) &&
                file_exists(app_path("Listeners/{$model}EventListener.php"))) {
                $this->listen["App\Events\\{$model}Event"] = ["App\Listeners\\{$model}EventListener"];
            }
        }
        parent::boot();
        //
    }
}
