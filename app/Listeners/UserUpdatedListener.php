<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Services\AMQPService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Listens for the UserUpdated event
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
     * @param  \App\Events\UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        $this->amqpService->publish($event);
    }
}
