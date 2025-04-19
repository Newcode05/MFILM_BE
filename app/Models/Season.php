<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $table = 'seasons';
    protected $fillable = [
        'season_name',
        'season_order',
        'video_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function Video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }
    public function episode()
    {
        return $this->hasMany(Episode::class, 'season_id');
    }
}
