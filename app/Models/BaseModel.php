<?php


namespace App\Models;

use App\Services\Hasher;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{

    protected $appends = ['idd'];

    protected $hidden = ['id','deleted_at'];

    protected $guarded = ['id'];

    public function getIddAttribute()
    {
        return Hasher::encode($this->attributes['id']);
    }
}
