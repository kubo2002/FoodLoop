<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    // Umožňuje hromadné priradenie hodnoty 'name'
    protected $fillable = ['name'];

    // Definícia vzťahu: jedna kategória môže mať viac ponúk
    public function offers()
    {
        // 1 : N
        return $this->hasMany(Offer::class);
    }
}
