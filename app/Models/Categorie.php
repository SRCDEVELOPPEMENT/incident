<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departement;
use App\Models\Incident;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'name',
        'created_at',
        'departement_id',
    ];

    public function incients()
    {
        return $this->hasMany(Incident::class);
    }

    public function departements()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
}
