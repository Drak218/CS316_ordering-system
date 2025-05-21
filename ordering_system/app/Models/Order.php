<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    Protected $fillable = [
        'staff_id',
        'customer_name',
        'address',
        'city',
        'zip_code',
        'tax_exempt',
        'product_name',
        'price',
        'quantity',
        'weight',
        'shipping_method',
        'sales_tax',
        'shipping_fee',
        'handling_fee',
        'total'
    ];
}
