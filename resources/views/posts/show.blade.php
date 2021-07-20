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
      <div class="form-group">
        <label class="text-xl font-bold w-full">댓글</label>
        <input type="text" class="ml-4 w-4/6 rounded-3xl border-2 border-gray-200">
        <button class="bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-2xl p-2 m-2">등록</button>
      </div>
    </div>
  </div>
</x-app-layout>