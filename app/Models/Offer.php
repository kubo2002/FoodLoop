<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Offer extends Model
{
    // Zoznam atribútov, ktoré môžu byť hromadne vyplnené pomocou create() / update()
    protected $fillable = [
        'title',
        'description',
        'image',
        'expiration_date',
        'location',
        'category_id',
        'user_id',
        'status'
    ];

    // Každá ponuka patrí jednej kategórii (vzťah N:1)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Každá ponuka patrí jednému používateľovi (donorovi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
