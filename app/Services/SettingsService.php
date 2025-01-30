<?php

namespace App\Services;

use App\Models\Setting;
use Cache;

class SettingsService {

    /**
     * Retrieve settings directly from the database without caching.
     */
    public function getSettings() {
        return Setting::pluck('value', 'key')->toArray(); // ['key' => 'value']
    }

    /**
     * Set global settings directly from the database without caching.
     */
    public function setGlobalSettings(): void {
        $settings = $this->getSettings();
        config()->set('settings', $settings);
    }

    /**
     * Clear cached settings.
     */
    public function clearCachedSettings(): void {
        Cache::forget('settings');
    }
}

