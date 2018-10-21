<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="클래스팅 미니 프로젝트",
 *      description="클래스팅 과제 프로젝트 입니다",
 *      @OA\Contact(
 *          email="garam-park@naver.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

/**
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="L5 Swagger OpenApi Server"
 *  )
 *
 *  @OA\Server(
 *      url="https://api.classting.garam.xyz",
 *      description="Local Server"
 *  )
 */


/**
 * @OA\Tag(
 *     name="인증",
 *     description="인증관련 API",
 * )
 * @OA\Tag(
 *     name="포스트",
 *     description="포스트 API",
 * )
 * 
 * @OA\Tag(
 *     name="학교 페이지",
 *     description="학교 페이지 API",
 * )
 * @OA\Tag(
 *     name="구독",
 *     description="구독 API",
 * )
 */

/** 
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     in="header",
 *     securityScheme="bearerAuth"
 * )
 */

/** 
 * @OA\Schema(
 *     schema="ApiError",
 *     title="ApiError",
 *     title="Api Error response Model",
 *     description="Api Error response Model",
 *     @OA\Property(
 *          format="string",
 *          property="message",
 *          example="error"
 *     ),
 *     @OA\Property(
 *          format="array",
 *          property="error",
 *          @OA\Items(
 *              type="string",
 *              example="something wrong..."
 *          ),
 *     )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
