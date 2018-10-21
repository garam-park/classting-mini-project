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
    /**
     * @OA\Get(
     *      path="/posts",
     *      operationId="getPostList",
     *      summary="포스트 리스트를 리턴",
     *      tags={"포스트"},
     *      description="포스트 리스트를 리턴한다<br/><br/>-최신순으로 정렬<br/>-구독중인 학교 별로 필터 가능",
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      @OA\Parameter(
     *          name="asc",
     *          description="정렬 방식,1:오름차수,0:내림차순",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="school_id",
     *          description="학교 페이지 id 필터, 넘겨진 값의 학교만 필터링 되어서 나온다",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="current_page",
     *                  type="integer",
     *                  example=2
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Items(ref="#/components/schemas/Post")
     *              ),
     *              @OA\Property(
     *                  property="first_page_url",
     *                  type="string",
     *                  example="http://127.0.0.1:8000/posts?page=1"
     *              ),
     *              @OA\Property(
     *                  property="from",
     *                  type="integer",
     *                  example=1
     *              ),
     *              @OA\Property(
     *                  property="next_page_url",
     *                  type="string",
     *                  example="http://127.0.0.1:8000/posts?page=4"
     *              ),
     *              @OA\Property(
     *                  property="path",
     *                  type="string",
     *                  example="http://127.0.0.1:8000/posts"
     *              ),
     *              @OA\Property(
     *                  property="per_page",
     *                  type="integer",
     *                  example=15
     *              ),
     *              @OA\Property(
     *                  property="prev_page_url",
     *                  example="http://127.0.0.1:8000/posts?page=2"
     *              ),
     *              @OA\Property(
     *                  property="to",
     *                  type="integer",
     *                  example=5
     *              )
     *         )
     *     )
     * )
     *
     * Returns list of posts
     */
    public function index(Request $request)
    {
        $sort_by   = $request->sort_by;
        $asc       = $request->asc?'ASC':'DESC';
        $school_id = $request->school_id;

        $user = $this->auth->user();

        $builder = $user->posts();

        if($sort_by){
            $builder->orderBy('created_at',$asc);
        }else{
            $builder->orderBy('created_at',$asc);
        }

        if($school_id){
            $builder->where('school_id',$school_id);
        }

        return $builder->simplePaginate();
    }
}
