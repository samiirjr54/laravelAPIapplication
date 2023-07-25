<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

     protected $fillable = [
        'name',
        'desc',
        'price',
    ];


    
    public function Roles(){
        return $this->belongsTo(Role::class);
    }
}
