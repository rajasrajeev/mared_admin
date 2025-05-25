<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTypePrice extends Model
{
    use HasFactory;

    protected $table = 'course_type_price';

    protected $fillable = ['course_type', 'price', 'class_id'];
}
