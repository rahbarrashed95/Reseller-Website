<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
class orderInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function orderItems(){
        return $this->hasMany(Order::class);
    }
    
}
