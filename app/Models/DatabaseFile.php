<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatabaseFile extends Model
{
    protected $fillable = [
        'filename',
        'mime_type',
        'data',
    ];
}
