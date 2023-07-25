<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $table = 'password_resets';

    protected $primaryKey = 'email';

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
}
