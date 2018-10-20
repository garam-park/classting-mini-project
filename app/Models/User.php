<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @package App\Models
 *
 * @author  Garam Park <garam-park@naver.com>
 *
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 *     required={"name","email"}
 * )
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at','email_verified_at'
    ];

    public function schools()
    {
        return $this->belongsToMany(School::class)
        ->withPivot('role');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function subscribed_schools()
    {
        return $this->belongsToMany(School::class,'subscriptions','user_id','school_id');
    }

    /**
     * @OA\Property(
     *     description="Id",
     *     title="Id",
     *     property="id",
     *     example=1
     * )
     *
     * @var integer
     */

     /**
     * @OA\Property(
     *     description="Name",
     *     title="Name",
     *     property="name",
     *     example="garam"
     * )
     *
     * @var string
     */
    
    /**
     * @OA\Property(
     *     description="Email",
     *     title="Email",
     *     property="email",
     *     example="garam-park@naver.com"
     * )
     *
     * @var string
     */
   
}
