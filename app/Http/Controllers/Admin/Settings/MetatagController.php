<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\MetatagModel;
use Illuminate\Http\Request;

class MetatagController extends Controller
{

    function index()
    {
        $title = "Meta Tag Settings";

        $detail = MetatagModel::where('id', 1)->first();

        return view('/pages/admin/settings/metatag/index', [
            'title' => $title,
            'detail' => $detail
        ]);
    }

    function save(Request $request)
    {
        $data = $request->all();

        $existing = MetatagModel::all();

        if (count($existing) > 0) {

            unset($data['_token']);

            MetatagModel::where('id', 1)->update($data);

        } else {
            $data['id'] = 1;
            MetatagModel::create($data);
        }

        session()->flash('success', 'Successfully saved the meta tag!');

        return redirect('/admin/setting/metatag');
    }
}
