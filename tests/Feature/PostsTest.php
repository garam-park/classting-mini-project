<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use JWTAuth;

use App\Models\User;
use App\Models\School;
use App\Models\Post;

class PostsTest extends TestCase
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

        $posts = factory(Post::class,5)->create([
            'user_id' => $user->id
        ]);
        
        /**
         * 학교 페이지 별로 필터링
         */
        $schools = School::all();
        $school_ids = $schools->pluck('id');
        
        foreach ($school_ids as $key => $school_id) {

            $response = $this->withHeaders([
                'Authorization' => "Bearer $token",
            ])->get('/api/posts?school_id='.$school_id);
            
            foreach ($school_ids as $_key => $school_id) {
                if($_key==$key)
                    $response->assertSee('"school_id":"'.$school_id.'"');
                else 
                    $response->assertDontSee('"school_id":"'.$school_id.'"');
            }

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
                    "title",
                    "content",
                    "author",
                    "created_at",
                    "updated_at",
                ]]
            ]);
        }
        
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->get('/api/posts');
        
        $order = $posts->sortByDESC('created_at')->pluck('created_at');

        $response->assertSeeTextInOrder($order->toArray());

        
        /**
         * 오름차순
         */

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->get('/api/posts?asc=1');
        
        $order = $posts->sortBy('created_at')->pluck('created_at');

        $response->assertSeeTextInOrder($order->toArray());

        /**
         * 내림차순
         */

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->get('/api/posts?asc=0');
        
        $order = $posts->sortByDESC('created_at')->pluck('created_at');

        $response->assertSeeTextInOrder($order->toArray());


    }

}
