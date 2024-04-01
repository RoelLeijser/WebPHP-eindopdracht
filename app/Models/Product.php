<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'products'; 

    public function user()
    {
        return $this->belongsTo(User::class, 'user_has_reviews');
    }
    
}
