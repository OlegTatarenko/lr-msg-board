<x-layouts.main>
    <x-slot:title>
        Админ панель
    </x-slot>

    <div class="container" style="text-align: center;">
        <h2>Все объявления</h2>
    </div>

    <div class="row">


        <div class="col-md-6 offset-md-1">


            <table class="table col-md-15">

                <tr>
                    <th>ID</th>
                    <th>Объявление</th>
                    <th>Категория</th>
                    <th>Подкатегория</th>
                    <th>Статус объявления</th>
                    <th>Автор объявления</th>
                    <th>Статус автора</th>
                </tr>

                @foreach($posts as $post)
                    @php
                        if($post->status == 1) $status = 'публикуется'; else $status = 'не публикуется';
                    @endphp
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->content }}</td>
                        <td>{{ $post->subcategory->category->name }}</td>
                        <td>{{ $post->subcategory->name }}</td>
                        <td><a href="{{ route('admin.changePostStatus', ['id' => $post->id]) }}">{{ $status }}</a></td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->user->ban->status }}</td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
    <div class="col-md-6 offset-md-3">
        {{ $posts->links() }}
    </div>


</x-layouts.main>
