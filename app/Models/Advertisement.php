<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bid;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'seller_id',
        'price',
        'image',
        'type',
        'delivery',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'advertisement_has_reviews');
    }

    public function scopePrice($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function renter()
    {
        return $this->belongsToMany(User::class, 'rented_products', 'advertisement_id', 'user_id')->withPivot('start_date', 'end_date');
    }

    public function linkedAdvertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'linked_advertisements', 'advertisement_id', 'linked_advertisement_id');
    }
}
