<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesVideo extends Model
{
    protected $table = "categories_video";
    protected $fillable = [
        'video_id',
        'categories_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
