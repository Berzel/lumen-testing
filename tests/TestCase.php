<?php

namespace App\Tests;

use Laravel\Lumen\Testing\TestCase as TestingTestCase;

abstract class TestCase extends TestingTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }
}
