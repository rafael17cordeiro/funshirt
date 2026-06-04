<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['id', 'nif', 'address', 'default_payment_type', 'default_payment_ref'])]
class Customer extends Model
{
    use SoftDeletes;

    // O ID não é autoincrementável
    public $incrementing = false;
    protected $keyType = 'int';

    // Desligar os timestamps automáticos do Laravel para esta tabela
    public $timestamps = false;

    public function user()
    {
        // O segundo parâmetro 'id' diz ao Laravel que a chave estrangeira é o 'id' e não o 'user_id'
        return $this->belongsTo(User::class, 'id');
    }
}