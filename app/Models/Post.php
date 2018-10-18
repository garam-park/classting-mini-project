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
        'author'
    ];

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * @OA\Property(
     *     format="int64",
     *     description="ID",
     *     title="ID",
     *     property="id"
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
}
