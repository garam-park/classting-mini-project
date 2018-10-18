<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use JWTAuth;

use App\Models\User;
use App\Models\School;
use App\Models\Post;

class SubscriptionTest extends TestCase
{
    
    public function testIndex()
    {
        $password = str_random(12);

        $user = factory(User::class)->create([
            'password' => bcrypt($password),
        ]);

        $token = JWTAuth::attempt([
            'email'    => $user->email,
            'password' => $password,
        ]);

        $posts = factory(Post::class,10)->create([
            'user_id' => $user->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->get('/api/subscribed-schools');

        $response->assertStatus(200)
        ->assertJsonStructure([
            'current_page',
            'first_page_url',
            'from',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'data' => [
                '*'=> [
                "id",
                "name",
                "location",
            ]]
        ]);
    }

}
