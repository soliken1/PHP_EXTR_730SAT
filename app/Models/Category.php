<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'categories';
    protected $fillable = [
        'categoryTitle',
        'userId',
    ];
}
