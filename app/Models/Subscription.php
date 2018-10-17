<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
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
     *     property="school_id"
     * )
     *
     * @var integer
     */
    

    /**
     * @OA\Property(
     *     format="int64",
     *     description="user_id",
     *     title="user_id",
     *     property="user_id"
     * )
     *
     * @var integer
     */
    

}
