<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\PageService;
use App\Services\PostService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function __construct(
        protected PostService $postService,
        protected PageService $pageService,
        protected SettingService $settingService
    ) {}

    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $results = collect();
        $settings = $this->settingService->getAll();

        if ($query) {
            $posts = $this->postService->search($query);
            $pages = $this->pageService->search($query);

            $results = $posts->map(function ($post) {
                return [
                    'type' => 'post',
                    'title' => $post->title,
                    'url' => route('posts.show', $post->slug),
                    'excerpt' => $post->excerpt,
                ];
            })->merge($pages->map(function ($page) {
                return [
                    'type' => 'page',
                    'title' => $page->title,
                    'url' => route('pages.show', $page->slug),
                    'excerpt' => strip_tags(Str::limit($page->content, 150)),
                ];
            }));
        }

        return view('frontend.search', compact('query', 'results', 'settings'));
    }
}
