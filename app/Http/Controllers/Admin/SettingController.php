<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function index(): View
    {
        $settings = $this->settingService->getAll();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(SettingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $settings = $this->settingService->getAll();

        if ($request->boolean('remove_logo')) {
            if (!empty($settings['logo'])) {
                Storage::disk('public')->delete($settings['logo']);
            }

            $data['logo'] = '';
        } elseif (isset($data['logo']) && $data['logo'] instanceof \Illuminate\Http\UploadedFile) {
            if (!empty($settings['logo'])) {
                Storage::disk('public')->delete($settings['logo']);
            }

            $data['logo'] = $data['logo']->store('settings', 'public');
        }

        if ($request->boolean('remove_favicon')) {
            if (!empty($settings['favicon'])) {
                Storage::disk('public')->delete($settings['favicon']);
            }

            $data['favicon'] = '';
        } elseif (isset($data['favicon']) && $data['favicon'] instanceof \Illuminate\Http\UploadedFile) {
            if (!empty($settings['favicon'])) {
                Storage::disk('public')->delete($settings['favicon']);
            }

            $data['favicon'] = $data['favicon']->store('settings', 'public');
        }

        unset($data['remove_logo'], $data['remove_favicon']);

        $this->settingService->bulkUpdate($data);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
