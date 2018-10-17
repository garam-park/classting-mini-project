<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
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
    ];
    /**
     * @OA\Property(
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     * @var integer
     */
    public $id;

    /**
     * @OA\Property(
     *     description="Title",
     *     title="Title",
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *     description="Content",
     *     title="Content",
     * )
     *
     * @var string
     */
    public $content;
}
