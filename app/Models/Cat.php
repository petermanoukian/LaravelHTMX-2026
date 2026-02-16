<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    // Explicit table name if needed (otherwise Laravel assumes 'cats')
    protected $table = 'cats';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'des',
        'dess',
        'img', 'img2',
        'filer',
    ];

    /* too early we are not there yet 
    public function prods()
    {
        return $this->hasMany(Prod::class, 'cat_id');
    }
    */

    public function subcats()
    {
        return $this->hasMany(Subcat::class, 'catid');
    }



}
