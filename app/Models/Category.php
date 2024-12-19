<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'admin_id'];
     public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function subs()
    {
        return $this->hasMany(SubCategory::class);
    }
}