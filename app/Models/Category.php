<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
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

    #Category Products
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
}
