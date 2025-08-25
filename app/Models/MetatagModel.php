<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetatagModel extends Model
{
    use HasFactory;

    protected $table = "metatag";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'desc',
        'keyword'
    ];
}
