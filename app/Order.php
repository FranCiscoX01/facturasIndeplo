<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'costumer_id', 'code', 'date', 'status_id',
    ];
    public $timestamps = true;
}
