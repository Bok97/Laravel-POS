<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCustomerName()
    {
        if($this->customer) {
            return $this->customer->name;
        }
        return 'Walking Customer';
    }

    public function total()
    {
        return $this->transactions->map(function ($i){
            return $i->amount;
        })->sum();
    }

    public function formattedTotal()
    {
        return number_format($this->total(), 2);
    }

    public function formattedReceivedAmount()
    {
        return number_format($this->total(), 2);
    }

}

    