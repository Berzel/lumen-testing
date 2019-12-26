<?php

namespace App\Tests\Feature;

use App\Tests\TestCase;
use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RegisterUserTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Should return 201 response code when user created successfully
     *
     * @test
     * @return void
     */
    public function should_return_201_response_code_on_success()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(201, $response->status());
    }

    /**
     * Should save the user to the database
     *
     * @test
     * @return void
     */
    public function should_save_the_user_to_db()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->seeInDatabase('users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com'
        ]);
    }

    /**
     * Should encrypt the password when saving to database
     *
     * @test
     * @return void
     */
    public function should_encrypt_password_in_db()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->notSeeInDatabase('users', [
            'password' => 'secret123'
        ]);
    }

    /**
     * Should not return the password in JsonResponse
     *
     * @test
     * @return void
     */
    public function should_not_return_password_field_in_json_response()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->seeJsonDoesntContains(['password' => 'secret123']);
    }

    /**
     * Should assign an id to the user on creation
     *
     * @test
     * @return void
     */
    public function should_assign_an_id_to_the_created_user()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->seeJsonContains(['id' => 1]);
    }

    /**
     * Should return 422 response code when firstname not provided
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_firstname_not_provided()
    {
        $response = $this->call('POST', '/v1/users', [
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return 422 response code when firstname is longer than 255 characters
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_firstname_longer_than_255()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => '
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A consequatur cupiditate in consectetur harum sunt ipsum minus. Tempore nobis provident odio consequuntur quos at possimus assumenda voluptatem? Architecto possimus pariatur, voluptatibus animi aliquam provident nostrum et id numquam, eum quia sit quod nihil laboriosam libero suscipit excepturi velit voluptate molestias adipisci perspiciatis sunt esse sapiente cum. Quisquam, nihil vitae. Facere cumque quae reiciendis saepe amet corporis odit pariatur consequatur dolorem velit tempore deserunt voluptatem fugiat totam explicabo maiores dignissimos, eveniet qui illo repellendus? Iure ex harum veritatis ea voluptatum. Vel provident eos eum mollitia accusantium! Amet dolorum quae iusto natus.',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return 422 response code when lastname not provided
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_lastname_not_provided()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return valid json with all fields
     *
     * @test
     * @return void
     */
    public function should_return_valid_json_with_all_fields()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $user = User::find(1);

        $this->seeJsonContains([
            'id' => 1,
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com'
        ]);
    }

    /**
     * Should return 422 response code when lastname is longer than 255 characters
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_lastname_longer_than_255()
    {
        $response = $this->call('POST', '/v1/users', [
            'lastname' => '
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A consequatur cupiditate in consectetur harum sunt ipsum minus. Tempore nobis provident odio consequuntur quos at possimus assumenda voluptatem? Architecto possimus pariatur, voluptatibus animi aliquam provident nostrum et id numquam, eum quia sit quod nihil laboriosam libero suscipit excepturi velit voluptate molestias adipisci perspiciatis sunt esse sapiente cum. Quisquam, nihil vitae. Facere cumque quae reiciendis saepe amet corporis odit pariatur consequatur dolorem velit tempore deserunt voluptatem fugiat totam explicabo maiores dignissimos, eveniet qui illo repellendus? Iure ex harum veritatis ea voluptatum. Vel provident eos eum mollitia accusantium! Amet dolorum quae iusto natus.',
            'firstname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return 422 response code when email not provided
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_email_not_provided()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return 422 response code when email not valid
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_email_not_valid()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'invalidemail',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return 422 response code when email longer than 255 characters
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_email_longer_than_255()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => '
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A consequatur cupiditate in consectetur harum sunt ipsum minus. Tempore nobis provident odio consequuntur quos at possimus assumenda voluptatem? Architecto possimus pariatur, voluptatibus animi aliquam provident nostrum et id numquam, eum quia sit quod nihil laboriosam libero suscipit excepturi velit voluptate molestias adipisci perspiciatis sunt esse sapiente cum. Quisquam, nihil vitae. Facere cumque quae reiciendis saepe amet corporis odit pariatur consequatur dolorem velit tempore deserunt voluptatem fugiat totam explicabo maiores dignissimos, eveniet qui illo repellendus? Iure ex harum veritatis ea voluptatum. Vel provident eos eum mollitia accusantium! Amet dolorum quae iusto natus@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return 422 response code when email is already taken
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_email_already_taken()
    {
        $user = new User();
        $user->firstname = 'Berzel';
        $user->lastname = 'Tumbude';
        $user->email = 'berzel@app.com';
        $user->password = 'secret123';
        $user->save();

        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return 422 response code when password not provided
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_password_not_provided()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password_confirmation' => 'secret123'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return 422 response code when password shorter than 8 characters
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_password_shorter_than_8()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->assertEquals(422, $response->status());
    }

    /**
     * Should return 422 response code when password is not confirmed
     *
     * @test
     * @return void
     */
    public function should_return_422_response_code_when_password_is_not_confirmed()
    {
        $response = $this->call('POST', '/v1/users', [
            'firstname' => 'Berzel',
            'lastname' => 'Tumbude',
            'email' => 'berzel@app.com',
            'password' => 'secret123',
        ]);

        $this->assertEquals(422, $response->status());
    }
}
