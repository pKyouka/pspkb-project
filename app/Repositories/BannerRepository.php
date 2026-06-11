<?php

namespace App\Repositories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Collection;

class BannerRepository extends BaseRepository
{
    public function __construct(Banner $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active banners
     */
    public function getActive(): Collection
    {
        return $this->model->active()->oldest()->get();
    }
}
