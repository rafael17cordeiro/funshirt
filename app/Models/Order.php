<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Desbloqueia todas as colunas para podermos guardar dados facilmente
    protected $guarded = [];

    // Relação para obter o cliente e respetivo utilizador
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relação para obter os itens da encomenda
    public function items()
    {
        // Certifica-te de que o teu modelo de itens se chama OrderItem
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}

