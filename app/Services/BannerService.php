<?php

namespace App\Services;

use App\Repositories\BannerRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function createMany(array $data): Collection
    {
        $storedImages = [];

        try {
            return DB::transaction(function () use ($data, &$storedImages) {
                return collect($data['images'])->map(function (UploadedFile $image) use ($data, &$storedImages) {
                    $path = $image->store('banners', 'public');
                    $storedImages[] = $path;

                    return $this->bannerRepository->create([
                        'title' => Str::of($image->getClientOriginalName())->beforeLast('.')->replace(['-', '_'], ' ')->title(),
                        'image' => $path,
                        'is_active' => $data['is_active'] ?? false,
                    ]);
                });
            });
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($storedImages);

            throw $exception;
        }
    }

    public function update(int $id, array $data)
    {
        $banner = $this->bannerRepository->find($id);

        if (! $banner) {
            return false;
        }

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $oldImage = $banner->image;
            $data['image'] = $data['image']->store('banners', 'public');

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        return $this->bannerRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $banner = $this->bannerRepository->find($id);

        if (! $banner) {
            return false;
        }

        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        return $this->bannerRepository->delete($id);
    }

    public function count()
    {
        return $this->bannerRepository->count();
    }
}
