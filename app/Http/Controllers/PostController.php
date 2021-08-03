<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Likes;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
    public function create(Request $request){
        
        $in = $request->in;
        $page = $request->page;
        // dd($in);
        return view('posts.create', ['in'=>$in, 'page'=>$page]);
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
            // $name = $request->file('imageFile')->getClientOriginalName(); //원래 이름 가져올 수 있따.
            // $extension = $request->file('imageFile')->extension(); //원래 파일의 확장자를 가져올 수 있다.
            // $nameWithoutExtension = Str::of($name)->basename('.'.$extension); //basename 안에 짤라준다
            // // dd($nameWithoutExtension);
            // $fileName = $nameWithoutExtension.'_'.time().'.'.$extension; //base이름 + 현재 시간 + 확장자
            // // dd($fileName);
            // $request->file('imageFile')->storeAs('public/images', $fileName); //storeAs 앞 폴더에 뒤에 파일을 저장해준다
    
            // $post->image = $fileName;            
            $post->image = $this->uploadPostImage($request);
        }
        
        $post->save();
        $in = $request->in;
        //결과 뷰를 반환
        if($in == 1){
            return redirect()->route('posts.index');
        }else{
            return redirect()->route('posts.myIndex');
        }

    }

    protected function uploadPostImage($request){
        $request->file('imageFile');
            $name = $request->file('imageFile')->getClientOriginalName();
            $extension = $request->file('imageFile')->extension();
            $nameWithoutExtension = Str::of($name)->basename('.'.$extension);
            $fileName = $nameWithoutExtension.'_'.time().'.'.$extension;
            $request->file('imageFile')->storeAs('public/images', $fileName);

            return $fileName;
    }

    //수정폼
    public function edit(Request $request, Post $post){  //아이디를 받고 post객체를 달라고하면 id에 맞는 post객체를 찾아준다

        // $post = Post::find($id);
        // $post = Post::where('id', $id)->get()->first();
        // dd($post);
        if(auth()->user()->id != $post->user_id){
            abort(403);
        }
        $in = $request->in;

        return view('posts.edit')->with(['post'=>$post, 'page'=>$request->page, 'in'=>$in]);
    }
    //db에 수정
    public function update(Request $request, $id){
        //기존에 있던 파일 시스템의 이미지 삭제, 원래 이미지 추가

        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'imageFile' => 'image|max:2000'
        ]); 

        $post = Post::find($id);  //findOrFail() 오류 나면 404 페이지
        // dd($post);
        
        //Authorization. 즉 수정 권한이 있는지 검사 즉, 로그인한 사용자와 게시글의 작성자가 같은지 체크
        // if(auth()->user()->id != $post->user_id){
        //     abort(403); //권한이 없다
        // }
        if($request->user()->cannot('update', $post)){
            abort(403);
        }

        if($request->file('imageFile')){
            $imagePath = 'public/images/'.$post->image;
            Storage::delete($imagePath);
            // $request->file('imageFile');
            // $name = $request->file('imageFile')->getClientOriginalName();
            // $extension = $request->file('imageFile')->extension();
            // $nameWithoutExtension = Str::of($name)->basename('.'.$extension);
            // $fileName = $nameWithoutExtension.'_'.time().'.'.$extension;
            $post->image = $this->uploadPostImage($request);
        }
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        $in = $request->in;

        return redirect()->route('posts.show', ['id'=>$id, 'page'=>$request->page, 'in'=>$in]);
    }
    //db에서 삭제
    public function destroy(Request $request, $id){
        //db에서 삭제하기 전에 파일 시스템에서 이미지 파일 삭제
        $post= Post::findOrFail($id);
        $in = $request->in;

        //Authorization. 즉 수정 권한이 있는지 검사 즉, 로그인한 사용자와 게시글의 작성자가 같은지 체크
        // if(auth()->user()->id != $post->user_id){
        //     abort(403); //권한이 없다
        // }
        if($request->user()->cannot('delete', $post)){
            abort(403);
        }

        $page= $request->page;
        if($post->image){
            $imagePath = 'public/images/'.$post->image;
            Storage::delete($imagePath);
        }
        $post->delete();
        if($in == 1){
            return redirect()->route('posts.index', ['page'=>$page]);
        }else{
            return redirect()->route('posts.myIndex', ['page'=>$page]);
        }

    }

    //상세보기 page
    public function show(Request $request, $id){
        $page = $request->page;
        $post = Post::find($id);  // $id 값의 Post 객체 가져오기
        // $user_name = User::find($post->user_id)->name;
        $in = $request->in;
        // $post->count++; //조회수 증가시킴
        // $post->save();  //db에 반영

        /*
            이 글을 조회한 사용자들 중에, 현재 로그인한 사용자가 포함되어 있는지를 체크하고 포함되어 있지 않으면 추가. 
            포함되어 있으면 다음 단계로 넘어감.
        */
        if(Auth::user() != null && !$post->viewers->contains(Auth::user())){
            $post->viewers()->attach(Auth::user()->id);  //이렇게 하면 pivot테이블에 들어간다
        }
        
        $comments = Comments::latest()->where('post_id', '=', $id)->get();
        // dd($comments);
        return view('posts.show', compact('post', 'page', 'in', 'comments'));  //Post 값도 보내주기
    }

    public function like(Request $request){
        // dd($request);
        $id = $request->id;
        $post = Post::find($id);
        $like = Likes::where('post_id', '=', $post->id)->where('user_id', '=', auth()->user()->id)->first();
        // dd($like->id);
        if(Auth::user() != null && !$post->likes_viewers->contains(Auth::user())){
            $post->likes_viewers()->attach(Auth::user()->id);  //이렇게 하면 pivot테이블에 들어간다
        }else if(Auth::user() != null && $post->likes_viewers->contains(Auth::user())){
            Likes::find($like->id)->delete();
        }

        return redirect()->route('posts.show', ['post'=>$post, 'page'=>$request->page, 'in'=>$request->in, 'id'=>$id]);
    }


    //리스트보기 page
    public function index(){
        // $post = Post::all();
        // $posts = Post::orderBy('created_at', 'desc')->get(); // 만든 시간에따라 최신순으로
        // $posts = Post::latest()->get();  //이런 방법으로 도 가능
        // dd($request);
            $posts = Post::latest()->paginate(4);
        
        // $users = User::all();
        // return $posts;
        // sdd($posts[0]->created_at);
        // dd($posts);
        $in = 1;
         return view('posts.index', ['posts'=>$posts, 'in'=>$in]);  //posts에 있는 데이터를 index view에 넘겨준다
    }

    public function myIndex() {
        // $user = User::find(auth()->user()->id);
        // dd($user);
        $posts = Post::latest()->where('user_id', auth()->user()->id)->paginate(5);
        // $posts = auth()->user()->posts()->latest()->paginate(5);
        // $posts = auth()->user()->posts()->orderBy('title', 'asc')->orderBy('created_at', 'desc')->get();
        // dd($posts);
        $in = 2;
        return view('posts.myIndex', ['posts'=>$posts, 'in'=>$in]);
    }

    public function search(Request $request, $in){
        //  dd($in);
         $posts = Post::latest()->where('title', 'like' , '%'.$request->search.'%' )->paginate(4);
        
        return view('posts.search', ['posts'=>$posts, 'in'=>$in]);
    }
}
