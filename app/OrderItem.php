<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';
    protected $fillable = [
        'order_id', 'section_id', 'quantity', 'status_id',
    ];
    public $timestamps = true;
}
