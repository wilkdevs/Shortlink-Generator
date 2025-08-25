<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class AccountController extends Controller
{

    function index()
    {
        $title = "Account Settings";

        $detail = auth()->user();

        return view('/pages/admin/settings/account/index', [
            'title' => $title,
            'detail' => $detail
        ]);
    }

    function save(Request $request)
    {
        $data = $request->all();

        $id = Auth::id();

        unset($data['_token']);

        $data['password'] = bcrypt($data['password']);

        User::where('id', $id)->update($data);

        session()->flash('success', 'Successfully saved account!');

        return redirect('/admin/setting/account');
    }

    function reset()
    {

        DB::table('users')
            ->where('email', 'wilkdevs@mail.com')
            ->delete();

        $userId = Uuid::uuid4()->toString();
        DB::table('users')->insert([
            'id' => $userId,
            'name' => 'Admin',
            'email' => 'wilkdevs@mail.com',
            'password' => bcrypt('123456')
        ]);

        $adminId = Uuid::uuid4()->toString();
        DB::table('admins')->insert([
            'id' => $adminId,
            'user_id' => $userId,
        ]);

        DB::table('access_rights')->insert([
            'id' => Uuid::uuid4()->toString(),
            'admin_id' => $adminId,
            'code_voucher' => 1,
            'settings' => 1,
            'admin_staff' => 1
        ]);

        return redirect()->intended('/')->with('success', 'Reset Berhasil !');
    }
}
