<?php

namespace App\Listeners;

use App\Events\CheckedEvent;
use App\Repository\Backend\Interfaces\CheckedRepositoryInterfaces;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckedEventListener
{

    protected $interfaces;

    public function __construct(CheckedRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }

    /**
     * Handle the event.
     *
     * @param CheckedEvent $event
     * @return void
     */
    public function handle(CheckedEvent $event)
    {
        return call_user_func_array([$this->interfaces, $event->method], $event->param);
    }
}
