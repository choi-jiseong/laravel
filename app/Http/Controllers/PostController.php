<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //홈
    public function home(){
        return view('posts.home');
    }
    //등록폼
    public function create(){
        $name = '홍길동';
        return view('posts.create');
    }
    //db에 등록
    public function store(){
        
    }
    //수정폼
    public function edit(){
        return view('posts.edit');
    }
    //db에 수정
    public function update(){

    }
    //db에서 삭제
    public function destroy(){

    }
    //상세보기 page
    public function show(){
        return view('posts.show');
    }
    //리스트보기 page
    public function index(){
        return view('posts.index');
    }
}
