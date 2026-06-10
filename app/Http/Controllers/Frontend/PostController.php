<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\SettingService;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService,
        protected CategoryService $categoryService,
        protected SettingService $settingService
    ) {}

    public function index()
    {
        $posts = $this->postService->getByCategorySlugs(['berita', 'artikel'], 9);
        $categories = $this->categoryService->getAll();
        $settings = $this->settingService->getAll();
        $pageTitle = __('frontend.posts.news_title');
        $pageLabel = __('frontend.posts.news_label');
        $pageDescription = __('frontend.posts.news_description');
        $emptyMessage = __('frontend.posts.news_empty');

        return view('frontend.posts.index', compact(
            'posts',
            'categories',
            'settings',
            'pageTitle',
            'pageLabel',
            'pageDescription',
            'emptyMessage'
        ));
    }

    public function activities()
    {
        $posts = $this->postService->getByCategorySlugs(['kegiatan'], 9);
        $categories = $this->categoryService->getAll();
        $settings = $this->settingService->getAll();
        $pageTitle = __('frontend.posts.activity_title');
        $pageLabel = __('frontend.posts.activity_label');
        $pageDescription = __('frontend.posts.activity_description');
        $emptyMessage = __('frontend.posts.activity_empty');

        return view('frontend.posts.index', compact(
            'posts',
            'categories',
            'settings',
            'pageTitle',
            'pageLabel',
            'pageDescription',
            'emptyMessage'
        ));
    }

    public function show(string $slug)
    {
        $post = $this->postService->findBySlug($slug);

        if (!$post) {
            abort(404);
        }

        $categories = $this->categoryService->getAll();
        $settings = $this->settingService->getAll();

        // Get related posts
        $relatedPosts = $this->postService->getFeatured(3);

        return view('frontend.posts.show', compact('post', 'categories', 'settings', 'relatedPosts'));
    }

    public function category(string $slug)
    {
        $category = $this->categoryService->findBySlug($slug);

        if (!$category) {
            abort(404);
        }

        $posts = $this->postService->getByCategory($category->id, 9);
        $categories = $this->categoryService->getAll();
        $settings = $this->settingService->getAll();

        return view('frontend.posts.category', compact('posts', 'category', 'categories', 'settings'));
    }
}
