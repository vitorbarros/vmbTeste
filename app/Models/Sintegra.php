<?php
namespace VmbTest\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Sintegra extends Model implements Transformable
{
    use TransformableTrait;

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

