<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{   
    // protected $table = 'my_posts'; table 지정해주기
    use HasFactory;

    public function imagePath() {
        // $path = '/storage/images/';

        $path= env('IMAGE_PATH', '/storage/images/');
        $imageFile =  $this->image ?? 'no_image_available.png';
        return $path.$imageFile;
        
    }

    public function user() {
        return $this->belongsTo(User::class);  //post 객체를 생성하면 user정보를 넘겨주는 메서드
    }
}
