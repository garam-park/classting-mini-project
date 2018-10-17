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
 *     title="Subscription model",
 *     description="Subscription model",
 * )
 */
class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
    ];
    
    
    /**
     * @OA\Property(
     *     format="int64",
     *     description="school_id",
     *     title="school_id",
     * )
     *
     * @var integer
     */
    public $school_id;

    /**
     * @OA\Property(
     *     format="int64",
     *     description="user_id",
     *     title="user_id",
     * )
     *
     * @var integer
     */
    public $user_id;

}
