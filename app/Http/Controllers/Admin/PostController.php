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

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService,
        protected CategoryService $categoryService,
        protected TagService $tagService
    ) {}

    public function index(): View
    {
        $posts = $this->postService->getAdminExcludingCategorySlugs(['kegiatan'], 15);
        $categories = $this->categoryService->getAll();
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = $this->categoryService->getAll()->reject(fn ($category) => $category->slug === 'kegiatan');
        $tags = $this->tagService->getAll();
        $post = null;
        return view('admin.posts.create', compact('categories', 'tags', 'post'));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $post = $this->postService->create($request->validated());
        return redirect()->route('admin.posts.index')
            ->with('success', 'Berita berhasil dibuat.');
    }

    public function show(Post $post): View
    {
        $post->load(['category', 'tags', 'creator']);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $this->ensureNotActivity($post);
        $post->load('tags');
        $categories = $this->categoryService->getAll()->reject(fn ($category) => $category->slug === 'kegiatan');
        $tags = $this->tagService->getAll();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $this->ensureNotActivity($post);
        $this->postService->update($post->id, $request->validated());
        return redirect()->route('admin.posts.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->ensureNotActivity($post);
        $this->postService->delete($post->id);
        return redirect()->route('admin.posts.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function publish(Post $post): RedirectResponse
    {
        $this->ensureNotActivity($post);
        $this->postService->publish($post->id);
        return redirect()->route('admin.posts.index')
            ->with('success', 'Berita berhasil dipublikasikan.');
    }

    public function unpublish(Post $post): RedirectResponse
    {
        $this->ensureNotActivity($post);
        $this->postService->unpublish($post->id);
        return redirect()->route('admin.posts.index')
            ->with('success', 'Berita berhasil di-unpublish.');
    }

    private function ensureNotActivity(Post $post): void
    {
        $post->loadMissing('category');
        abort_if($post->category?->slug === 'kegiatan', 404);
    }
}
