<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // PRIMARY KEY 
    protected $primaryKey = 'empID';

    // TABLE
    protected $table = 'tblemployee';

    // TIMESTAMPS
    public $timestamps = false;

    // FILLABLES
    protected $fillable = [
        'empID',
        'empFirst',
        'empLast',
        'empPosition',
    ];
}
