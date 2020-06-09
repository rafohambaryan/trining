<?php

namespace App\Listeners;

use App\Events\LineEvent;
use App\Repository\Backend\Interfaces\LineRepositoryInterfaces;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LineEventListener
{
    protected $interfaces;

    /**
     * LineEventListener constructor.
     * @param LineRepositoryInterfaces $interfaces
     */
    public function __construct(LineRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }

    /**
     * Handle the event.
     *
     * @param LineEvent $event
     * @return void
     */
    public function handle(LineEvent $event)
    {
        return call_user_func_array([$this->interfaces, $event->method], $event->param);
    }
}
