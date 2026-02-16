<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcat extends Model
{
    use HasFactory;

    protected $fillable = [
        'catid',
        'name',
        'des',
        'dess',
        'img',
        'img2',
        'filer',
    ];

    // Relationship back to Cat
    public function cat()
    {
        return $this->belongsTo(Cat::class, 'catid');
    }

}

