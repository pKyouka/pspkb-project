<?php

namespace App\Repositories;

use App\Models\Banner;

class BannerRepository extends BaseRepository
{
    public function __construct(Banner $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active banners
     */
    public function getActive(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->active()->get();
    }
}
