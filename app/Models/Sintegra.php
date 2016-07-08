<?php

namespace VmbTest\Models;

use Illuminate\Database\Eloquent\Model;

class Sintegra extends Model
{
    protected $fillable = array(
        'user_id',
        'cnpj',
        'resultado_json'
    );

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
