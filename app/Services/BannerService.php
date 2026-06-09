<?php

namespace App\Services;

use App\Repositories\BannerRepository;
use Illuminate\Http\UploadedFile;

class BannerService
{
    public function __construct(
        protected BannerRepository $bannerRepository
    ) {}

    public function getAllPaginated(int $perPage = 10)
    {
        return $this->bannerRepository->paginate($perPage);
    }

    public function getActive()
    {
        return $this->bannerRepository->getActive();
    }

    public function find(int $id)
    {
        return $this->bannerRepository->find($id);
    }

    public function create(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('banners', 'public');
        }

        return $this->bannerRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('banners', 'public');
        }

        return $this->bannerRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->bannerRepository->delete($id);
    }

    public function count()
    {
        return $this->bannerRepository->count();
    }
}
