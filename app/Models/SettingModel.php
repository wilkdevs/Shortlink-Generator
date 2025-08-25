<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    use HasFactory;

    protected $table = "setting";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'key',
        'title',
        'type',
        'value',
        'default_value',
    ];
}
