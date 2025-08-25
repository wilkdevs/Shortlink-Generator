<?php

namespace App\Http\Controllers\Admin\Home;

use App\Http\Controllers\Controller;
use App\Models\GameModel;
use App\Models\SettingModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index()
    {
        return redirect('/admin/link/list');
    }

    function home()
    {

        return redirect('/admin/link/list');
    }
}
