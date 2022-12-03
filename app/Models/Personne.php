<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicule;
use App\Models\Poste;
use App\Models\Courrier;

class Personne extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'fullname', 'telephone', 'matricule', 'adresse', 'vehicule_id', 'poste_id'
    ];

    public function vehicules()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function postes()
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

    public function courriers()
    {
        return $this->hasMany(Courrier::class);
    }

}
