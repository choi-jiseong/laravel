<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Post') }}
      </h2>
  </x-slot>
  <button class="flex justify-between sm:mt-2 mx-auto z-10 bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-3xl p-4 m-4" onclick=location.href="{{ $in == 1 ? route('posts.index', ['page'=>$page]) : route('posts.myIndex', ['page'=>$page])}}">목록보기</button>
  <div class="flex justify-between sm:mt-2 max-w-5xl w-full mx-auto z-10">
    <div class="container m-3 bg-white rounded-3xl p-3">

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
              <input type="text" readonly class="w-full rounded-3xl border-2 border-gray-200 mb-2" value="{{ $post->user->name }}">
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
              @endcan
              {{-- <button onclick=location.href="{{ route('posts.like', ['id'=>$post->id, 'page'=>$page, 'in'=>$in]) }}" class="flex justify-between z-10 bg-red-600 border  shadow-lg text-white font-bold  rounded-2xl p-2 m-2" >like {{ $post->likes_viewers()->count() }}</button> --}}
              <button
                onclick=location.href="{{ route('posts.like', ['id'=>$post->id, 'page'=>$page, 'in'=>$in]) }}"
                class="text-white px-4 w-auto h-10 bg-red-600 rounded-full hover:bg-red-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
          <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20" class="w-7 h-7 inline-block mr-1">
            @if ($check == true)
              <path fill="#F432FF" d="M17.19,4.155c-1.672-1.534-4.383-1.534-6.055,0L10,5.197L8.864,4.155c-1.672-1.534-4.382-1.534-6.054,0
            c-1.881,1.727-1.881,4.52,0,6.246L10,17l7.19-6.599C19.07,8.675,19.07,5.881,17.19,4.155z"/>
            @else
              <path fill="#FFFFFF" d="M17.19,4.155c-1.672-1.534-4.383-1.534-6.055,0L10,5.197L8.864,4.155c-1.672-1.534-4.382-1.534-6.054,0
                                    c-1.881,1.727-1.881,4.52,0,6.246L10,17l7.19-6.599C19.07,8.675,19.07,5.881,17.19,4.155z"/>
            @endif 
          </svg>
          <span>{{ $post->likes_viewers()->count() }}</span>
        </button>
            @endauth
    </div>
    {{-- <div class="container m-3 bg-white rounded-3xl p-3">
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
            </div>
          </div>
          @endforeach
        @endif 
      </div> --}}
      <div id="app" class="container m-3 bg-white rounded-3xl p-3">
        <comments user_id="{{ auth()->user()->id }}" user_name = "{{ auth()->user()->name }}" post_id="{{ $post->id }}"></comments>
      </div>

{{-- 

    </div> --}}

  </div>
</x-app-layout>