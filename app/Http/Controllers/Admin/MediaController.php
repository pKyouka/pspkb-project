<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService
    ) {}

    public function index(Request $request): View
    {
        $media = $this->mediaService->getAllPaginated(20);
        return view('admin.media.index', compact('media'));
    }

    public function library(): JsonResponse
    {
        $media = Media::query()
            ->where('mime_type', 'like', 'image/%')
            ->latest()
            ->limit(60)
            ->get()
            ->map(fn (Media $media) => [
                'id' => $media->id,
                'url' => Storage::url($media->path),
                'path' => $media->path,
                'filename' => $media->filename,
                'mime_type' => $media->mime_type,
                'formatted_size' => $media->formatted_size,
            ]);

        return response()->json(['data' => $media]);
    }

    public function upload(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,webp,svg,pdf',
        ]);

        $media = $this->mediaService->upload($request->file('file'), auth()->id());

        if ($request->expectsJson()) {
            return response()->json([
                'id' => $media->id,
                'url' => Storage::url($media->path),
                'path' => $media->path,
                'filename' => $media->filename,
                'mime_type' => $media->mime_type,
            ]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', 'File berhasil diupload.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        $this->mediaService->delete($media->id);
        return redirect()->route('admin.media.index')
            ->with('success', 'File berhasil dihapus.');
    }
}
