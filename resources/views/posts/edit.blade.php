<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
        <form action="{{ route('posts.update', ['id'=>$post->id, 'page'=>$page]) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method("put") {{-- 밑에 내용을 만들어준다 --}}
          {{-- method spoofing --}}
          {{-- <input type="hidden" name="_method" value="put"> --}}
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" name="title" class="form-control" id="title" value="{{ old('title') ? old('title') : $post->title }}">
                @error('title')
                    <div>{{ $message }}</div>
                @enderror
              
            </div>
            <div class="form-group">
              <label for="content">Content</label>
              <textarea class="form-control" name="content" id="content">{{ old('content') ? old('content') : $post->content }}</textarea>
                @error('content')
                    <div>{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Image</label><br>
                <img src="{{ $post->imagePath() }}" class="img-thumbnail" width="20%">
            </div>
            <div class="form-group">
                <label for="file">File</label><br>
                <input class="form-control" type="file" id="file" name="imageFile">
                @error('imageFile')
                    <div>{{ $message }}</div>
                @enderror
              </div><br>
            <button type="submit" class="btn btn-primary">수정하기</button>
        </form>
    </div>
    
    
</body>
</html>