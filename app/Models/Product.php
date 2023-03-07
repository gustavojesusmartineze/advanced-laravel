<?php

namespace App\Models;

use App\Utils\CanBeRated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, CanBeRated;

    protected $guarded = [];

    // protected $fillable = [];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function booted()
    {
        static::creating(function (Product $product) {
            $faker = \Faker\Factory::create();
            $product->image_url = $faker->imageUrl();
            $product->createdBy()->associate(auth()->user());
        });
    }
}
