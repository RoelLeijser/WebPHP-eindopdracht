<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $casts = ['published_at' => 'datetime'];
  
    protected $guarded = [];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_reviews');
    }

    public function advertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_has_reviews');
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

}
