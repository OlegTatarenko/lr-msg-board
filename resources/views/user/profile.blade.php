<x-layouts.main>
    <x-slot:title>
        Профиль
    </x-slot>


    <div class="container" style="text-align: center;">
        <h2>Ваш профиль</h2>
    </div>

   <div class="col-md-6 offset-md-3">

       <h3>Имя: {{ Auth::user()->name }}</h3>
{{--       <h3>Количество объявлений: {{ Auth::user()->post->count('id') }}</h3>--}}
       <h3>Роль: {{ Auth::user()->role->name }}</h3>

   </div>


</x-layouts.main>



