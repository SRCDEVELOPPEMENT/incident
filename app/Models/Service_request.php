<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tache;

class Service_request extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 
        'title',
        'maturity_date',
        'status',
        'tache_id',
        'created_at'
    ];

    public function taches()
    {
        return $this->belongsTo(Tache::class, 'tache_id');
    }
}
