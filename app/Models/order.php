<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'product_qty',
        'product_prc',
        'bill_name',
        'bill_Phone',
        'bill_email',
        'country',
        'state',
        'city' ,
        'address1',
        'address2',
        'pin_code',
        'payment_mode',
        'payment_id',
        'order_status',
        'tracking_no',
    ];
}
