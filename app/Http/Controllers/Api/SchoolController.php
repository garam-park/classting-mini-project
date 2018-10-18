<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\School;
use App\Models\Post;

use Illuminate\Auth\AuthManager as Auth;

class SchoolController extends Controller
{
    protected $auth;
    
    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    public function create(Request $request)
    {
        $school_dto = $request->only([
            'name',
            'location'
        ]);

        $validator = Validator::make($school_dto, [
            'name'     => 'required|string|max:191',
            'location' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            
            $errors = $validator->errors()->all();
            
            return response([
                'message' => "validation failed",
                'errors'  => $errors
            ],400);
        }

        try {
            
            $user = $this->auth->user();

            $school = $user->schools()->save(
                new School($school_dto),
                ['role' => 'admin']
            );
            
            return response($school,201);
        }catch(\Exception $e){
            return response([
                'message' => "server error",
                'errors'  => [$e->getMessage()]
            ],400);
        }
        
    }

    public function subscribe(Request $request,$id)
    {

        if($school = School::find($id)){    
            
            // 5만명까지만 구독할 수 있음.
            if($school->subscriptions()->count() > 50000){
                
                $id = $school->id;
                $name = $school->name;
                
                return response([
                    'message' => "인원 초과로 더 이상 $name 학교페이지를 구독할 수 없습니다. 나중에 다시 시도해주세요.",
                    'errors'  => ["id(:$id) can't accept Subscriptions"]
                ],416);
            }
            
            $user = $this->auth->user();
            
            try{
                $user->subscribed_schools()->save($school);
            }catch(\Exception $e){

                if($e->getCode() == 23000){
                    return response([
                        'message' => "이미 구독중입니다.",
                        'errors'  => $e->getMessage()
                    ],400);
                } else {
                    return response([
                        'message' => "구독 중에 에러가 발생했습니다.",
                        'errors'  => $e->getMessage()
                    ],500);
                }
            }
            

        } else {
            return response([
                'message' => "Not Found",
                'errors'  => ["id(:$id) is Not found"]
            ],404);

        }
        return $school;
    }

    public function unsubscribe(Request $request,$id)
    {

        if($school = School::find($id)){    
            
            $user = $this->auth->user();
            
            $user->subscribed_schools()->detach($school->id);

        } else {
            return response([
                'message' => "Not Found",
                'errors'  => ["id(:$id) is Not found"]
            ],404);

        }
        return $school;
    }

    public function createPost(Request $request,$id)
    {
        $user = $this->auth->user();

        if($school = $user->schools()->wherePivot('role', '=', 'admin')->where('schools.id',$id)->first()){

            $post_dto = $request->only([
                'title',
                'content'
            ]);
            
            $validator = Validator::make($post_dto, [
                'title'   => 'string|max:191',
                'content' => 'required|string|max:1000',
            ]);
    
            if ($validator->fails()) {
                
                $errors = $validator->errors()->all();
                
                return response([
                    'message' => "validation failed",
                    'errors'  => $errors
                ],400);
            }
    

            $post_dto['user_id']   = $user->id; 
            $post_dto['school_id'] = $school->id;
            
            try{
                $post = Post::create($post_dto);
            }catch(\Exception $e){
                return response([
                    'message' => "validation failed",
                    'errors'  => [$e->getMessage()]
                ],400);
            }
            return $post;

        } else {
            return response([
                'message' => "Not Found",
                'errors'  => ["id(:$id) is Not found"]
            ],404);
        }
        return $school;
    }
}
