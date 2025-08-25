<?php

namespace App\View\Components\Template;

use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;
use App\Models\AccessRightsModel;
use App\Models\AdminModel;
use App\Models\SettingModel;

class AdminSidebarComponent extends Component
{
    public $current_route = "/";

    public $isSuperAdmin = false;

    public $accessRights = null;

    public $settings = [];

    public function __construct()
    {
        $this->current_route = Request::path();

        $setting_list = SettingModel::all();

        foreach ($setting_list as $item) {
            if (($item['type'] == "image" || $item['type'] == "audio") && $item['value'] != NULL) {
                $item['value'] = asset($item['value']);
            }

            $this->settings[$item->key] = $item->value;
        }
    }

    public function isDashboardPage()
    {
        return ($this->current_route == "admin") ? "active" : "";
    }

    public function isCodeVocherList()
    {
        return ($this->current_route == "admin/code-voucher") ? "active" : "";
    }

    public function isCodeVocherForm()
    {
        return ($this->current_route == "admin/code-voucher/new") ? "active" : "";
    }

    public function isRouteParent($route)
    {
        return (str_contains($this->current_route, $route)) ? "active" : "";
    }

    public function isRouteActive($routes)
    {
        foreach ($routes as $route) {
            if (str_contains($this->current_route, $route)) {
                return "active";
            }
        }
    }

    public function isChildRouteShow($route)
    {
        return $this->isRouteParent($route) ? "show" : "";
    }

    public function requestAccessRights()
    {
        $user_id = auth()->user()->id;

        $checkAdmin = AdminModel::where('user_id', $user_id)->first();

        $this->accessRights = AccessRightsModel::where('admin_id', $checkAdmin['id'])->first();
    }

    public function getAccessRights($route)
    {
        return $this->accessRights[$route] == 1;
    }

    public function render()
    {

        $this->requestAccessRights();

        return view('components.template.admin-sidebar-component');
    }
}
