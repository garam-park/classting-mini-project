<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Auth\AuthManager as Auth;

class PostController extends Controller
{
    protected $auth;
    
    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }
    
    public function index(Request $request)
    {
        $sort_by   = $request->sort_by;
        $direction = $request->direction?'ASC':'DESC';
        $school_id = $request->school_id;

        $user = $this->auth->user();

        $builder = $user->posts();

        if($sort_by){
            $builder->orderBy('created_at',$direction);
        }

        if($school_id){
            $builder->where('school_id',$school_id);
        }

        return $builder->simplePaginate();
    }
}
