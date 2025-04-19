<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Video extends Model
{
    protected $table = "video";
    protected $fillable = [
        'title',
        'duration',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function Categories()
    {
        return $this->belongsToMany(Categories::class, 'categories_video');
    }
    public function season()
    {
        return $this->hasMany(Season::class, 'video_id');
    }
    public function episode()
    {
        return $this->hasMany(Episode::class, 'video_id');
    }
    public function printVideo()
    {
        return $this->fillable;
    }
}
