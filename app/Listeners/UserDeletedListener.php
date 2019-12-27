<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use App\Services\AMQPService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDeletedListener
{
    /**
     * Listens for the UserDeleted event
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
     * @param  \App\Events\UserDeleted  $event
     * @return void
     */
    public function handle(UserDeleted $event)
    {
        $this->amqpService->publish($event);
    }
}
