<?php

namespace App\Models;

use App\Models\EntityModel as EntityModel;

class Expense extends EntityModel
{
    protected $connection = 'mongodb';
    protected $collection = 'expenses';
}
