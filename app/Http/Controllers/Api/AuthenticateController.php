<?php
namespace App\Http\Controllers\Api;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthenticateController extends Controller
{
    /**
     * 
     * @OA\Post(
     *     path="/api/auth",
     *     tags={"인증"},
     *     summary="jwt 인증",
     *     description="<b>email</b>과 <b>password</b>를 통해서 jwt를 얻는다",
     *     @OA\RequestBody(
     *         description="email/password를 넣는다",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"email","password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "garam-park@naver.com", "password": "password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="authorized",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="jwt",
     *                 type="string"
     *             ),
     *             example={"jwt": "token sting"}
     *         )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *             example={"error": "invalid_credentials"},
     *             @OA\Property(
     *                 property="error",
     *                 type="string"
     *             ),
     *         )
     *     )
     * )
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }
}