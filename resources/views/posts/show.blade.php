<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <style>
      .form-group{
        margin-top: 10px;
      }
    </style>
</head>
<body>
    <div class="container mt-5">
      
      {{-- @if ($in == 1) --}}
        <button class="btn btn-primary" onclick=location.href="{{ $in == 1 ? route('posts.index', ['page'=>$page]) : route('posts.myIndex', ['page'=>$page])}}">목록보기</button>
      {{-- @else --}}
        {{-- <button class="btn btn-primary" onclick=location.href="{{ route('posts.myIndex', ['page'=>$page]) }}">목록보기</button> --}}
      {{-- @endif --}}
            <div class="form-group">
              <label>Title</label>
              <input type="text" readonly name="title" class="form-control" id="title" value="{{ $post->title }}">
            </div>

            <div class="form-group">
              <label for="content">Content</label>
              <div class="form-control" readonly name="content" id="content">{!! $post->content !!}</div>
            </div>

            <div class="form-group">
              <label for="image">Post Image</label>
              <div>
                {{-- <img class="img-thumbnail w-25" src="/storage/images/{{ $post->image ?? 'no_image_available.png'}}"> --}}
                <img class="img-thumbnail w-25" src="{{ $post->imagePath() }}">
              </div>
            </div>

            <div class="form-group">
              <label>등록일</label>
              <input type="text" readonly class="form-control"value="{{ $post->created_at }}">
            </div>

            <div class="form-group">
              <label>수정일</label>
              <input type="text" readonly class="form-control"value="{{ $post->updated_at }}">
            </div>

            <div class="form-group">
              <label>작성자</label>
              <input type="text" readonly class="form-control"value="{{ $post->user->name }}">
            </div>
            @auth   {{-- 로그인을 안했을 때 삭제, 수정 불가능 --}}
              {{-- @if($post->user_id == auth()->user()->id) --}}
              @can('update', $post)
                <div class="flex mt-3">
                  <table>
                    <tr>
                      <td>
                        <button class="btn btn-warning" onclick=location.href="{{ route('posts.edit', ['post'=>$post->id, 'page'=>$page, 'in'=>$in]) }}">수정</button>
                      </td>
                      <td>
                        <form action="{{ route('posts.delete', ['id'=>$post->id, 'page'=>$page, 'in'=>$in]) }}" method="post">
                          @csrf
                          @method("delete")
                          <button type="submit" class="btn btn-danger">삭제</button>
                        </form>
                      </td>
                    </tr>
                  </table>
                </div>
              {{-- @endif --}}
              @endcan
            @endauth
    </div>
</body>
</html>