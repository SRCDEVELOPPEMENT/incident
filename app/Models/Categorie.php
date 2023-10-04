<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Incident;
use App\Models\Site;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'site_id',
    ];

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function sites()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
