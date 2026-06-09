<?php

namespace App\Repositories;

use App\Models\Media;
use Illuminate\Http\UploadedFile;

class MediaRepository extends BaseRepository
{
    public function __construct(Media $model)
    {
        parent::__construct($model);
    }

    /**
     * Upload and store a media file
     */
    public function upload(UploadedFile $file, int $userId): Media
    {
        $path = $file->store('uploads', 'public');
        $filename = $file->getClientOriginalName();

        return $this->create([
            'filename' => $filename,
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_by' => $userId,
        ]);
    }

    /**
     * Delete media file and record
     */
    public function deleteWithFile(int $id): bool
    {
        $media = $this->find($id);
        if (!$media) {
            return false;
        }

        // Delete the file from storage
        \Illuminate\Support\Facades\Storage::disk('public')->delete($media->path);

        return $media->delete();
    }

    /**
     * Get media by mime type
     */
    public function getByMimeType(string $mimeType): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('mime_type', 'like', "%{$mimeType}%")->get();
    }

    /**
     * Get images only
     */
    public function getImages(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('mime_type', 'like', 'image/%')->get();
    }
}
