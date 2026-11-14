<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bien_id', 'nom_bien', 'service_destinataire', 'responsable',
        'date_affectation', 'date_fin', 'motif', 'etat'
    ];

    protected $casts = [
        'date_affectation' => 'date',
        'date_fin' => 'date',
    ];
}
