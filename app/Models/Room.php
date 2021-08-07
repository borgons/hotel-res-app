<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    //PRIMARY KEY
    protected $primaryKey = 'rmID';

     //TABLES   
    protected $table = 'tblroom';

    //UNABLE TIMESTAMPS
    public $timestamps = false;

    //FILLABLE REQUEST
    protected $fillable = [
        'rmNo',
        'rmType',
        'rmPrice',
        'rmDesc',
        'rmStatus'
    ];
}
