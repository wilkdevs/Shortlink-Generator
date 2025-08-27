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

    public function create(Request $request)
    {
        $data = $request->only(['title', 'long_url']);
        $isCustom = $request->has('is_custom_link');

        if ($isCustom && $request->filled('custom_short_url')) {
            $customUrl = $request->input('custom_short_url');
            $data['short_url'] = $customUrl;
            $data['is_custom'] = true;

            $exists = LinkModel::where('short_url', $customUrl)
                ->whereNull('deleted_at')
                ->exists();

            if ($exists) {
                session()->flash('error', 'Custom short URL already exists.');
                return back();
            }
        } else {
            $linkLength = isset($request->short_url_length) && is_numeric($request->short_url_length)
                ? max(2, min(15, (int)$request->short_url_length))
                : 6;

            do {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = '';
                for ($i = 0; $i < $linkLength; $i++) {
                    $randomString .= $characters[rand(0, strlen($characters) - 1)];
                }
                $shortUrl = $randomString;

                $exists = LinkModel::where('short_url', $shortUrl)
                    ->whereNull('deleted_at')
                    ->exists();

            } while ($exists);

            $data['short_url'] = $shortUrl;
            $data['is_custom'] = false;
        }

        $data['id'] = Uuid::uuid4()->toString();
        $data['user_id'] = auth()->id();

        LinkModel::create($data);

        session()->flash('success', 'Berhasil menambahkan link baru!');

        return redirect('/admin/link/list');
    }

    public function update(Request $request)
    {
        // Find the existing link
        $link = LinkModel::findOrFail($request->id);

        // Prepare the data for update
        $data = [
            'title' => $request->title,
            'long_url' => $request->long_url,
        ];

        if ($request->has('is_custom_link') && $request->filled('custom_short_url')) {
            $customUrl = $request->custom_short_url;
            $data['short_url'] = $customUrl;
            $data['is_custom'] = true;

            $exists = LinkModel::where('short_url', $customUrl)
                ->whereNull('deleted_at')
                ->where('id', '!=', $request->id)
                ->exists();

            if ($exists) {
                session()->flash('error', 'Custom short URL already exists.');
                return back();
            }
        } else {
            // If the user unchecks the custom link box, the short URL and is_custom flag should not be updated.
            // This prevents accidental changes to the short URL, which would break existing links.
            // We only update these fields if the user explicitly provides a new custom URL.
            // To be safe, we'll keep the existing short URL and custom flag the same.
        }

        // Update the link in the database
        $link->update($data);

        // Flash a success message
        session()->flash('success', 'Successfully changed the link!');

        // Redirect to the links list
        return redirect('/admin/link/list');
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
