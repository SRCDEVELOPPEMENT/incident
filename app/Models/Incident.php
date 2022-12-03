<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pros;
use App\Models\Categorie;
use App\Models\Tache;
use App\Models\Battle;
use App\Models\Users_incident;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 
        'description',
        'closure_date',
        'status',
        'cause',
        'perimeter',
        'priority',
        'categorie_id',
        'proces_id',
        'created_at',
        'battles',
    ];

    public function categories()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function processus()
    {
        return $this->belongsTo(Pros::class, 'proces_id');
    }

    public function task()
    {
        return $this->hasMany(Tache::class);
    }

    public function battles()
    {
        return $this->hasMany(Battle::class);
    }

    public function users_incidents()
    {
        return $this->hasMany(Users_incident::class);
    }

}
