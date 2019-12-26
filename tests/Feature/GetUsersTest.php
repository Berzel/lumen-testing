<?php

namespace App\Tests\Feature;

use App\User;
use App\Tests\TestCase;
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
        $total = 5;
        $perPage = 1;
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

        // Last pages may give different lengths do be careful
        $this->assertEquals($perPage, count($responseData->data));
    }

    /**
     * Should return not found if try to get a user who doesn't exist
     *
     * @test
     * @return void
     */
    public function should_return_not_found_if_get_non_existent_user()
    {
        $this->get('/v1/users/1');
        $this->seeStatusCode(HttpStatus::NOT_FOUND);
        $this->seeJsonContains(['message' => 'The user with id: 1, was not found']);
    }

    /**
     * Should return specified user
     *
     * @test
     * @return void
     */
    public function should_return_specified_user()
    {
        $user = factory(User::class)->create();

        $this->get('/v1/users/1');
        $this->seeStatusCode(HttpStatus::OK);
        $this->seeJsonContains([
            'id' => $user->id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email
        ]);
    }
}
