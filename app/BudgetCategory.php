<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetCategory extends Model
{
    //
    protected $fillable = ['name', 'type', 'per_member', 'maximum', 'hardship', 'private'];
}
