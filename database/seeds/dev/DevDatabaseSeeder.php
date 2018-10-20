<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\School;
use App\Models\Post;
use App\Models\Subscription;

use Faker\Generator as Faker;

class DevDatabaseSeeder extends Seeder
{
    public function __construct(Faker $faker) {
        $this->faker = $faker;
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //기본 학교 -> 10 군대
        $schools = factory(School::class,10)->create();

        // //기본 유저 -> 5만 1명
        $admin = factory(User::class)->create([
            'name'     => 'garam park',
            'email'    => 'garam-park@naver.com',
            'password' => bcrypt("password"),
        ]);

        print("insert start\n");
        \DB::unprepared(\File::get(base_path().'/database/seeds/sqls/users.sql'));
        print("inserted\n");
        $users = User::where('id','!=',$admin->id)->get();
        
        $school_ids = $schools->pluck('id');
        $school_ids_with_admin_role = collect();
        
        foreach ($school_ids as $school_id) {
            $school_ids_with_admin_role->put($school_id,['role' => 'admin']);
        }
        
        $admin->subscribed_schools()->attach($school_ids);
        $admin->schools()->attach($school_ids_with_admin_role);
        

        //구독 -> 5만인 1번 학교, 나머진 10명씩
        
        // 모두 구독하는 학교
        $school = $schools->pop();
        print("subscribing\n");
        $subscriptions = collect();
        $school_id = $school->id;
        
        for ($i=2; $i <= 50000; $i++) { 
            $subscriptions->push([
                'user_id'=>$i,
                'school_id'=>$school_id
            ]);
        };
        
        $chunks = $subscriptions->chunk(1000);
        
        foreach ($chunks as $key => $chunk) {
            Subscription::insert($chunk->toArray());
        }
        
        print("subscribed\n");
        
        //나머진 10명씩
        foreach ($schools as $key => $school) {
            //기본 포스트 -> 학교 별로 10개0
            for($i = 0 ; $i <=10; $i++){
                $post = Post::create([
                    'title' => $this->faker->title,
                    'content' => $this->faker->text($maxNbChars = 1000),
                    'user_id'=>$admin->id,
                    'school_id'=>$school->id,
                ]);
            }

            $school->subscribing_users()->attach($users->random(10)->pluck('id'));
        }        
    }
}
