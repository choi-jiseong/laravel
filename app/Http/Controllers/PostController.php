<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except(['index', 'show']);
    }
    //홈
    public function home(){
        return view('posts.home');
    }
    //등록폼
    public function create(){
        // dd('OK');
        return view('posts.create');
    }
    //db에 등록
    public function store(Request $request){
        // $request->input['title'];
        // $request->input['content'];
        $title = $request->title;
        $content = $request->content;

        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required'
        ]);  //오류는 session에 들어간다

        //dd($request);

        //db에 저장
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        $post->user_id = Auth::user()->id;  //현재 로그인한 사용자의 유저모델 객체를 준다.

        $post->save();
        //결과 뷰를 반환
        return redirect('/posts/index');
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
    public function show(Request $request, $id){
        $page = $request->page;
        $post = Post::find($id);  // $id 값의 Post 객체 가져오기
        return view('posts.show', compact('post', 'page'));  //Post 값도 보내주기
    }
    //리스트보기 page
    public function index(){
        // $post = Post::all();
        // $posts = Post::orderBy('created_at', 'desc')->get(); // 만든 시간에따라 최신순으로
        // $posts = Post::latest()->get();  //이런 방법으로 도 가능

        $posts = Post::latest()->paginate(5);
        // return $posts;
        // sdd($posts[0]->created_at);
         return view('posts.index', ['posts'=>$posts]);  //posts에 있는 데이터를 index view에 넘겨준다
    }
}
