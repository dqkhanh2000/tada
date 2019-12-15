<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordForget extends Model
{
    protected $table = 'password_forgets';
    protected $fillable = [
        'email',
        'token',
    ];
}
