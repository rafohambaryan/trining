<?php

namespace App\Listeners;

use App\Events\DateFilmEvent;
use App\Repository\Backend\Interfaces\DateFilmRepositoryInterfaces;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DateFilmEventListener
{
    /**
     * @var DateFilmRepositoryInterfaces
     */
    protected $interfaces;

    /**
     * DateFilmEventListener constructor.
     * @param DateFilmRepositoryInterfaces $interfaces
     */
    public function __construct(DateFilmRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }


    /**
     * Handle the event.
     *
     * @param DateFilmEvent $event
     * @return void
     */
    public function handle(DateFilmEvent $event)
    {
        return call_user_func_array([$this->interfaces, $event->method], $event->param);
    }
}
