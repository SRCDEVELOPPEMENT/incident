<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tache;

class Logtache extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'title',
        'tache_id',
        'statut',
        'user_id',
        'created_at'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks()
    {
        return $this->belongsTo(Tache::class, 'tache_id');
    }

}
