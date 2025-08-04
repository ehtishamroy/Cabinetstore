<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $shippingSettings = Setting::getByGroup('shipping');
        $generalSettings = Setting::getByGroup('general');
        $paymentSettings = Setting::getByGroup('payment');
        
        return view('admin.settings', compact('shippingSettings', 'generalSettings', 'paymentSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'required',
            'settings.*.type' => 'required|string',
            'settings.*.group' => 'required|string',
        ]);

        foreach ($request->settings as $setting) {
            Setting::setValue(
                $setting['key'],
                $setting['value'],
                $setting['type'],
                $setting['group'],
                $setting['label'] ?? null,
                $setting['description'] ?? null
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function getShippingSettings()
    {
        $freeShippingThreshold = Setting::getValue('free_shipping_threshold', 2500);
        $defaultShippingRate = Setting::getValue('default_shipping_rate', 50);
        
        return response()->json([
            'free_shipping_threshold' => $freeShippingThreshold,
            'default_shipping_rate' => $defaultShippingRate
        ]);
    }
}
