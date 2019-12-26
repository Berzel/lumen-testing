<?php

namespace App\Tests\Feature;

use App\Tests\TestCase;
use App\Utillities\HttpStatus;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UpdateUserTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Shoudl return not found response when specified user not in database
     *
     * @test
     * @return void
     */
    public function should_return_not_found_if_user_not_found()
    {
        $response = $this->call('PUT', '/v1/users/1', [
            'firstname' => 'Berzel'
        ]);

        $this->seeStatusCode(HttpStatus::NOT_FOUND);
    }

    /**
     * Shoudl return unprocessable entity if firstname is not provided
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_firstname_not_provided()
    {
        $this->post('/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response = $this->call('PUT', '/v1/users/1', [
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    /**
     * Shoudl not change the id of the user during update
     *
     * @test
     * @return void
     */
    public function should_not_change_the_id_of_the_user_on_update()
    {
        $this->post('/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response = $this->call('PUT', '/v1/users/1', [
            'firstname' => 'Best',
            'lastname' => 'Sanchez',
            'email' => 'new@app.com'
        ]);

        $this->seeJsonContains(['id' => 1]);
    }

    /**
     * Shoudl update the user with the new details
     *
     * @test
     * @return void
     */
    public function should_update_the_user_with_the_new_details()
    {
        $this->post('/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response = $this->call('PUT', '/v1/users/1', [
            'firstname' => 'Best',
            'lastname' => 'Sanchez',
            'email' => 'sanchez@app.com'
        ]);

        $this->seeJsonContains([
            'firstname' => 'Best',
            'lastname' => 'Sanchez',
            'email' => 'sanchez@app.com'
        ]);
    }

    /**
     * Shoudl return unprocessable entity if firstname is longer than 255
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_firstname_longer_than_255()
    {
        $this->post('/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response = $this->call('PUT', '/v1/users/1', [
            'firstname' => '
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A consequatur cupiditate in consectetur harum sunt ipsum minus. Tempore nobis provident odio consequuntur quos at possimus assumenda voluptatem? Architecto possimus pariatur, voluptatibus animi aliquam provident nostrum et id numquam, eum quia sit quod nihil laboriosam libero suscipit excepturi velit voluptate molestias adipisci perspiciatis sunt esse sapiente cum. Quisquam, nihil vitae. Facere cumque quae reiciendis saepe amet corporis odit pariatur consequatur dolorem velit tempore deserunt voluptatem fugiat totam explicabo maiores dignissimos, eveniet qui illo repellendus? Iure ex harum veritatis ea voluptatum. Vel provident eos eum mollitia accusantium! Amet dolorum quae iusto.',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    /**
     * Shoudl return unprocessable entity if lastname is not provided
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_lastname_not_provided()
    {
        $this->post('/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response = $this->call('PUT', '/v1/users/1', [
            'firstname' => 'Berzel',
            'email' => 'berzel@app.com'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    /**
     * Shoudl return unprocessable entity if lastname is longer than 255
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_lastname_longer_than_255()
    {
        $this->post('/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response = $this->call('PUT', '/v1/users/1', [
            'lastname' => '
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A consequatur cupiditate in consectetur harum sunt ipsum minus. Tempore nobis provident odio consequuntur quos at possimus assumenda voluptatem? Architecto possimus pariatur, voluptatibus animi aliquam provident nostrum et id numquam, eum quia sit quod nihil laboriosam libero suscipit excepturi velit voluptate molestias adipisci perspiciatis sunt esse sapiente cum. Quisquam, nihil vitae. Facere cumque quae reiciendis saepe amet corporis odit pariatur consequatur dolorem velit tempore deserunt voluptatem fugiat totam explicabo maiores dignissimos, eveniet qui illo repellendus? Iure ex harum veritatis ea voluptatum. Vel provident eos eum mollitia accusantium! Amet dolorum quae iusto.',
            'firstname' => 'Berzel',
            'email' => 'berzel@app.com'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    /**
     * Shoudl return unprocessable entity if email is not provided
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_email_not_provided()
    {
        $this->post('/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response = $this->call('PUT', '/v1/users/1', [
            'lastname' => 'Tumbude',
            'firstname' => 'Berzel'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    /**
     * Shoudl return unprocessable entity if email is not valid
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_email_not_valid()
    {
        $this->post('/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response = $this->call('PUT', '/v1/users/1', [
            'lastname' => 'Tumbude',
            'firstname' => 'Berzel',
            'email' => 'invalidaemail'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
    }

    /**
     * Shoudl return unprocessable entity if email belongs to another user
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_email_belongs_to_another_user()
    {
        $this->post('/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->post('/v1/users', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $response = $this->call('PUT', '/v1/users/1', [
            'lastname' => 'Tumbude',
            'firstname' => 'Berzel',
            'email' => 'john@app.com'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
    }
}
