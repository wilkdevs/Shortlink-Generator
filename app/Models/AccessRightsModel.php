<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessRightsModel extends Model
{
    use HasFactory;

    protected $table = "access_rights";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'admin_id',
        'links',
        'visitors',
        'settings',
        'admin_staff'
    ];
}
