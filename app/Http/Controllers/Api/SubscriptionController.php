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

    /**
     * @OA\Get(
     *      path="/subscribed-schools",
     *      operationId="getSubscribedSchoolsList",
     *      summary="구독한 학교 페이지 리스트를 리턴",
     *      tags={"구독"},
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      @OA\Response(
     *         response=200,
     *         description="authorized",
     *         @OA\JsonContent( 
     *              @OA\Property(
     *                  property="current_page",
     *                  type="integer",
     *                  example=2
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Items(ref="#/components/schemas/School")
     *              ),
     *              @OA\Property(
     *                  property="first_page_url",
     *                  type="string",
     *                  example="https://api.classting.garam.xyz/posts?page=1"
     *              ),
     *              @OA\Property(
     *                  property="from",
     *                  type="integer",
     *                  example=1
     *              ),
     *              @OA\Property(
     *                  property="next_page_url",
     *                  type="string",
     *                  example="https://api.classting.garam.xyz/posts?page=4"
     *              ),
     *              @OA\Property(
     *                  property="path",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="per_page",
     *                  type="integer",
     *                  example=15
     *              ),
     *              @OA\Property(
     *                  property="prev_page_url",
     *                  example="https://api.classting.garam.xyz/posts?page=2"
     *              ),
     *              @OA\Property(
     *                  property="to",
     *                  type="integer",
     *                  example=5
     *              )
     *         )
     *     )
     * )
     */
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
