<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>
    <div class="container m-10">
        <h1>게시글 리스트</h1>
        <div>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
        @auth 
            <a href="{{ route('posts.create', ['in'=>$in]) }}" class="btn btn-primary">게시글 작성</a>
          @endauth
        </div>
        <ul class="list-group mt-3">
            @foreach($posts as $post)
            <li class="list-group-item">
                <span>
                    <a href="{{ route('posts.show', ['id'=>$post->id, 'page'=>$posts->currentPage(), 'in'=>$in]) }}"> 
                    Title : {{ $post->title }}
                </a>
                </span><br>
                {{-- <div>
                    Content : {{ $post->content }}
                </div> --}}
                <span>작성자 : {{ $post->user->name }}</span><br>
                <span>written on {{ $post->created_at->diffForHumans() }}</span><br>
                {{-- <span>조회수 : {{ $post->count }}</span> --}}
                <span>{{ $post->viewers()->count() }} {{ $post->viewers()->count() > 0 ? Str::plural('view', $post->viewers()->count()) : 'view' }}</span>
            </li>
            @endforeach
          </ul>
          <div class="mt-5">
              {{ $posts->links() }}
          </div>
          
    </div>
</x-app-layout>