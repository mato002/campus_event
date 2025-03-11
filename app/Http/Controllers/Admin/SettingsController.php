<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        // Check if settings are cached
        $settings = Cache::remember('settings', 3600, function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validation for new fields
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'timezone' => 'required|string',
            'date_format' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mail_driver' => 'nullable|string',
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
        ], [
            'site_name.required' => 'Please provide a site name.',
            'timezone.required' => 'Please select a timezone.',
            'date_format.required' => 'Please specify the date format.',
        ]);

        // Handle logo upload if exists
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            Setting::updateOrCreate(['key' => 'logo'], ['value' => $logoPath]);
        }

        // Update other settings
        foreach ($validated as $key => $value) {
            if ($key !== 'logo') {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        // Clear the cache after updating settings
        Cache::forget('settings');

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }

    // Backup functionality
    public function backup()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $backupPath = storage_path('app/backup/settings_backup.json');
        File::put($backupPath, json_encode($settings));

        return response()->download($backupPath);
    }

    // Restore functionality
    public function restore(Request $request)
    {
        $request->validate([
            'settings_file' => 'required|mimes:json|max:2048',
        ]);

        $filePath = $request->file('settings_file')->storeAs('temp', 'settings_restore.json');
        $settings = json_decode(Storage::get($filePath), true);

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings restored successfully!');
    }

    // Test email functionality
    public function testEmail(Request $request)
    {
        $validated = $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            Mail::raw('This is a test email.', function ($message) use ($validated) {
                $message->to($validated['test_email'])
                        ->subject('Test Email');
            });

            return redirect()->route('admin.settings.index')->with('success', 'Test email sent successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')->with('error', 'Failed to send test email.');
        }
    }
}
