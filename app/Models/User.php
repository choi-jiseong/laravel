<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "users";  //users 이면 안적어줘도 된다 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comments(){
        return $this->hasMany(Comments::class);
    }

    public function viewed_posts(){
        // return $this->belongsToMany(Post::class);
        return $this->belongsToMany(Post::class, 'post_user', 'user_id', 'post_id', 'id', 'id', 'posts');
    }

    public function likes_viewed_posts(){
        // return $this->belongsToMany(Post::class);
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id', 'id', 'id', 'posts');
    }
}
