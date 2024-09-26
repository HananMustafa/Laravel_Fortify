<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // Define the fields that can be mass assigned
    protected $fillable = ['client_id', 'content'];

    // A note belongs to a client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
