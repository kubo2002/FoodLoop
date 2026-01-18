<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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

    // Automatické pretypovanie polí
    protected $casts = [
        'expiration_date' => 'date',
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

    // Vzťah na rezervácie
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Accessor: je ponuka expirovaná?
    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expiration_date) return false;
        // porovnávam dátum bez času
        return $this->expiration_date->lt(now()->startOfDay());
    }

    // Pomocná metóda: existuje vyzdvihnutá rezervácia?
    public function hasPickedUpReservation(): bool
    {
        return $this->reservations()->where('status', 'picked_up')->exists();
    }
}
