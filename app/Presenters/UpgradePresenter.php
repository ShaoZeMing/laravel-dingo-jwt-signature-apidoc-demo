<?php

namespace App\Presenters;

use App\Transformers\UpgradeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UpgradePresenter.
 *
 * @package namespace App\Presenters;
 */
class UpgradePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UpgradeTransformer();
    }
}
