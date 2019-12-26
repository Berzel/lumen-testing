<?php

namespace App\Tests\Feature;

use App\Tests\TestCase;
use App\User;
use App\Utillities\HttpStatus;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DeleteUserTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Should return no content after deleting a user
     *
     * @test
     * @return void
     */
    public function should_return_no_content_after_deleting_a_user()
    {
        $this->delete('/v1/users/1');

        $this->seeStatusCode(HttpStatus::NO_CONTENT);
    }

    /**
     * Should softdelete a user
     *
     * @test
     * @return void
     */
    public function should_soft_delete_a_user()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->delete('/v1/users/1');

        $this->seeInDatabase('users', [
            'email' => 'berzel@app.com'
        ]);

        $this->assertEquals(0, User::all()->count());
        $this->assertEquals(1, User::withTrashed()->get()->count());
    }
}
