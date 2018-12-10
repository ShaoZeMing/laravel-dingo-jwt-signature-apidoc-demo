<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Client;

/**
 * Class ClientTransformer.
 *
 * @package namespace App\Transformers;
 */
class ClientTransformer extends TransformerAbstract
{
    /**
     * Transform the Client entity.
     *
     * @param \App\Entities\Client $model
     *
     * @return array
     */
    public function transform(Client $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
