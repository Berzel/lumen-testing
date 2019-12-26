<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Services\AMQPService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdatedListener
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
    public function handle(UserUpdated $event)
    {
        $this->amqpService->publish($event);
    }
}
