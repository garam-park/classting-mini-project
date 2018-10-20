<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\School;
use App\Models\Post;

class DevDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //기본 학교 -> 10 군대
        $schools = factory(School::class,10)->create();

        //기본 유저 -> 5만 1명
        $admin = factory(User::class)->create([
            'name'     => 'garam park',
            'email'    => 'garam-park@naver.com',
            'password' => bcrypt("password"),
        ]);

        $users = factory(User::class,20)->create([
            'password' => bcrypt("password"),
        ]);
        
        $school_ids = $schools->pluck('id');
        $school_ids_with_admin_role = collect();
        
        foreach ($school_ids as $school_id) {
            $school_ids_with_admin_role->put($school_id,['role' => 'admin']);
        }
        
        $admin->subscribed_schools()->attach($school_ids);
        $admin->schools()->attach($school_ids_with_admin_role);
        

        // //구독 -> 5만인 1번 학교, 나머진 10명씩
        
        // 모두 구독하는 학교
        $school = $schools->pop();
        $school->subscribing_users()->attach($users->pluck('id'));
        
        //나머진 10명씩
        foreach ($schools as $key => $school) {
            //기본 포스트 -> 학교 별로 10개
            $post = factory(Post::class,10)->create([
                'user_id'=>$admin->id,
                'school_id'=>$school->id,
            ]);

            $school->subscribing_users()->attach($users->random(10)->pluck('id'));
        }        
    }
}
