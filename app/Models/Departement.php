<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use App\Models\User;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'name',
        'created_at'
    ];

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

}
