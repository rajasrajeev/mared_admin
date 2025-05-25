<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoVideo extends Model
{
    protected $table = 'demo_videos';

    protected $fillable = [
        'subject_id',
        'title',
        'thumbnail',
        'duration',
        'instructor',
        'video_url',
    ];

    // If you have a Subject model, you can define the relationship
    public function subject()
    {
        return $this->belongsTo(Course::class);
    }
}
