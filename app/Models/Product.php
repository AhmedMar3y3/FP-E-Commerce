<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'title',
        'description',
        'quantity',
        'price',
        'subcategory_id',
    ];

    public function colors()
{
    return $this->belongsToMany(Color::class, 'color_product');
}
    public function sizes()
{
    return $this->belongsToMany(Size::class, 'size_product');
}

public function subcategory()
{
    return $this->belongsTo(SubCategory::class);

}
}
