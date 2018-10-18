<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use JWTAuth;

class SchoolsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTest()
    {
       
        $password = str_random(12);

        $user = factory(\App\Models\User::class)->create([
            'name'     => 'Abigail',
            'password' => bcrypt($password),
        ]);

        $token = JWTAuth::attempt([
            'email'    => $user->email,
            'password' => $password,
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->json('POST', '/api/schools', [
            'name' => 'Sally',
            'location' => 'Sally',
        ]);
        
        
        $response->assertStatus(201)
        ->assertJsonFragment([
            'name' => 'Sally',
            'location' => 'Sally',
        ]);
        
        $role = $school = $user->schools->first()->pivot->role;
        $this->assertEquals('admin',$role);
    }
}
