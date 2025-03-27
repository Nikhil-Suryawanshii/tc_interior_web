<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $guarded = [];
    // Define the fillable attributes
    protected $fillable = [
    'name',
    'email',
    'password',
   ];

    protected $hidden = ['password', 'remember_token'];


}
