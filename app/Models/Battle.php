<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Incident;

class Battle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'title',
        'description',
        'incident_id',
        'created_at'
    ];

    public function incidents()
    {
        return $this->belongsTo(Incident::class, 'incident_id');
    }

}
