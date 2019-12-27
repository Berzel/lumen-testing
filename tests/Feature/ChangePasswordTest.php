<?php

namespace App\Tests\Feature;

use App\User;
use App\Tests\TestCase;
use App\Utillities\HttpStatus;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ChangePasswordTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Should return not found if user not in database
     *
     * @test
     * @return void
     */
    public function should_return_not_found_if_user_not_in_database()
    {
        $this->put('/v1/users/1/password', [
            'old_password' => 'secret123',
            'new_password' => 'new123password',
            'new_password_confirmation' => 'new123password'
        ]);

        $this->seeStatusCode(HttpStatus::NOT_FOUND);
        $this->seeJsonContains(['message' => 'The user with id: 1, was not found']);
    }

    /**
     * Should return ok after user changed their password
     *
     * @test
     * @return void
     */
    public function should_return_ok_after_user_changed_password()
    {
        factory(User::class)->create();

        $this->put('/v1/users/1/password', [
            'old_password' => 'secrete123',
            'new_password' => 'new123password',
            'new_password_confirmation' => 'new123password'
        ]);

        $this->seeStatusCode(HttpStatus::OK);
        $this->seeJsonContains(['message' => 'The password has been changed successfully.']);

        // Just verifying if old password has been invalidated
        $user = User::find(1);
        $this->assertFalse(Hash::check('secrete123', $user->password));
        $this->assertTrue(Hash::check('new123password', $user->password));
    }

    /**
     * Should return unprocessable entity if old password is not provided
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_old_password_not_provided()
    {
        factory(User::class)->create();

        $this->put('/v1/users/1/password', [
            'new_password' => 'new123password',
            'new_password_confirmation' => 'new123password'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
        $this->seeJsonContains([
            'old_password' => ['The old password field is required.']
        ]);
    }

    /**
     * Should return unprocessable entity if old password doesn't match actual password
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_old_password_not_match_actual()
    {
        factory(User::class)->create();

        $this->put('/v1/users/1/password', [
            'old_password' => 'someMadeUpPassword',
            'new_password' => 'new123password',
            'new_password_confirmation' => 'new123password'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
        $this->seeJsonContains([
            'old_password' => ['The old password is not correct.']
        ]);
    }

    /**
     * Should return unprocessable entity if old password is less than 8 characters long
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_old_password_less_than_8()
    {
        factory(User::class)->create();

        $this->put('/v1/users/1/password', [
            'old_password' => 'secret',
            'new_password' => 'new123password',
            'new_password_confirmation' => 'new123password'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
        $this->seeJsonContains([
            'old_password' => ['The old password must be at least 8 characters.']
        ]);
    }

    /**
     * Should return unprocessable entity if new password is not provided
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_new_password_not_provided()
    {
        factory(User::class)->create();

        $this->put('/v1/users/1/password', [
            'old_password' => 'secrete123',
            'new_password_confirmation' => 'new123password'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
        $this->seeJsonContains([
            'new_password' => ['The new password field is required.']
        ]);
    }

    /**
     * Should return unprocessable entity if new password is less than 8 characters long
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_new_password_less_than_8()
    {
        factory(User::class)->create();

        $this->put('/v1/users/1/password', [
            'old_password' => 'secrete123',
            'new_password' => 'secre',
            'new_password_confirmation' => 'secre'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
        $this->seeJsonContains([
            'new_password' => ['The new password must be at least 8 characters.']
        ]);
    }

    /**
     * Should return unprocessable entity if new password is not confirmed
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_new_password_not_confirmed()
    {
        factory(User::class)->create();

        $this->put('/v1/users/1/password', [
            'old_password' => 'secrete123',
            'new_password' => 'new123password'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
        $this->seeJsonContains([
            'new_password' => ['The new password confirmation does not match.']
        ]);
    }

    /**
     * Should return unprocessable entity if old and new password similar
     *
     * @test
     * @return void
     */
    public function should_return_unprocessable_entity_if_new_and_old_password_same()
    {
        factory(User::class)->create();

        $this->put('/v1/users/1/password', [
            'old_password' => 'secrete123',
            'new_password' => 'secrete123',
            'new_password_confirmation' => 'secrete123'
        ]);

        $this->seeStatusCode(HttpStatus::UNPROCESSABLE_ENTITY);
        $this->seeJsonContains([
            'new_password' => ['The new password must be different from the old password.']
        ]);
    }
}
