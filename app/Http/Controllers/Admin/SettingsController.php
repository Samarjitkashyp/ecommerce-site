<?php
// app/Http/Controllers/Admin/SettingsController.php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends AdminController
{
    /**
     * Settings Dashboard
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * General Settings
     */
    public function general()
    {
        return view('admin.settings.general');
    }

    public function updateGeneral(Request $request)
    {
        try {
            $validated = $request->validate([
                'site_name' => 'required|string|max:255',
                'site_email' => 'required|email',
                'site_phone' => 'nullable|string|max:20',
                'site_address' => 'nullable|string',
            ]);

            Log::info('General settings updated by admin: ' . auth()->user()->id);
            
            return $this->sendSuccess('General settings updated successfully!', [], route('admin.settings.general'));
            
        } catch (\Exception $e) {
            Log::error('Settings update error: ' . $e->getMessage());
            return $this->sendError('Failed to update settings', [], 500);
        }
    }

    /**
     * SEO Settings
     */
    public function seo()
    {
        return view('admin.settings.seo');
    }

    public function updateSeo(Request $request)
    {
        try {
            $validated = $request->validate([
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string|max:255',
                'google_analytics_id' => 'nullable|string|max:50',
            ]);
            
            Log::info('SEO settings updated by admin: ' . auth()->user()->id);
            
            return $this->sendSuccess('SEO settings updated successfully!', [], route('admin.settings.seo'));
            
        } catch (\Exception $e) {
            Log::error('SEO settings update error: ' . $e->getMessage());
            return $this->sendError('Failed to update SEO settings', [], 500);
        }
    }
}