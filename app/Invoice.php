<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    protected $fillable = [
        'code', 'order_id', 'date', 'file', 'status_id',
    ];
    public $timestamps = true;
}
