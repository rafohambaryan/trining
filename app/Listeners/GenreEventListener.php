<?php

namespace App\Listeners;

use App\Events\GenreEvent;
use App\Repository\Backend\Interfaces\GenreRepositoryInterfaces;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenreEventListener
{
    protected $interfaces;

    /**
     * LineEventListener constructor.
     * @param GenreRepositoryInterfaces $interfaces
     */
    public function __construct(GenreRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }

    /**
     * Handle the event.
     *
     * @param GenreEvent $event
     * @return void
     */
    public function handle(GenreEvent $event)
    {
        return call_user_func_array([$this->interfaces, $event->method], $event->param);
    }
}
