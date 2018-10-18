<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use JWTAuth;

use App\Models\User;
use App\Models\School;
use App\Models\Post;

class SchoolsTest extends TestCase
{
    private $token;
    private $user;
    private $school;

    public function setUp()
    {
        parent::setUp();
        $password = str_random(12);

        $this->user = factory(User::class)->create([
            'password' => bcrypt($password),
        ]);

        $this->token = JWTAuth::attempt([
            'email'    => $this->user->email,
            'password' => $password,
        ]);
    }
    
    public function testCreateAndCreatPost()
    {
        $token = $this->token;
        $user  = $this->user;

        $school = factory(School::class)->make();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->json('POST', '/api/schools', $school->toArray());
        
        $response->assertStatus(201)
        ->assertJsonFragment([
            'name' =>  $school->name,
            'location' => $school->location,
        ]);
        
        $school = $user->schools->first();

        $role = $school->pivot->role;
        $this->assertEquals('admin',$role);

        //정상 포스트 생성
        $post = factory(Post::class)->make([
            'user_id'=>0,
            'school_id'=>0,
        ]);

        $school_id = $school->id;
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->json(
            'POST',
            "/api/schools/$school_id/posts",
            $post->toArray());
        
        $response->assertStatus(201)
        ->assertJsonFragment([
            'title' =>  $post->title,
            'content' => $post->content,
            'user_id' => $user->id,
            'school_id' => $school->id,
        ]);

        //
    }

    public function testSubscribeAndUnsunbcribe()
    {

        $token     = $this->token;
        $user      = $this->user;
        $school    = factory(School::class)->create();
        $school_id = $school->id;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post("/api/schools/$school_id/subscribe");
        
        //구독 정상 처리
        $response->assertStatus(200)
        ->assertJsonFragment([
            'name' => $school->name,
            'location' => $school->location,
        ]);

        //400
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post("/api/schools/$school_id/subscribe");

        $response->assertStatus(400);
        
        //404
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post("/api/schools/10000/subscribe");

        $response->assertStatus(404);

        //구독 해제 정상 처리

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post("/api/schools/$school_id/unsubscribe");

        $response->assertStatus(200)
        ->assertJsonFragment([
            'name' => $school->name,
            'location' => $school->location,
        ]);

        //404
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post("/api/schools/10000/unsubscribe");

        $response->assertStatus(404);


        //구독 5만명 500000 -> 5명
        config(['logic.subscribe_max' => 5]);
            
        factory(User::class, 5)->create()
        ->each(function ($u) use ($school_id){
            $u->subscribed_schools()->attach($school_id);
        });
        
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post("/api/schools/$school_id/subscribe");
        
        $response->assertStatus(416);
    }
}
