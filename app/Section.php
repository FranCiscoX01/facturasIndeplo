<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    protected $fillable = [
        'code', 'name', 'price', 'status_id',
    ];
    public $timestamps = true;
}
