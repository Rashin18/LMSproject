<?php
// app/Http/Controllers/SuperAdmin/SettingController.php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('superadmin.settings.index', compact('settings'));
    }

    public function update(Request $request)
{
    $request->validate([
        'site_name' => 'nullable|string|max:255',
        'maintenance_mode' => 'nullable|boolean',
    ]);

    foreach ($request->only(['site_name', 'maintenance_mode']) as $key => $value) {
        Setting::updateOrCreate(['key' => $key], ['value' => $key === 'maintenance_mode' ? (int)$value : $value]);
    }

    // Toggle Laravel's built-in maintenance
    if ($request->maintenance_mode) {
        \Artisan::call('down');
    } else {
        \Artisan::call('up');
    }

    return back()->with('success', 'Settings updated successfully!');
}

public function toggleMaintenance(Request $request)
{
    $setting = Setting::firstOrCreate(
        ['key' => 'maintenance_mode'],
        ['value' => '0']
    );
    
    $setting->value = $setting->value == '1' ? '0' : '1';
    $setting->save();
    
    return back()->with('success', 'Maintenance mode ' . ($setting->value ? 'enabled' : 'disabled'));
}
}
