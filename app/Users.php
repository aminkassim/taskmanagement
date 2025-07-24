<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = ['id', 'name', 'email', 'password', 'remember_token', 'created_at', 'updated_at'];

    protected $primaryKey = 'id'; // or null

    public $incrementing = true;
}
