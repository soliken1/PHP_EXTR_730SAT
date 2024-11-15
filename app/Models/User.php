<?php

namespace App\Models;

use App\Models\EntityModel as EntityModel;

class User extends EntityModel
{
    protected $connection = 'mongodb';
    protected $table = 'users';

}


