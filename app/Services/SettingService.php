<?php

namespace App\Services;

use App\Repositories\SettingRepository;

class SettingService
{
    public function __construct(
        protected SettingRepository $settingRepository
    ) {}

    public function getValue(string $key, mixed $default = null): mixed
    {
        return $this->settingRepository->getValue($key, $default);
    }

    public function setValue(string $key, mixed $value)
    {
        return $this->settingRepository->setValue($key, $value);
    }

    public function getAll(): array
    {
        return $this->settingRepository->getAll();
    }

    public function bulkUpdate(array $settings): void
    {
        $this->settingRepository->bulkUpdate($settings);
    }

    /**
     * Get website general settings
     */
    public function getGeneral(): array
    {
        return [
            'website_name' => $this->getValue('website_name', ''),
            'website_description' => $this->getValue('website_description', ''),
            'logo' => $this->getValue('logo', ''),
            'favicon' => $this->getValue('favicon', ''),
        ];
    }

    /**
     * Get contact settings
     */
    public function getContact(): array
    {
        return [
            'contact_email' => $this->getValue('contact_email', ''),
            'contact_phone' => $this->getValue('contact_phone', ''),
            'contact_address' => $this->getValue('contact_address', ''),
        ];
    }

    /**
     * Get social media settings
     */
    public function getSocialMedia(): array
    {
        return [
            'social_facebook' => $this->getValue('social_facebook', ''),
            'social_instagram' => $this->getValue('social_instagram', ''),
            'social_linkedin' => $this->getValue('social_linkedin', ''),
            'social_youtube' => $this->getValue('social_youtube', ''),
            'social_tiktok' => $this->getValue('social_tiktok', ''),
        ];
    }

    /**
     * Get SEO default settings
     */
    public function getSeo(): array
    {
        return [
            'seo_meta_title' => $this->getValue('seo_meta_title', ''),
            'seo_meta_description' => $this->getValue('seo_meta_description', ''),
            'seo_keywords' => $this->getValue('seo_keywords', ''),
        ];
    }
}
