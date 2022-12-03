<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service_request;
use App\Models\Incident;
use App\Models\Departement;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'status',
        'maturity_date',
        'departement_solving_id',
        'resolution_degree',
        'incident_number',
        'created_at'
    ];

    public function indes()
    {
        return $this->belongsTo(Incident::class, 'incident_number');
    }

    public function departements()
    {
        return $this->belongsTo(Departement::class, 'departement_solving_id');
    }

    public function service_requests()
    {
        return $this->hasMany(Service_request::class);
    }
}
