<div>
    @if($posts->count())

        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div class="post-container">
                    <a href="{{route('posts.show', ['post'=>$post, 'user'=> $post->user])}}">
                        <img class="post-image" src="{{asset('uploads') .'/'. $post->imagen}}" alt="Imagen del post {{$post->titulo}}">
                    </a>
                </div>
            @endforeach
        </div>

    <div class="my-10">
        {{$posts->links()}}
    </div>

    @else
        <p class="text-center">No hay Posts, sigue a alguien para poder mostrar sus posts</p>
    @endif
</div>

<style>
    .post-container {
        width: 358px; 
        height: 358px; 
        position: relative; 
        overflow: hidden; 
    }
    
    .post-image {
        width: 100%; 
        height: 100%; 
        transition: transform 0.3s ease, opacity 0.3s ease;
        object-fit: cover; 
        position: absolute; 
        top: 0;
        left: 0;
    }
    
    .post-container:hover .post-image {
        transform: scale(1.05); 
        opacity: 0.6; 
    }
</style>