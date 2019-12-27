<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;

    /**
     * Get the name of the event
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Get the event payload
     *
     * @return $mixed
     */
    abstract public function getData();
}
