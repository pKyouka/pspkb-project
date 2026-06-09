<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactMessageRequest;
use App\Services\ContactMessageService;
use App\Services\SettingService;

class ContactController extends Controller
{
    public function __construct(
        protected ContactMessageService $contactMessageService,
        protected SettingService $settingService
    ) {}

    public function index()
    {
        $settings = $this->settingService->getAll();
        return view('frontend.contact', compact('settings'));
    }

    public function store(ContactMessageRequest $request)
    {
        $this->contactMessageService->create($request->validated());

        return redirect()->route('contact')
            ->with('success', 'Pesan berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}
