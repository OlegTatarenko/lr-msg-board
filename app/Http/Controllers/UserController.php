<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //показывает форму регистрации
    public function create()
    {
        return view('user.create');
    }

    //получает, валидирует и записывает данные пользователя в БД
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        //массово записываем валидные данные пользователя в базу, записываемые поля указаны в модели User в свойстве $fillable
        //при записи в базу пароль хешируется, это прописано в методе cast модели User
        $user = User::create($request->all());

        //сразу же аутентифицируем юзера, чтобы ему не вводить данные в форму login
        Auth::login($user);

        //редирект на страницу dashboard и запись в сессию с пом-ю with() флеш-сообщения, которое выведем на странице логин в качестве подтверждения успешной регистрации
        return redirect()->route('post.create')->with('success', 'Вы успешно зарегистрированы!');
    }


    //показывает форму login
    public function login()
    {
        return view('user.login');
    }

    //авторизует ранее зарег-го пользователя
    public function loginAuth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //Если аутентификация пройдена, то делаем редирект туда, куда он изначально направлялся - intended, записываем флеш-сообщение
        //вторым параметром передаем значение чек-бокса remember, чтобы запомнить пользователя после залогинивания
        if (Auth::attempt($credentials, $request->boolean('remember'))){
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Привет, ' . Auth::user()->name . '!');
        }

        //если аутентификация не пройдена, то редирект назад с сообщением об ошибке
        return back()->withErrors([
            'email' => 'Неверный пароль или email',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Вы вышли из аккаунта!');
    }

    public function profile()
    {
        return view('user.profile');
    }
}
