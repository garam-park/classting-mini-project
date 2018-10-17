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
        /**
         * //TODO 로그인/인증 사용자만
         * #1 인증 부분 완료 후에 테스트를 더 추가해야한다.
         */
        
        $this->assertTrue(false);

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
