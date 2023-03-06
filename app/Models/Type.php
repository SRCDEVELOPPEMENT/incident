<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Site;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'name', 
    ];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
