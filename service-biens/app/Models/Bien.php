<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation', 'description', 'categorie', 'marque', 'modele',
        'numero_serie', 'date_achat', 'valeur', 'etat', 'emplacement',
        'responsable', 'notes'
    ];

    protected $casts = [
        'date_achat' => 'date',
        'valeur' => 'decimal:2',
    ];
}
