<?php

namespace App\Listeners;

use App\Services\AMQPService;
use App\Events\PasswordChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordChangedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Listens for the PasswordChanged event
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
     * @param  \App\Events\PasswordChanged  $event
     * @return void
     */
    public function handle(PasswordChanged $event)
    {
        $this->amqpService->publish($event);
    }
}
