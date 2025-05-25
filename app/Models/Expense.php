<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expense';
    protected $fillable = [
        'type',
        'amount',
        'date',
        'category',
        'description',
        'payment_status'
    ];

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category', 'id');
    }
}
