<?php

namespace Tests\Feature;

use Tests\TestCase;


class LoginPageTest extends TestCase
{


    // use WithoutMiddleware;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    //Check if login page exists
    public function testLoginForm()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }


}
