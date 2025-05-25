<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'birth_date',
        'street',
        'city',
        'state',
        'country',
        'pincode',
        'parent_email',
        'class_id',
        'course_type',
        'entrolled_by',
        'paid',
        'coupon_code',
        'amount'
    ];
}
