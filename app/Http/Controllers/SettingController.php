<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;

class SettingController extends Controller
{
    public function general(): Response
    {
        $setting = Setting::where('key', 'like', 'g_%')->orderBy('key', 'asc')->get();

        $setting = $setting->map(function ($s) {
            if ($s->type === 'image') {
                $s->url = asset($s->value);
            }

            return $s;
        });

        return inertia('Setting/General', [
            'setting' => $setting,
        ]);
    }

    public function updateGeneral(Request $request): RedirectResponse
    {
        $request->validate([
            'site_name' => 'required|string',
            'site_about' => 'required|string',
            'site_welcome' => 'required|string',
            'site_subwelcome' => 'required|string',
            'site_meta_desc' => 'required|string',
            'site_meta_keyword' => 'required|string',
            'whatsapp_float_enable' => 'required|in:0,1',
            'whatsapp_url' => 'required|url',
            'whatsapp_text' => 'required|string',
            'logo' => 'nullable|image',
            'slide1' => 'nullable|image',
            'slide2' => 'nullable|image',
            'slide3' => 'nullable|image',
        ]);

        DB::beginTransaction();
        Setting::where('key', 'G_SITE_NAME')->update(['value' => $request->site_name]);
        Setting::where('key', 'G_SITE_ABOUT')->update(['value' => $request->site_about]);
        Setting::where('key', 'G_SITE_WELCOME')->update(['value' => $request->site_welcome]);
        Setting::where('key', 'G_SITE_SUBWELCOME')->update(['value' => $request->site_subwelcome]);
        Setting::where('key', 'G_SITE_META_DESC')->update(['value' => $request->site_meta_desc]);
        Setting::where('key', 'G_SITE_META_KEYWORD')->update(['value' => $request->site_meta_keyword]);
        Setting::where('key', 'G_WHATSAPP_FLOAT_ENABLE')->update(['value' => $request->whatsapp_float_enable]);
        Setting::where('key', 'G_WHATSAPP_URL')->update(['value' => $request->whatsapp_url]);
        Setting::where('key', 'G_WHATSAPP_TEXT')->update(['value' => $request->whatsapp_text]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $file->store('uploads', 'public');
            Setting::where('key', 'G_SITE_LOGO')->update(['value' => $file->hashName('uploads')]);
        }

        if ($request->hasFile('slide1')) {
            $file = $request->file('slide1');
            $file->store('uploads', 'public');
            Setting::where('key', 'G_LANDING_SLIDE_1')->update(['value' => $file->hashName('uploads')]);
        }
        if ($request->hasFile('slide2')) {
            $file = $request->file('slide2');
            $file->store('uploads', 'public');
            Setting::where('key', 'G_LANDING_SLIDE_2')->update(['value' => $file->hashName('uploads')]);
        }
        if ($request->hasFile('slide3')) {
            $file = $request->file('slide3');
            $file->store('uploads', 'public');
            Setting::where('key', 'G_LANDING_SLIDE_3')->update(['value' => $file->hashName('uploads')]);
        }

        DB::commit();

        return redirect()->route('setting.general')
            ->with('message', ['type' => 'success', 'message' => 'Setting has beed saved']);
    }

    public function payment(): Response
    {
        $setting = Setting::where('key', 'like', 'midtrans%')->orderBy('key', 'asc')->get();

        $setting = $setting->map(function ($item) {
            return [
                $item->key => $item->value,
            ];
        });

        return inertia('Setting/Payment', [
            'setting' => (object) $setting,
            'notification_url' => route('api.notification.payment'),
        ]);
    }

    public function updatePayment(Request $request): RedirectResponse
    {
        $request->validate([
            'midtrans_client_key' => 'required|string|max:255',
            'midtrans_server_key' => 'required|string|max:255',
            'midtrans_merchant_id' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        foreach ($request->input() as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }
        DB::commit();

        return redirect()->route('setting.payment')
            ->with('message', ['type' => 'success', 'message' => 'Setting has beed saved']);
    }

    public function ekajaya()
    {
        $setting = Setting::where('key', 'like', 'ekajaya_%')->orderBy('key', 'asc')->get();

        $setting = $setting->map(function ($item) {
            return [
                $item->key => $item->value,
            ];
        });

        return inertia('Setting/Ekajaya', [
            'setting' => (object) $setting,
        ]);
    }

    public function updateEkajaya(Request $request)
    {
        $request->validate([
            'ekajaya_host' => 'required|url|string|max:255',
            'ekajaya_apikey' => 'required|string|max:255|unique:customers,token',
        ], [
            'ekajaya_apikey.unique' => 'cant use key as same as local system',
        ]);

        DB::beginTransaction();
        foreach ($request->input() as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }
        DB::commit();

        return redirect()->route('setting.ekajaya')
            ->with('message', ['type' => 'success', 'message' => 'Setting has beed saved']);
    }
}
