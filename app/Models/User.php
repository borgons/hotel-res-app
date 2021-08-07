<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    //PRIMARY KEY 
    protected $primaryKey = 'adminID';

    // TABLE 
    protected $table = 'users';

    //TIMESTAMPS 
    public $timestamps = false;

    //FILLABLES
    protected $fillable = [
        'adminID',
        'adminEmpID',
        'adminEmpFirst',
        'adminEmpLast',
        'adminUsername',
        'adminPass',
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'adminPass',
    ];
}
