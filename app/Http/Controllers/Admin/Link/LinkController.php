<?php

namespace App\Http\Controllers\Admin\Link;

use App\Http\Controllers\Controller;
use App\Models\LinkModel;
use App\Models\VisitorModel;
use App\Models\SettingModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LinkController extends Controller
{

    function index()
    {
        $title = "Daftar Link";

        $list = LinkModel::where('deleted_at', NULL)
                         ->withCount('visitors')
                         ->orderBy('created_at', 'desc')
                         ->get();

        $setting_list = SettingModel::where('active', 1)->get();
        $setting = [];
        foreach ($setting_list as $item) {
            $setting[$item->key] = $item->value;
        }

        return view('/pages/admin/link/index', [
            'setting' => $setting,
            'title' => $title,
            'list' => $list,
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

        $name = LinkModel::where('id', $data['id'])->first();

        $update = [];

        if ($name->active == 1) {
            $update['active'] = 0;
        } else {
            $update['active'] = 1;
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

    /**
     * Redirects a short URL to its long URL and tracks the visit.
     *
     * @param string $short_url The unique short URL identifier.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function redirect(string $short_url)
    {
        // Find the link by its short_url field.
        $link = LinkModel::where('short_url', $short_url)->first();

        if (!$link) {
            return abort(404);
        }

        $ip = null;

        try {
            $ip_info_request = Http::timeout(3)->get('http://api.ipify.org?format=json');
            $ip = $ip_info_request->json()['ip'];
        } catch (\Exception $e) {
            \Log::warning("find IP failed: " . $e->getMessage());
        }

        // Check if this IP has already visited this link.
        $is_existing_visitor = VisitorModel::where('link_id', $link->id)
            ->where('ip', $ip)
            ->exists();

        // Only log a new visitor if it's not already recorded.
        if (!$is_existing_visitor) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode");

                if ($response->successful() && $response->json('status') === 'success') {
                    $country = $response->json('country') ?? 'Unknown';
                }
            } catch (\Exception $e) {
                \Log::warning("IP lookup failed for {$ip}: " . $e->getMessage());
            }

            VisitorModel::create([
                'id' => Uuid::uuid4()->toString(),
                'link_id' => $link->id,
                'ip' => $ip,
                'country' => $country,
                'payload' => json_encode([
                    'user_agent' => request()->userAgent(),
                    'referer'    => request()->headers->get('referer'),
                ]),
            ]);
        }

        return redirect($link->long_url);
    }
}
