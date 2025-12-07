<?php

namespace App\Http\Controllers;

/**
 * TOTO JE ZÁKLADNÁ TRIEDA PRE VŠETKY KONTROLÉRY V LARAVELI.
 *
 * V Laraveli všetky moje kontroléry (AuthController, OfferController, CategoryController...)
 * dedia z tejto triedy.
 *
 * Slúži ako spoločný "rodič" – teda zdroj default správania,
 * ktoré môžem neskôr rozširovať.
 *
 * Aktuálne je prázdna, ale Laravel ju používa ako základnú kostru
 * pre celú controllers vrstvu.
 */
abstract class Controller
{
    //
    // Sem by som mohol v budúcnosti dať metódy,
    // ktoré by využívali všetky kontroléry (napr. logovanie, helpery...)
    //
}
