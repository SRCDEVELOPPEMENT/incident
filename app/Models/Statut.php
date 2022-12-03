<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Courrier;

class Statut extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'intituleStatut', 'DescriptionStatut'
    ];

    // public function courriers()
    // {
    //     return $this->hasMany(Courrier::class);
    // }

}
