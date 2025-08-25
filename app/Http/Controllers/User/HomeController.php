<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MetatagModel;
use App\Models\SettingModel;
use App\Models\LinkModel;
use App\Models\VisitorModel;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class HomeController extends Controller
{
    /**
     * Handles the home page display.
     */
    public function index()
    {
        $title = "Selamat Datang di " . env('APP_NAME');

        $metatag = MetatagModel::where('id', 1)->first();
        $setting_list = SettingModel::all();

        foreach ($setting_list as $item) {
            if (($item['type'] == "image" || $item['type'] == "audio") && $item['value'] != NULL) {
                $item['value'] = asset($item['value']);
            }
            $settings[$item->key] = $item->value;
            $settings[$item->key . "Default"] = $item->default_value;
        }

        return view('/pages/user/index', [
            'title' => $title,
            'metatag' => $metatag,
            'settings' => $settings
        ]);
    }
}
