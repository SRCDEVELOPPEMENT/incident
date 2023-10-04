<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Incident;
use App\Models\User;
use App\Models\Type;
use App\Models\Tache;
use App\Models\Categorie;


class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'type_id',
        'region'
    ];

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function types()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }


}
