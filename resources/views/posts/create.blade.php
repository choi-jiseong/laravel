<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('write') }}
      </h2>
  </x-slot>
    <div class="container flex justify-between sm:mt-2 max-w-5xl w-full mx-auto z-10 m-3 bg-white rounded-3xl p-3">
        <form action="{{ route('posts.store', ['in'=>$in]) }}" method="post" enctype="multipart/form-data" class="mx-auto my-auto">
          @csrf
            <div class="form-group mb-2">
              <label for="title" class="text-2xl font-bold">Title</label>
              <input type="text" name="title" class="w-full rounded-3xl border-2 border-gray-200" id="title" value="{{ old('title') }}">
                @error('title')
                    <div>{{ $message }}</div>
                @enderror
              
            </div>
            <div class="form-group mb-2">
              <label for="content" class="text-2xl font-bold">Content</label>
              <textarea  name="content" id="content">{{ old('content') }}</textarea>
                @error('content')
                    <div>{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="file" class="text-2xl font-bold">File</label><br>
                <input class="border-gray-300 focus:ring-blue-500 block w-full overflow-hidden cursor-pointer border text-gray-800 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" aria-describedby="view_model_avatar_help" type="file" id="file" name="imageFile">
                @error('imageFile')
                    <div>{{ $message }}</div>
                @enderror
              </div><br>
                <button type="submit" class="sm:mt-2 z-10 bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-3xl p-4">작성하기</button>
        </form>
              {{-- <div>
                <button class="sm:mt-2 z-10 bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-3xl p-4" onclick=location.href="{{ $in == 1 ? route('posts.index', ['page'=>$page]) : route('posts.myIndex', ['page'=>$page])}}">목록보기</button>
              </div> --}}
    </div>

    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'content' );
    </script>
</x-app-layout>