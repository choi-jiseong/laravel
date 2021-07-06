<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            'content' => 'required',
            'imageFile' => 'image|max:2000'
        ]);  //오류는 session에 들어간다, 오류가 되면 자동적으로 redirection 시켜준다(create.blade.php 로)

        //dd($request);

        //db에 저장
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        $post->user_id = Auth::user()->id;  //현재 로그인한 사용자의 유저모델 객체를 준다.

        //file 처리
        //내가 원하는 파일시스템 상의 위치에 원하는 이름으로 파일을 저장하고 그파일 이름을 컬럼에 설정
        if($request->file('imageFile')){
            $name = $request->file('imageFile')->getClientOriginalName(); //원래 이름 가져올 수 있따.
            $extension = $request->file('imageFile')->extension(); //원래 파일의 확장자를 가져올 수 있다.
            $nameWithoutExtension = Str::of($name)->basename('.'.$extension); //basename 안에 짤라준다
            // dd($nameWithoutExtension);
            $fileName = $nameWithoutExtension.'_'.time().'.'.$extension; //base이름 + 현재 시간 + 확장자
            // dd($fileName);
            $request->file('imageFile')->storeAs('public/images', $fileName); //storeAs 앞 폴더에 뒤에 파일을 저장해준다
    
            $post->image = $fileName;            
        }
        
        $post->save();
        //결과 뷰를 반환
        return redirect('/posts/index');
    }
    //수정폼
    public function edit(){

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
