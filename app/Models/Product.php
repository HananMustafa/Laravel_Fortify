<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'image', 'video', 'link'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
