<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    // дозволяємо додавати дані у ці поля
    protected $fillable = ['name', 'description', 'price'];
}