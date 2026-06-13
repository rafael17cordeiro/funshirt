<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public static function getNameByCode($code)
    {
        return self::where('code', strtolower($code))
            ->value('name') ?? 'Cor desconhecida';
    }

}