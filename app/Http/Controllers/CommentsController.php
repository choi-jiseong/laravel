<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    //

    public function comment(Request $request){
        // dd($request);
        
        $page = $request->page;
        $postId = $request->id;
        $message = $request->comment;
        $in = $request->in;
        if(Auth::user() == null){
            return redirect()->route('posts.show', ['page'=>$page, 'in'=>$in, 'id'=>$postId]);
        }
        $userId = Auth::user()->id;
        // dd($userId);
        $request->validate([
            'comment' => 'required',
        ]);  //오류는 session에 들어간다, 오류가 되면 자동적으로 redirection 시켜준다(create.blade.php 로)

        

        $comment = new Comments();
        $comment->post_id = $postId;
        $comment->user_id = $userId;
        $comment->comment = $message;
        // dd($comment);
        
        $comment->save();
        // dd($comments);

        return redirect()->route('posts.show', ['page'=>$page, 'in'=>$in, 'id'=>$postId]);
    }
    
    public function destroy(Request $request, $id){
        // dd($request);
        
        $comment = Comments::find($id);
        $postId = $comment->post_id;
        // dd($comment);

        $in = $request->in;
        $page = $request->page;

        if(auth()->user()->id != $comment->user_id){
            abort(403);
        }

        $comment->delete();

        return redirect()->route('posts.show', ['id'=>$postId, 'in'=>$in, 'page'=>$page]);
    }
}
