<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'numero',
        'intitule',
    ];

    
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
