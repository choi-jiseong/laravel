<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Post') }}
      </h2>
  </x-slot>
  <button class="flex justify-between sm:mt-2 mx-auto z-10 bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-3xl p-4 m-4" onclick=location.href="{{ $in == 1 ? route('posts.index', ['page'=>$page]) : route('posts.myIndex', ['page'=>$page])}}">목록보기</button>
  <div class="flex justify-between sm:mt-2 max-w-5xl w-full mx-auto z-10">
    <div class="container m-3 bg-white rounded-3xl p-3">
      
      {{-- @if ($in == 1) --}}
        
      {{-- @else --}}
        {{-- <button class="btn btn-primary" onclick=location.href="{{ route('posts.myIndex', ['page'=>$page]) }}">목록보기</button> --}}
      {{-- @endif --}}
            <div class="form-group">
              <label class="text-2xl font-bold">Title</label>
              <div readonly name="title" class="w-full pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none border-gray-200" id="title">{{ $post->title }}</div>
            </div>

            <div class="form-group mt-2">
              <label for="content" class="text-2xl font-bold">Content</label>
              <div class="w-full pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none border-gray-200" readonly name="content" id="content">{!! $post->content !!}</div>
            </div>

            <div class="form-group mt-3">
              <label for="image" class="text-2xl font-bold">Post Image</label>
              <div>
                {{-- <img class="img-thumbnail w-25" src="/storage/images/{{ $post->image ?? 'no_image_available.png'}}"> --}}
                <img class="w-full" src="{{ $post->imagePath() }}">
              </div>
            </div>

            <div class="form-group mt-3">
              <label class="text-xl font-bold">등록일</label>
              <input type="text" readonly class="w-full rounded-3xl border-2 border-gray-200"value="{{ $post->created_at }}">
            </div>

            <div class="form-group mt-3">
              <label class="text-xl font-bold">수정일</label>
              <input type="text" readonly class="w-full rounded-3xl border-2 border-gray-200"value="{{ $post->updated_at }}">
            </div>

            <div class="form-group mt-3">
              <label class="text-xl font-bold">작성자</label>
              <input type="text" readonly class="w-full rounded-3xl border-2 border-gray-200"value="{{ $post->user->name }}">
            </div>
            @auth   {{-- 로그인을 안했을 때 삭제, 수정 불가능 --}}
              {{-- @if($post->user_id == auth()->user()->id) --}}
              @can('update', $post)
                <div class="flex mt-3">
                  <table>
                    <tr>
                      <td>
                        <button class="flex justify-between sm:mt-2 mx-auto z-10 bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-2xl p-2 m-2" onclick=location.href="{{ route('posts.edit', ['post'=>$post->id, 'page'=>$page, 'in'=>$in]) }}">수정</button>
                      </td>
                      <td>
                        <form action="{{ route('posts.delete', ['id'=>$post->id, 'page'=>$page, 'in'=>$in]) }}" method="post">
                          @csrf
                          @method("delete")
                          <button type="submit" class="flex justify-between sm:mt-2 mx-auto z-10 bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-2xl p-2 m-2">삭제</button>
                        </form>
                      </td>
                    </tr>
                  </table>
                </div>
              {{-- @endif --}}
              @endcan
            @endauth
    </div>
    <div class="container m-3 bg-white rounded-3xl p-3">
      <div class="form-group mb-3">
        <label class="text-xl font-bold w-full ml-8">댓글</label>
        <form action="{{ route('posts.comment', ['id'=>$post->id, 'page'=>$page, 'in'=>$in]) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('post')
          <input type="text" name="comment" id="comment" class="ml-6 w-4/6 rounded-3xl border-2 border-gray-200">
          <button type="submit" class="bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-2xl p-2 m-2">등록</button>
        </form>
      </div>
      <div>
        @if ($comments != null)
          @foreach ($comments as $comment)
          <div class="flex ml-5">
            <div class="m-auto w-full mb-1">
              <div class="flex flex-col bg-gray-50 max-w-sm shadow-md py-2 px-10 md:px-8 rounded-md">
                <div class="flex flex-col gap-6 md:gap-8">
                  <div class="flex flex-col text-center md:text-left">
                    <div class="font-medium text-lg font-bold text-gray-800">{{ $comment->user->name }}</div>
                    <div class="text-gray-500 mb-3 whitespace-nowrap">{{ $comment->comment }}</div>
                    <div class="flex flex-row gap-4 h-10 text-gray-800 my-auto text-1xl mx-auto md:mx-0">
                      <div class="text-gray-500">{{ $comment->created_at }}</div>
                      @auth
                        @can('delete', $comment)
                        <form action="{{ route('comments.delete', ['id'=>$comment->id, 'page'=>$page, 'in'=>$in]) }}" method="post">
                          @csrf
                          @method('delete')
                          <button type="submit" class=" ml-20 z-10 bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-2xl p-1 m-1">삭제</button>
                        </form> 
                        @endcan                                    
                      @endauth
                    </div>
                  </div>
                </div>
              </div>
              {{-- <input type="text" class="w-1/6" readonly value="{{ $comment->user->name }}">
              <input type="text" class="w-3/6" readonly value="{{ $comment->comment }}">
              <input type="text" class="w-1/6" readonly value="{{ $comment->created_at }}">
              <button class="">삭제</button> --}}
            </div>
          </div>
          @endforeach
        @endif
        
      </div>
    </div>
  </div>
</x-app-layout>