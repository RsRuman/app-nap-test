<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $fillable = [
        'product_id',
        'image_path',
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

    #Image product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
