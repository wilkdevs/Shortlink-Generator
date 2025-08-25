<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
{

    // Remember to delete this, this is just for development things.
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
            'voucher' => 1,
            'gift' => 1,
            'settings' => 1,
            'admin_staff' => 1
        ]);

        return redirect()->intended('/')->with('success', 'Reset Berhasil !');
    }

}
