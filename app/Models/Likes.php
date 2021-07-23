<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;

    protected $table='likes';
    public $timestamps = false;

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
