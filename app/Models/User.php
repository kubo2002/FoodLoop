<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// pomoc s AI

/**
 * User model reprezentuje jedného používateľa v databáze.
 * Laravel automaticky pracuje s tabuľkou "users".
 *
 * Tento model komunikuje s authentikáciou, aktualizáciou profilu
 * aj so vzťahmi v ponukách (user_id).
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * $fillable
     * ----------
     * Zoznam stĺpcov, ktoré môžu byť hromadne (mass-assigned) zapisované
     * do databázy pomocou User::create() alebo $user->update().
     *
     * Toto je bezpečnostný mechanizmus – aby som nezapisoval náhodné dáta,
     * ktoré by nemali byť menené (napr. id, created_at...).
     */
    protected $fillable = [
        'name',      // meno používateľa
        'email',     // email
        'password',  // hash hesla
        'role',      // rola: donor / recipient
        'photo'      // cesta k profilovej fotke
    ];

    /**
     * $hidden
     * -------
     * Tieto atribúty sa nikdy NEVRACAJÚ v JSON odpovediach.
     * Ani keď používam API, ani keď dumpujem model.
     *
     * Je to dôležité pre bezpečnosť – nechcem vyzradiť hash hesla.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * casts()
     * -------
     * Definuje, ako má Laravel automaticky konvertovať určité stĺpce.
     *
     * 'email_verified_at' => 'datetime'
     *     - pri čítaní sa automaticky premení na Carbon objekt (dátum)
     *
     * 'password' => 'hashed'
     *     - Laravel AUTOMATICKY zahashuje heslo pri ukladaní
     *       (napr. ak použijem $user->update(['password' => 'heslo']))
     *       → nemusím volať Hash::make()
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

}
