<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = "payment";

    protected $fillable = [
        'first_name',
        'last_name',
        'amount',
        'currency',
        'email',
        // 'tx_ref',
        // 'payment_date', // Include the payment_date attribute
        // Add more fields as needed
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];
}
