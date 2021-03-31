<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $attributes = [
        'no_clicked' => 0,
    ];

    protected $fillable = [
        'short_url',
        'url',
    ];
}
