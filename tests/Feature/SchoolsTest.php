<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTest()
    {
        //TODO 로그인/인증 사용자만
        $response = $this->json('POST', '/api/schools', [
            'name' => 'Sally',
            'location' => 'Sally',
        ]);
        
        
        $response->assertStatus(201)
        ->assertJsonFragment([
            'name' => 'Sally',
            'location' => 'Sally',
        ]);
    }
}
