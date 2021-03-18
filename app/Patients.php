<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    //
    protected $fillable = [
        "idnumber","passportnumber","firstname","surname","streetaddress","city","province",
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:i',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d h:i:s'
     ];
}
