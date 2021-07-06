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
        
            <div class="form-group">
              <label>Title</label>
              <input type="text" readonly name="title" class="form-control" id="title" value="{{ $post->title }}">
            </div>

            <div class="form-group">
              <label for="content">Content</label>
              <textarea class="form-control" readonly name="content" id="content">{{ $post->content }}</textarea>
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
              <input type="text" readonly class="form-control"value="{{ $post->user_id }}">
            </div>
            <div class="mt-3">
                <a href="{{ route('posts.index', ['page'=>$page]) }}" class="btn btn-primary">목록보기</a>
                <a href="{{ route('posts.edit') }}" class="btn btn-primary">수정하기</a>
            </div>
    </div>
</body>
</html>