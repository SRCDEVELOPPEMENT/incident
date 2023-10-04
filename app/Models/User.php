<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Logtache;
use App\Models\Tache;
use App\Models\Site;
use App\Models\Users_incident;

use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'fullname',
        'login',
        'site_id',
        'password',
        'see_password',
        'created_at',
        'email',
        'responsable',
    ];



    public function sites()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }


    public function users_incidents()
    {
        return $this->hasMany(Users_incident::class);
    }

    public function logtaches()
    {
        return $this->hasMany(Logtache::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
