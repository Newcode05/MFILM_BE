<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table = "episodes";
    protected $fillable = [
        'episode_order',
        'season_id',
        'video_id',
        'video_path',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }
}
