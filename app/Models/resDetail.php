<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resDetail extends Model
{
    use HasFactory;

    //PRIMARY KEY
    protected $primaryKey = 'resDetailNum';

    //TABLES
    protected $table = 'tblresdetailfile';

    // UNABLE TIMESTAMPS
    public $timestamps = false;

    // FILLABLE REQUEST
    protected $fillable = [
        'resDetailRmNum',
        'resDetailPrice',
        'resDetailStatus',
        'resDetailGuestID',
        'resDetailRmType'
    ];
}
