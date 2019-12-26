<?php

namespace App\Tests\Feature;

use App\Tests\TestCase;
use App\User;
use App\Utillities\HttpStatus;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GetUsersTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Should return success on request to users index
     *
     * @test
     * @return void
     */
    public function should_always_return_ok()
    {
        $this->get('/v1/users');

        $this->seeStatusCode(HttpStatus::OK);
        $this->seeJsonContains(['per_page' => 15]);
    }

    /**
     * Should return the specified number of items per page
     *
     * @test
     * @return void
     */
    public function should_return_the_specified_number_of_items_per_page()
    {
        $total = 100;
        $perPage = 10;
        $currentPage = 2;

        $users = factory(User::class, $total)->create();

        $response = $this->call('GET', '/v1/users', [
            'page' => $currentPage,
            '_size' => $perPage,
        ]);

        $responseData = $response->getData();

        $this->seeJsonContains(['total' => $total]);
        $this->seeJsonContains(['per_page' => $perPage]);
        $this->seeJsonContains(['current_page' => $currentPage]);

        $this->assertEquals($perPage, count($responseData->data));
    }
}
