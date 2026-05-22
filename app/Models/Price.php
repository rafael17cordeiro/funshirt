<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public $timestamps = false;
    protected $guarded = []; // Permite leitura de tudo
}