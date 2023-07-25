<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{

    use HasApiTokens;
    use HasFactory;
    use SoftDeletes;

     protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token'
    ];

     
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

}
