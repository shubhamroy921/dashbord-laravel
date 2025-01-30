<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use App\Traits\FileUploadTrait;
use Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Page;

class SettingController extends Controller
{
    use FileUploadTrait;

    public function index(): View
    {
        $pages = Page::where('status', 1)->pluck('title', 'id');
        return view('admin.setting.index', compact('pages'));
    }

    function UpdateGeneralSetting(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'site_name' => ['required', 'max:255'],
            'site_email' => ['nullable', 'max:255'],
            'site_phone' => ['nullable', 'max:255'],
            'site_default_currency' => ['required', 'max:4'],
            'site_currency_icon' => ['required', 'max:4'],
            'site_currency_icon_position' => ['required', 'max:255'],
        ]);

        Log::info('Validated Data:', $validatedData);

        foreach ($validatedData as $key => $value) {
            $setting = Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            Log::info('Setting saved:', ['key' => $key, 'value' => $value, 'id' => $setting->id]);
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function getSettings(): JsonResponse
    {
        // Fetch only the specific settings by keys
        $settings = Setting::whereIn('key', ['site_name', 'logo', 'footer_logo', 'favicon'])->get();

        // Format the response to include only the key-value pairs
        $filteredSettings = $settings->pluck('value', 'key');

        return response()->json([
            'success' => true,
            'data' => $filteredSettings,
        ]);
    }

    function UpdatePusherSetting(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'pusher_app_id' => ['required'],
            'pusher_key' => ['required'],
            'pusher_secret' => ['required'],
            'pusher_cluster' => ['required'],
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    function UpdateMailSetting(Request $request)
    {
        $validatedData = $request->validate([
            'mail_driver' => ['required'],
            'mail_host' => ['required'],
            'mail_port' => ['required'],
            'mail_username' => ['required'],
            'mail_password' => ['required'],
            'mail_encryption' => ['required'],
            'mail_from_address' => ['required'],
            'mail_receive_address' => ['required'],
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        Cache::forget('mail_settings');


        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function UpdateLogoSetting(Request $request): RedirectResponse
    {
        // Validate uploaded files and text fields
        $validatedData = $request->validate([
            'logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
            'footer_logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
            'favicon' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
            'breadcrumb' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
            'facebook_logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
            'twitter_logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
			'instagram_logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
            'youtube_logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
        ],
        [
            'logo.image' => 'The logo must be a valid image.',
            'footer_logo.image' => 'The footer logo must be a valid image.',
            'favicon.image' => 'The favicon must be a valid image.',
            'breadcrumb.image' => 'The breadcrumb image must be a valid image.',
            'max' => 'The image size cannot exceed 1MB.',
        ]);


        foreach ($validatedData as $key => $value) { // Loop through the validated data
            if ($request->hasFile($key)) { // Check if the request has a file for the key
                $imagePath = $this->uploadImage($request, $key);    // Upload the image
                Log::info("Uploading image for key {$key} with path: {$imagePath}");

                if (!empty($imagePath)) {
                    $oldPath = config('settings.' . $key);
                    if ($oldPath) {
                        $this->removeImage($oldPath);
                    }

                    $this->saveSetting($key, $imagePath);
                }
            } elseif ($key === 'facebook_link' || $key === 'twitter_link' || $key === 'instagram_link' || $key === 'youtube_link') {
                // Handle social media links
                $this->saveSetting($key, $value);
            } else {
                $this->saveSetting($key, $value);
            }
        }

        // Clear the cache for settings to reflect the updated values
        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        Cache::forget('mail_settings'); // You can add more cache keys if needed

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function UpdateFooterSetting(Request $request): RedirectResponse
    {
        // Validate uploaded files and text fields
        $validatedData = $request->validate([
            'facebook_logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
            'twitter_logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
			'instagram_logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],
            'youtube_logo' => ['nullable', 'image', 'max:1000', 'mimes:jpeg,png,jpg'],

            // Social Media Links Validation
            'facebook_link' => ['nullable', 'url'],
            'twitter_link' => ['nullable', 'url'],
			'instagram_link' => ['nullable', 'url'],
            'youtube_link' => ['nullable', 'url'],
            'footer_warning' => ['nullable', 'string'],
            'liquor_license' => ['nullable', 'string'],
            'footer_copyright' => ['nullable', 'string'],
            'designed_by' => ['nullable', 'string'],
        ], [
            'facebook_link.url' => 'Please enter a valid Facebook URL.',
            'twitter_link.url' => 'Please enter a valid Twitter URL.',
			'instagram_link.url' => 'Please enter a valid Instagram URL.',
            'youtube_link.url' => 'Please enter a valid YouTube URL.',
        ]);


        foreach ($validatedData as $key => $value) { // Loop through the validated data
            if ($request->hasFile($key)) { // Check if the request has a file for the key
                $imagePath = $this->uploadImage($request, $key);    // Upload the image
                Log::info("Uploading image for key {$key} with path: {$imagePath}");

                if (!empty($imagePath)) {
                    $oldPath = config('settings.' . $key);
                    if ($oldPath) {
                        $this->removeImage($oldPath);
                    }

                    $this->saveSetting($key, $imagePath);
                }
            } elseif ($key === 'facebook_link' || $key === 'twitter_link' || $key === 'instagram_link' || $key === 'youtube_link') {
                // Handle social media links
                $this->saveSetting($key, $value);
            } else {
                $this->saveSetting($key, $value);
            }
        }

        // Clear the cache for settings to reflect the updated values
        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    // Helper function to save the settings to the database
    protected function saveSetting($key, $value)
    {
        // Check if setting exists, otherwise create it
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // Log to verify saving
        Log::info("Setting saved/updated: {$key} => {$value}");
    }

    function UpdateAppearanceSetting(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'site_color' => ['required']
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class); // Get the settings service
        $settingsService->clearCachedSettings(); // Clear the cached settings
        Cache::forget('mail_settings');         // You can add more cache keys if needed

        return redirect()->back()->with('success', 'Settings updated successfully!'); // Redirect back with success message
    }



    function UpdateSeoSetting(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'seo_title' => ['required', 'max:255'],
            'seo_description' => ['nullable', 'max:600'],
            'seo_keywords' => ['nullable']
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        Cache::forget('mail_settings');

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    function UpdateEmailSetting(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'email_header' => ['required'], // Validate the email header
            'email_footer' => ['required'], // Validate the email footer
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key], // Find the setting by key
                ['value' => $value] // Save the value to the database
            );
        }

        $settingsService = app(SettingsService::class); // Get the settings service
        $settingsService->clearCachedSettings(); // Clear the cached settings
        // Cache::forget('mail_settings'); // You can add more cache keys if needed

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
