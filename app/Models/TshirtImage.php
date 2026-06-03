<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TshirtImage extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Relação: Uma Imagem de Catálogo pertence a uma Categoria.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}