<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Desbloqueia as colunas
    protected $guarded = [];

    // Se a tabela dos itens não tiver as colunas created_at e updated_at, descomenta a linha abaixo:
    // public $timestamps = false;

    // 1 Item pertence a 1 Encomenda
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // 1 Item tem 1 Estampa (tshirt_image_id)
    public function tshirtImage()
    {
        return $this->belongsTo(TshirtImage::class);
    }

    // 1 Item tem 1 Cor (color_code)
    public function color()
    {
        // Se a vossa chave estrangeira para a cor se chamar apenas 'color_code', temos de avisar o Laravel:
        return $this->belongsTo(Color::class, 'color_code', 'code');
    }
}