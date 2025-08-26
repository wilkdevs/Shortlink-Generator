<?php

namespace App\Http\Controllers\Admin\Link;

use App\Http\Controllers\Controller;
use App\Models\LinkModel;
use App\Models\VisitorModel;
use App\Models\SettingModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class LinkController extends Controller
{

    function index()
    {
        $title = "Daftar Link";

        $query = LinkModel::whereNull('deleted_at')
            ->withCount(['visitors as visitors_count' => function ($query) {
                $query->select(DB::raw('count(distinct ip)'));
            }])
            ->withCount(['visitors as clicks_count'])
            ->orderBy('created_at', 'DESC');

        $setting_list = SettingModel::where('active', 1)->get();
        $setting = [];
        foreach ($setting_list as $item) {
            $setting[$item->key] = $item->value;
        }

        return view('/pages/admin/link/index', [
            'setting' => $setting,
            'title' => $title,
            'list' => $query->paginate(20)->withQueryString(),
        ]);
    }

    function new()
    {
        $title = "Tambah Link";

        return view('/pages/admin/link/form', [
            'title' => $title,
        ]);
    }

    function edit($id)
    {
        $title = "Ubah Link";

        $detail = LinkModel::where('id', $id)->first();

        return view('/pages/admin/link/form', [
            'title' => $title,
            'detail' => $detail,
        ]);
    }

    function create(Request $request) {
        $data = $request->only(['title', 'long_url', 'short_url_length']);

        $linkLength = isset($data['short_url_length']) && is_numeric($data['short_url_length'])
                    ? max(2, min(15, (int)$data['short_url_length']))
                    : 6;

        do {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $linkLength; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            $data['short_url'] = $randomString;

            $exists = LinkModel::where('short_url', $data['short_url'])
                ->whereNull('deleted_at')
                ->exists();

        } while ($exists);

        $data['id'] = Uuid::uuid4()->toString();
        $data['user_id'] = auth()->id();

        LinkModel::create($data);

        session()->flash('success', 'Berhasil menambahkan link baru!');

        return redirect('/admin/link/list');
    }

    function update(Request $request) {

        $data = $request->all();

        unset($data['_token']);

        LinkModel::where('id', $data['id'])->update($data);

        session()->flash('success', 'Successfully changed the link!');

        return redirect('/admin/5/list');
    }

    function changeStatus(Request $request) {

        $data = $request->all();

        $link = LinkModel::where('id', $data['id'])->first();

        $update = [];

        if ($link->status == 1) {
            $update['status'] = 0;
        } else {
            $update['status'] = 1;
        }

        LinkModel::where('id', $data['id'])->update($update);
    }

    function delete($id) {

        LinkModel::where('id', $id)->update([
            'deleted_at' => date("Y-m-d H:i:s")
        ]);

        return redirect('/admin/link/list');
    }

    function deleteAll() {
        LinkModel::whereNull('deleted_at')->update([
            'deleted_at' => now()
        ]);

        return redirect('/admin/link/list');
    }

    function duplicate($id) {

        $name = LinkModel::find($id);

        $newName = $name->replicate();

        $newName->id = Uuid::uuid4()->toString();

        $newName->save();

        session()->flash('success', 'Berhasil menduplikat link!');

        return redirect('/admin/link/list');
    }
}
