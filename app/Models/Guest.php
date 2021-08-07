<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    // PRIMARY KEY 
    protected $primaryKey = 'guestID';

    // TABLE
    protected $table = 'tblguest';

    // TIMESTAMPS
    public $timestamps = false;

     // FILLABLE
    protected $fillable = [
        'guestID',
        'guestFirst',
        'guestLast',
        'guestAddress',
        'guestContact'
    ];
}
