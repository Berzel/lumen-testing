<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;

    abstract public function getName();
    abstract public function getData();
}
