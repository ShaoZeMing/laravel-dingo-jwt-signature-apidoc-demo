<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Upgrade;

/**
 * Class UpgradeTransformer.
 *
 * @package namespace App\Transformers;
 */
class UpgradeTransformer extends TransformerAbstract
{
    /**
     * Transform the Upgrade entity.
     *
     * @param \App\Entities\Upgrade $model
     *
     * @return array
     */
    public function transform(Upgrade $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
