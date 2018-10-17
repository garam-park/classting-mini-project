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
     *     description="Name",
     *     title="Name",
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     description="Location",
     *     title="Location",
     * )
     *
     * @var string
     */
    public $location;

}
