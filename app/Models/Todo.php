<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'title',
        'priority',
        'status',
        'category',
        'start_date',
        'end_date',
    ];
    use HasFactory;
}
