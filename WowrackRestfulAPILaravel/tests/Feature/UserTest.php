<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testRegisterSuccess()
    {
        $this->post('/api/users/register',[
            'name' => 'Welldan',
            'email' => 'welldan@gmail.com',
            'password' => '123123123'
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    'name' => 'Welldan',
                    'email' => 'welldan@gmail.com'
                ]
            ]);
    }
    public function testRegisterFailed()
    {

    }
    public function testRegisterEmailAlreadyExist()
    {

    }
}
