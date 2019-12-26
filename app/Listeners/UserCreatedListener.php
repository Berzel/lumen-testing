<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Services\AMQPService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AMQPService $amqpService)
    {
        $this->amqpService = $amqpService;
    }

    /**
     * Publish the event to RabbitMQ
     *
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $this->amqpService->publish($event);
    }
}
