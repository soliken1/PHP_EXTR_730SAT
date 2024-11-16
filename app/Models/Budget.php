<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Budget extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'budget';
    protected $fillable = [
        'userId',
        'categoryTitle',
        'budget',
    ];
}
