<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function __construct(
        protected PostService $postService,
        protected CategoryService $categoryService,
        protected TagService $tagService
    ) {}

    public function index(): View
    {
        $activities = $this->postService->getAdminByCategorySlugs(['kegiatan'], 15);

        return view('admin.activities.index', compact('activities'));
    }

    public function create(): View
    {
        $activityCategory = $this->activityCategory();
        $categories = collect([$activityCategory]);
        $tags = $this->tagService->getAll();
        $post = null;
        $isActivity = true;

        return view('admin.activities.create', compact(
            'activityCategory',
            'categories',
            'tags',
            'post',
            'isActivity'
        ));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['category_id'] = $this->activityCategory()->id;
        $this->postService->create($data);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Aktivitas berhasil dibuat.');
    }

    public function edit(Post $activity): View
    {
        $this->ensureActivity($activity);
        $activity->load('tags');

        $activityCategory = $this->activityCategory();
        $categories = collect([$activityCategory]);
        $tags = $this->tagService->getAll();
        $post = $activity;
        $isActivity = true;

        return view('admin.activities.edit', compact(
            'activity',
            'activityCategory',
            'categories',
            'tags',
            'post',
            'isActivity'
        ));
    }

    public function update(PostRequest $request, Post $activity): RedirectResponse
    {
        $this->ensureActivity($activity);

        $data = $request->validated();
        $data['category_id'] = $this->activityCategory()->id;
        $this->postService->update($activity->id, $data);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Aktivitas berhasil diperbarui.');
    }

    public function destroy(Post $activity): RedirectResponse
    {
        $this->ensureActivity($activity);
        $this->postService->delete($activity->id);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Aktivitas berhasil dihapus.');
    }

    public function publish(Post $activity): RedirectResponse
    {
        $this->ensureActivity($activity);
        $this->postService->publish($activity->id);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Aktivitas berhasil dipublikasikan.');
    }

    public function unpublish(Post $activity): RedirectResponse
    {
        $this->ensureActivity($activity);
        $this->postService->unpublish($activity->id);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Aktivitas berhasil dijadikan draft.');
    }

    private function activityCategory()
    {
        $category = $this->categoryService->findBySlug('kegiatan');

        abort_unless($category, 500, 'Kategori Kegiatan belum tersedia.');

        return $category;
    }

    private function ensureActivity(Post $activity): void
    {
        $activity->loadMissing('category');
        abort_unless($activity->category?->slug === 'kegiatan', 404);
    }
}
