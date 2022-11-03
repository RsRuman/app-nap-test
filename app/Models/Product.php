<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'slug',
        'price',
        'status'
    ];

    const Status = [
        'Active' => 1,
        'Inactive' => 2
    ];

    public function getStatusLabelAttribute(): int|string
    {
        return array_flip(self::Status)[$this->attributes['status']];
    }

    #Product Categories
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    #Product Images
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }
}
