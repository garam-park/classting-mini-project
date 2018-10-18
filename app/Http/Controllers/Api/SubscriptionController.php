<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Auth\AuthManager as Auth;
use App\Models\School;

class SubscriptionController extends Controller
{
    protected $auth;
    
    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    public function index(Request $request)
    {
        $user = $this->auth->user();
        $user_id = $user->id;

        return School::whereHas('subscriptions',function($query) use ($user_id){
            $query->where('user_id',$user_id);
        })->select([
            "schools.id",
            "schools.name",
            "schools.location"
        ])->simplePaginate();
        
    }
}
