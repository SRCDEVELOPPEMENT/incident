<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service_request;
use App\Models\Incident;
use App\Models\Departement;
use App\Models\Site;
use App\Models\Logtache;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'status',
        'maturity_date',
        'departement_id',
        'resolution_degree',
        'incident_number',
        'created_at',
        'site_id',
        'ds_number',
        'observation_task'
    ];

    public function incidents()
    {
        return $this->belongsTo(Incident::class, 'incident_number');
    }

    public function departements()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    public function sites()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function service_requests()
    {
        return $this->hasMany(Service_request::class);
    }

    public function logtaches()
    {
        return $this->hasMany(Logtache::class);
    }

}
