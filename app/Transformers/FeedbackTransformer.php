<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Feedback;

/**
 * Class FeedbackTransformer.
 *
 * @package namespace App\Transformers;
 */
class FeedbackTransformer extends TransformerAbstract
{
    /**
     * Transform the Feedback entity.
     *
     * @param \App\Entities\Feedback $model
     *
     * @return array
     */
    public function transform(Feedback $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
