<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\SettingModel;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    function index()
    {
        $title = "Pengaturan Tampilan";
        $list = SettingModel::where('active', 1)->get();

        $setting_list = SettingModel::where('active', 1)->get();
        foreach ($setting_list as $item) {
            if ($item['type'] == "image" && $item['value'] != NULL) {
                $item['value'] = asset($item['value']);
            }
            $settings[$item->key] = $item->value;
        }

        foreach ($list as $item) {
            if (($item['type'] == "image" || $item['type'] == "audio") && $item['value'] != NULL) {
                $item['value'] = asset($item['value']);
            }
        }

        return view('/pages/admin/settings/view/index', [
            'title' => $title,
            'settings' => $settings,
            'list' => collect($list)
        ]);
    }

    function form($key)
    {
        if ($key == "new") {

            return view('/pages/admin/settings/view/form', [
                'title' => "Settings - Baru"
            ]);
        } else {
            $detail = SettingModel::where('key', $key)->first();

            $title = "Settings - " . $detail->title;

            if ($detail['type'] == 'size') {
                $detail->value = explode(", ", $detail->value);
            }

            return view('/pages/admin/settings/view/form', [
                'title' => $title,
                'detail' => $detail
            ]);
        }
    }

    function save(Request $request)
    {
        $data = $request->all();

        if (isset($data['id'])) {

            unset($data["_token"]);

            SettingModel::create($data);

            session()->flash('success', 'Successfully added settings!');

        } else {
            $file = $request->file('value');

            if ($file != null) {
                $urlFile = $file->store('files');
                $data['value'] = $urlFile;
            }

            unset($data["_token"]);

            $setting = SettingModel::where('key', $data['key'])->first();

            if ($setting['type'] == 'size') {
                $data['value'] = $data['value1'] . ", " . $data['value2'];
                unset($data["value1"]);
                unset($data["value2"]);
            }

            SettingModel::where('key', $data['key'])->update($data);

            session()->flash('success', 'Successfully changed settings!');
        }

        return redirect('/admin/setting/view');
    }

    function reset($key)
    {

        $data['value'] = NULL;

        SettingModel::where('key', $key)->update($data);

        session()->flash('success', 'Successfully reset settings');

        return redirect('/admin/setting/view');
    }
}
