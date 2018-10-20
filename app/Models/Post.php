<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @package App\Models
 *
 * @author  Garam Park <garam-park@naver.com>
 *
 * @OA\Schema(
 *     title="Post model",
 *     description="Post model",
 * )
 */
class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'school_id',
    ];

    protected $with = [
        'author',
        'school'
    ];

    protected $hidden = ['school_id','user_id'];
    
    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class,'school_id');
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
     *     description="Title",
     *     title="Title",
     *     property="title"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     description="Content",
     *     title="Content",
     *     property="content"
     * )
     *
     * @var string
     */

     /**
     * @OA\Property(
     *     description="Created At",
     *     title="Created At",
     *     property="created_at",
     *     example="2018-08-16 04:18:01"
     * )
     *
     * @var string
     */

     /**
     * @OA\Property(
     *     description="Updated At",
     *     title="Updated At",
     *     property="updated_at",
     *     example="2018-08-16 04:18:01"
     * )
     *
     * @var string
     */

     

     /**
     * @OA\Property(
     *     description="Author",
     *     title="Author",
     *     property="author",
     *     ref="#/components/schemas/User"
     * )
     */

     /**
     * @OA\Property(
     *     description="School",
     *     title="School",
     *     property="school",
     *     ref="#/components/schemas/School"
     * )
     */
}
