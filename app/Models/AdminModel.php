<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "admins";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
    ];

    protected $dates = ['deleted_at'];
}
