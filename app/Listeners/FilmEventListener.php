<?php

namespace App\Listeners;

use App\Events\FilmEvent;
use App\Repository\Backend\Interfaces\FilmRepositoryInterfaces;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FilmEventListener
{
    /**
     * @var FilmRepositoryInterfaces
     */
    protected $interfaces;

    /**
     * FilmEventListener constructor.
     * @param FilmRepositoryInterfaces $interfaces
     */
    public function __construct(FilmRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }

    /**
     * Handle the event.
     *
     * @param FilmEvent $event
     * @return void
     */
    public function handle(FilmEvent $event)
    {
        return call_user_func_array([$this->interfaces, $event->method], $event->param);
    }
}
