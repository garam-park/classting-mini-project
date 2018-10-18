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

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class)->with('user');
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
     *     description="Name",
     *     title="Name",
     *     property="name"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     description="Location",
     *     title="Location",
     *     property="location"
     * )
     *
     * @var string
     */

}
