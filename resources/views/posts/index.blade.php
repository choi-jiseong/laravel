<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="flex flex-col items-center justify-center min-h-screen bg-center bg-cover" >

        <div class="m-10">
            <table>
                <tr>
                    <td>
                        @auth 
                         <a href="{{ route('posts.create', ['in'=>$in]) }}" class="bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-3xl p-4 m-4">게시글 작성</a>
                        @endauth
                    </td>
                    <td>
                        <form action="{{ route('posts.search', ['in'=>$in]) }}" method="get">
                            {{-- @csrf --}}
                            <input type="text" id="search" name="search" placeholder="title" class="rounded-3xl p-4 ml-4">
                            <button type="submit" class="bg-gray-900 border border-gray-900 shadow-lg text-gray-200 font-bold  rounded-3xl p-4 m-4">검색</button>
                        </form>
                    </td>
                </tr>
            </table>
        
          
        </div>

        <!-- dark theme -->
        @foreach($posts as $post)
        <div class="max-w-3xl w-full mx-auto z-10">
            <div class="flex flex-col">
                <div class="bg-gray-900 border border-gray-900 shadow-lg  rounded-3xl p-4 m-4">
                    <div class="flex-none sm:flex">
                        <div class=" relative h-32 w-32   sm:mb-0 mb-3">
                            <img src="{{ $post->imagePath() }}" alt="aji" class=" w-32 h-32 object-cover rounded-2xl">
                            
                        </div>
                        <div class="flex-auto sm:ml-5 justify-evenly">
                            <div class="flex items-center justify-between sm:mt-2">
                                <div class="flex items-center">
                                    <div class="flex flex-col">
                                        <div class="w-full flex-none text-lg text-gray-200 font-bold leading-none">{{ $post->title }}</div>
                                        <div class="flex-auto text-gray-400 my-1">
                                            <span class="mr-3 ">{{ $post->user->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-row items-center">
                                </div>
                                <div class="flex pt-2  text-sm text-gray-400 mt-3">
                                    <div class="flex-1 inline-flex items-center">          
                                        <p class="">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex-1 inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                                clip-rule="evenodd"></path>
                                        </svg>

                                        <p class="">{{ $post->viewers()->count() }} {{ $post->viewers()->count() > 0 ? Str::plural('view', $post->viewers()->count()) : 'view' }}</p>
                                    </div>
                                    <button  class="flex-no-shrink bg-green-400 hover:bg-green-500 px-5 ml-4 py-2 text-xs shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300" onclick=location.href="{{ route('posts.show', ['id'=>$post->id, 'page'=>$posts->currentPage(), 'in'=>$in]) }}">CLICK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="mt-5">
                {{ $posts->withQueryString()->links() }}
            </div>
        </div>
    
</x-app-layout>