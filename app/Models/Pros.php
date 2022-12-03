<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Incident;

class Pros extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'name', 
        'description',
        'created_at'
    ];

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
}
