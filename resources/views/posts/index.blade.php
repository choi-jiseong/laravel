<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5 mb-5">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <h1>게시글 리스트</h1>
        @auth 
            <a href="/posts/create" class="btn btn-primary">게시글 작성</a>
        @endauth
        <ul class="list-group mt-3">
            @foreach($posts as $post)
            <li class="list-group-item">
                <span>
                    <a href="{{ route('posts.show', ['id'=>$post->id, 'page'=>$posts->currentPage()]) }}"> 
                    Title : {{ $post->title}}
                </a>
                </span><br>
                {{-- <div>
                    Content : {{ $post->content }}
                </div> --}}
                <span>written on {{ $post->created_at->diffForHumans() }}</span>
            </li>
            @endforeach
          </ul>
          <div class="mt-5">
              {{ $posts->links() }}
          </div>
    </div>
    
</body>
</html>