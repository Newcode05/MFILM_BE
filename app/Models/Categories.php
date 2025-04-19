<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = [
        'id',
        'type'
    ];
    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    public function Video()
    {
        return $this->belongsToMany(Video::class, 'categories_video');
    }
}
