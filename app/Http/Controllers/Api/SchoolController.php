<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\School;
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
                'message' => "validation failed",
                'errors'  => [$e->getMessage()]
            ],400);
        }
        
    }
}
