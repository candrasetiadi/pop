<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'reference',
	    'type',
	    'origin_name',
	    'origin_address',
	    'destination',
	    'contact',
	];
}
