<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{
    protected $fillable = ['name'];

    //Relación uno a muchos
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
