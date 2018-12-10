<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Student.
 *
 * @package namespace App\Entities;
 */
class BaseModel extends Model implements Transformable
{
    use TransformableTrait;
    protected $guarded = [];
    public $incrementing = true;



}
