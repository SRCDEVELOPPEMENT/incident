<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Incident;

class Users_incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'id', 
        'isTrigger',
        'incident_number',
        'user_id',
    ];

        public function incidents()
        {
            return $this->belongsTo(Incident::class, 'incident_number');
        }
            
        public function users()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

}
