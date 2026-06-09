<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    // Definição padrão e limpa do Laravel
    protected $fillable = [
        'id', 
        'nif', 
        'address', 
        'default_payment_type', 
        'default_payment_ref'
    ];

    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}