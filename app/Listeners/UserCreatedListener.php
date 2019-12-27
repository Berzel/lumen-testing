<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Services\AMQPService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Listens for the UserCreated event
     *
     * @param \App\Services\AMQPService $amqpService
     * @return void
     */
    public function __construct(AMQPService $amqpService)
    {
        $this->amqpService = $amqpService;
    }

    /**
     * Publish the event to RabbitMQ
     *
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $this->amqpService->publish($event);
    }
}
