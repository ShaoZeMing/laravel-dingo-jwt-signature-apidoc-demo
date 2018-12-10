<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Feedback.
 *
 * @package namespace App\Entities;
 */
class Feedback extends  BaseModel
{
    protected $table = 'feedbacks';



}
