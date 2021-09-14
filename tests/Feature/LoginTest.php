<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LoginTest extends TestCase
{

    use WithoutMiddleware;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }


    public function testLoginAValidUser()
    {
        $user = User::factory()->create();
        $userModel = User::find($user->id);
        $response = $this->post('/login', [
            'name' => $user->name,
            'email' => $user->email,
            'password' =>  $user->password,
        ]);

        $this->actingAs($userModel);
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }


    public function testDoesNotLoginAnInvalidUser()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'invalid'
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }


    //Perform a post() request to add a new user
    public function testIfItStoresNewUsers()
    {
        $response = $this->post('/register', [
            'name' => 'Dary',
            'email' => 'dary@gmail.com',
            'password' => 'dary1234',
            'password_confirmation' => 'dary1234'
        ]);
        $response->assertSessionHasErrors();
    }
}
