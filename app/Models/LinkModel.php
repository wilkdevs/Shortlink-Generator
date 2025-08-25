<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LinkModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "links";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        "long_url",
        "short_url",
        "count_click",
        "status"
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the visitors for the link.
     */
    public function visitors()
    {
        return $this->hasMany(VisitorModel::class, 'link_id', 'id');
    }
}
