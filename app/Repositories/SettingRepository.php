<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends BaseRepository
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /**
     * Get setting value by key
     */
    public function getValue(string $key, mixed $default = null): mixed
    {
        return Setting::getValue($key, $default);
    }

    /**
     * Set setting value
     */
    public function setValue(string $key, mixed $value): Setting
    {
        return Setting::setValue($key, $value);
    }

    /**
     * Get all settings as array
     */
    public function getAll(): array
    {
        return Setting::getAll();
    }

    /**
     * Bulk update settings
     */
    public function bulkUpdate(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }
        Setting::clearCache();
    }
}
