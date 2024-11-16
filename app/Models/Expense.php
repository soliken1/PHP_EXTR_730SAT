<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Expense extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'expenses';
    protected $fillable = [
        'userId',
        'categoryId',
        'expenseName',
        'expenseDescription',
        'categoryTitle',
        'amount',
        'date',
    ];
}
