<x-layouts.main>
    <x-slot:title>
        Админ панель
    </x-slot>

    <div class="container" style="text-align: center;">
        <h2>Все пользователи</h2>
    </div>

    <div class="row">


        <div class="col-md-6 offset-md-3">


            <table class="table col-md-15">

                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Статус бана</th>
                </tr>

                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><a href="{{ route('admin.changeRole', ['id' => $user->id]) }}">{{ $user->role->name }}</a></td>
                        <td><a href="{{ route('admin.changeBanStatus', ['id' => $user->id]) }}">{{ $user->ban->status }}</a></td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
    <div class="col-md-6 offset-md-3">
        {{ $users->links() }}
    </div>

</x-layouts.main>
