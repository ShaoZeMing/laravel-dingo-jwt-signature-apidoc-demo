<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Upgrade;
use App\Validators\UpgradeValidator;

/**
 * Class UpgradeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UpgradeRepositoryEloquent extends BaseRepository implements UpgradeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Upgrade::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UpgradeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }



    public function getLatestByWhere($where,$appVer=0)
    {

        $fd = [
            'version',
            'download_url',
            'title',
            'desc',
            'client_type',
            'is_force',
            'created_at'
        ];
        $upgrades = $this->makeModel()
            ->newQuery()
            ->where($where)
            ->orderBy('id', 'desc')
            ->first($fd);
        if($upgrades){
            $appVerInt = intval(str_replace('.','',$upgrades['version']));
            $appVer = intval(str_replace('.','',$appVer));
            if($appVerInt > $appVer) {
                return $upgrades;
            }else{
                return null;
            }
        }
        return null;
    }

}
