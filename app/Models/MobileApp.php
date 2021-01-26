<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileApp extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
        'userToken',
        'id'
    ];
    public $timestamps = false;
}
