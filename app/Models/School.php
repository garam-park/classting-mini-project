<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class School
 *
 * @package App\Models
 *
 * @author  Garam Park <garam-park@naver.com>
 *
 * @OA\Schema(
 *     title="School model",
 *     description="School model",
 * )
 */
class School extends Model
{
    protected $fillable = [
        'name',
        'location',
    ];

    protected $hidden = ['created_at','updated_at'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class)->with('user');
    }

    public function subscribing_users()
    {
        return $this->belongsToMany(User::class,'subscriptions','school_id','user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @OA\Property(
     *     format="int64",
     *     description="ID",
     *     title="ID",
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
     *     example="온누리 중학교"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     description="Location",
     *     title="Location",
     *     property="location",
     *     example="어디에나"
     * )
     *
     * @var string
     */

}
