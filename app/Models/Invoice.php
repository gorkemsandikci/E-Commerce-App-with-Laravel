<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'order_no',
        'name',
        'company_name',
        'address',
        'country',
        'city',
        'district',
        'zip_code',
        'email',
        'phone',
        'note'
    ];
}
