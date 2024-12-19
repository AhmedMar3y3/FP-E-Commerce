<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['name','email','password'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
