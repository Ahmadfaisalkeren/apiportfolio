<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill',
        'description',
        'image',
        'hero_id'
    ];

    public function hero()
    {
        return $this->belongsTo(Hero::class);
    }
}
