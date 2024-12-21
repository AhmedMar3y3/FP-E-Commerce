<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hex_code',
    ];

    public function products()
{
    return $this->belongsToMany(Product::class, 'color_product');
}


public function order()
{
    return $this->belongsTo(Orders::class);

}




}
