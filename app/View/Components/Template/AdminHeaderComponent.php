<?php

namespace App\View\Components\Template;

use App\Models\MetatagModel;
use App\Models\SettingModel;
use Illuminate\View\Component;

class AdminHeaderComponent extends Component
{

    public $metatag;
    public $settings;

    public function __construct()
    {
        $this->metatag = MetatagModel::where('id', 1)->first();

        $setting_list = SettingModel::all();

        foreach ($setting_list as $item) {
            if ($item['type'] == "image" && $item['value'] != NULL) {
                $item['value'] = asset($item['value']);
            }
            $this->settings[$item->key] = $item->value;
            $this->settings[$item->key . "Default"] = $item->default_value;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.template.admin-header-component');
    }
}
