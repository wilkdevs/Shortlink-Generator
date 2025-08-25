<?php

namespace App\Http\Controllers\Admin\Gift;

use App\Http\Controllers\Controller;
use App\Models\GiftModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GiftController extends Controller
{

    public function index()
    {
        $title = "Daftar Hadiah";

        $categoryId = request('category_id');

        $query = GiftModel::with('category')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $categories = CategoryModel::whereNull('deleted_at')->orderBy('created_at')->get();

        $setting_list = SettingModel::all();

        foreach ($setting_list as $item) {
            if (($item['type'] == "image" || $item['type'] == "audio") && $item['value'] != NULL) {
                $item['value'] = asset($item['value']);
            }
            $settings[$item->key] = $item->value;
            $settings[$item->key . "Default"] = $item->default_value;
        }

        return view('/pages/admin/gift/index', [
            'list' => $query->paginate(10)->withQueryString(),
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'title' => $title,
            'settings' => $settings
        ]);
    }

    function new()
    {
        $title = "Tambah Hadiah";

        $defaultFontFamily = '"Lucida Console", "Courier New", monospace';

        $categories = CategoryModel::where('deleted_at', NULL)->orderBy('created_at')->get();

        return view('/pages/admin/gift/form', [
            'title' => $title,
            'defaultFontFamily' => $defaultFontFamily,
            'categories' => $categories,
        ]);
    }

    function edit($id)
    {
        $title = "Ubah Hadiah";

        $detail = GiftModel::where('id', $id)->first();

        $categories = CategoryModel::where('deleted_at', NULL)->orderBy('created_at')->get();

        return view('/pages/admin/gift/form', [
            'categories' => $categories,
            'title' => $title,
            'detail' => $detail,
        ]);
    }

    function create(Request $request)
    {
        $request->validate([
            'category_id' => 'required|uuid|exists:categories,id',
            'name' => 'required|string|max:255|unique:gifts,name,NULL,id,deleted_at,NULL',
            'image' => 'nullable|image|max:2048',
            'probability' => 'nullable|integer',
        ]);

        $data = $request->only([
            'category_id',
            'name',
            'probability',
        ]);

        $data['id'] = Uuid::uuid4()->toString();
        $data['active'] = 1;

        if ($request->hasFile('image')) {
            $urlFile = $request->file('image')->store('files');
            $data['image'] = $urlFile;
        }

        GiftModel::create($data);

        session()->flash('success', 'Berhasil menambahkan hadiah!');
        return redirect('/admin/gift/list');
    }

    function update(Request $request)
    {
        $request->validate([
            'id' => 'required|uuid|exists:gifts,id',
            'category_id' => 'required|uuid|exists:categories,id',
            'name' => 'required|string|max:255|unique:gifts,name,' . $request->id . ',id,deleted_at,NULL',
            'image' => 'nullable|image|max:2048',
            'probability' => 'nullable|integer',
        ]);

        $gift = GiftModel::findOrFail($request->id);

        $data = $request->only([
            'category_id',
            'name',
            'probability',
        ]);

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gift->image) {
                Storage::delete($gift->image);
            }

            $urlFile = $request->file('image')->store('files');
            $data['image'] = $urlFile;
        }

        $gift->update($data);

        session()->flash('success', 'Berhasil mengubah data gift!');
        return redirect('/admin/gift/list');
    }

    function changeStatus(Request $request) {

        $data = $request->all();

        $name = GiftModel::where('id', $data['id'])->first();

        $update = [];

        if ($name->active == 1) {
            $update['active'] = 0;
        } else {
            $update['active'] = 1;
        }

        GiftModel::where('id', $data['id'])->update($update);
    }

    function delete($id) {

        GiftModel::where('id', $id)->update([
            'deleted_at' => date("Y-m-d H:i:s")
        ]);

        return redirect('/admin/gift/list');
    }

    function deleteAll() {
        GiftModel::whereNull('deleted_at')->update([
            'deleted_at' => now()
        ]);

        return redirect('/admin/gift/list');
    }

    function duplicate($id) {

        $name = GiftModel::find($id);

        $newName = $name->replicate();

        $newName->id = Uuid::uuid4()->toString();

        $newName->save();

        session()->flash('success', 'Berhasil menduplikat gift!');

        return redirect('/admin/gift/list');
    }
}
