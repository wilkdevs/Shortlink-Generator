<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VisitorModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "visitors";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'link_id',
        "payload",
        "ip",
        "country"
    ];

    protected $dates = ['deleted_at'];
}
