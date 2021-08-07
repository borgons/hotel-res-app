<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resHeader extends Model
{
    use HasFactory;

    protected $primaryKey = 'resHeaderNum';

    protected $table = 'tblresheaderfile';

    public $timestamps = false; 

    protected $fillable =[
        'resHeaderDate',
        'resHeaderStatus',
        'resHeaderGuestID'
    ];

}
