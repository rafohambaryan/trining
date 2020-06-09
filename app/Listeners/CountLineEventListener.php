<?php

namespace App\Listeners;

use App\Events\CountLineEvent;
use App\Repository\Backend\Interfaces\CountLineRepositoryInterfaces;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CountLineEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $interfaces;

    public function __construct(CountLineRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }

    /**
     * Handle the event.
     *
     * @param CountLineEvent $event
     * @return void
     */
    public function handle(CountLineEvent $event)
    {
        return call_user_func_array([$this->interfaces, $event->method], $event->param);
    }
}
