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
        'is_on_sale',
        'sale_price',
        'subcategory_id',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

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
public function order()
{
    return $this->belongsTo(Orders::class);

}

public function images()
{
    return $this->hasMany(ProductImage::class);
}

}
