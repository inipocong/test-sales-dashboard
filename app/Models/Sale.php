<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillaable = ['product_name','sale_date','quantity','price'];
    protected $casts = [
        'sale_date' => 'date'
    ];
}
