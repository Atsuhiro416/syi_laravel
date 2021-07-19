<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegisterUser()
    {
        $this->withoutExceptionHandling();
        $user = [
            'email' => 'test@test.com',
            'password' => 'test1234',
        ];
        $response = $this->postJson('/api/register', $user);
        $response->assertStatus(201)->assertJsonFragment([
            'email' => 'test@test.com',
        ]);
    }

    public function testLogin()
    {
        $this->withoutExceptionHandling();
        $user = [
            'email' => 'test@test.com',
            'password' => 'test1234',
        ];
        $response = $this->postJson('/api/login', $user);
        $response->assertStatus(200)->assertJsonFragment([
            'email' => 'test@test.com',
            'auth' => true,
        ]);
    }

    public function testLogout()
    {
        $this->withoutExceptionHandling();
        $user = User::where('email', 'test@test.com')->first();
        $to_array_user = $user->toArray();
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$user->api_token}"
        ])->postJson("/api/logout", $to_array_user);
        $response->assertStatus(200)->assertJsonFragment([
            'auth' => false,
        ]);
    }

    // public function testIndexUsers()
    // {
    //     $this->withoutExceptionHandling();
    //     $response = $this->getJson('/api/users');
    //     $response->assertStatus(200);
    // }

    public function testShowUser()
    {
        $this->withoutExceptionHandling();
        $this->testLogin(); //トークン生成のためログイン
        $user = User::where('email', 'test@test.com')->first();
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$user->api_token}"
        ])->getJson("/api/users/{$user->id}");
        $response->assertStatus(200)->assertJsonFragment([
            'email' => 'test@test.com',
        ]);
    }

    public function testUpdateUser()
    {
        $this->withoutExceptionHandling();
        $user = User::where('email', 'test@test.com')->first();
        $data = [
            'email' => 'test123@test.com'
        ];
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$user->api_token}"
        ])->putJson("/api/users/{$user->id}", $data);
        $response->assertStatus(200)->assertJsonFragment([
            'email' => 'test123@test.com',
        ]);
    }

    public function testDeleteUser()
    {
        $this->withoutExceptionHandling();
        $user = User::where('email', 'test123@test.com')->first();
        $user_id = $user->id;
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$user->api_token}"
        ])->deleteJson("/api/users/{$user->id}");
        $response->assertStatus(200);
        $this->assertNull(User::find($user_id));
    }
}
