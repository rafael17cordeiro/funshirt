<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes; // Porque a tabela tem 'deleted_at'

    public $timestamps = false; // Porque a tabela não tem 'created_at' nem 'updated_at'

    protected $guarded = []; // Permite leitura/escrita de todos os campos
}