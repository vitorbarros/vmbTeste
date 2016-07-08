<?php
namespace VmbTest\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use VmbTest\Models\Sintegra;
use VmbTest\Validators\SintegraValidator;

/**
 * Class SintegraRepositoryEloquent
 * @package namespace VmbTest\Repositories;
 */
class SintegraRepositoryEloquent extends BaseRepository implements SintegraRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sintegra::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
