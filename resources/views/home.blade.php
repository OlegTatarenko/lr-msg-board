<x-layouts.main>
    <x-slot:title>
        Объявления
    </x-slot>

    <div class="container" style="text-align: center;">
        <h2>Объявления</h2>
    </div>

    @foreach($posts as $post)
        <div class="card mx-auto" style="width: 60rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->subcategory->category->name }}</h5>
                    <h6 class="card-title">{{ $post->subcategory->name }}</h6>
                    <h7 class="card-subtitle mb-2 text-body-secondary">Контакт: {{ $post->user->name }}</h7>
                    <h7 class="card-subtitle mb-2 text-body-secondary"></h7>
                    <p class="card-text">{{ $post->content }}</p>
                </div>
        </div>
    @endforeach


    <div class="col-md-6 offset-md-3 ">
        {{ $posts->links() }}
    </div>

</x-layouts.main>
