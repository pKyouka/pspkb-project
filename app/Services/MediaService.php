<?php

namespace App\Services;

use App\Repositories\MediaRepository;
use Illuminate\Http\UploadedFile;

class MediaService
{
    public function __construct(
        protected MediaRepository $mediaRepository
    ) {}

    public function getAllPaginated(int $perPage = 20)
    {
        return $this->mediaRepository->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->mediaRepository->find($id);
    }

    public function upload(UploadedFile $file, int $userId)
    {
        // Validate file type
        $allowedMimeTypes = [
            'image/jpeg', 'image/png', 'image/webp', 'image/svg+xml',
            'application/pdf',
        ];

        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            throw new \InvalidArgumentException('File type not allowed.');
        }

        return $this->mediaRepository->upload($file, $userId);
    }

    public function delete(int $id)
    {
        return $this->mediaRepository->deleteWithFile($id);
    }

    public function getImages()
    {
        return $this->mediaRepository->getImages();
    }

    public function count()
    {
        return $this->mediaRepository->count();
    }
}
