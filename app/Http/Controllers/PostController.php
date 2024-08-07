<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //показывает форму создания объявления
    public function create()
    {
        $categories = Category::all()->pluck('name', 'id');
        return view('post.create', compact('categories'));
    }

    //метод для реализации зависимого выпадающего списка подкатегорий
    public function subcategory($id)
    {
        $subcategories = Subcategory::
            where('category_id', $id)
            ->pluck('name', 'id');
        return json_encode($subcategories);
    }

    public function store(Request $request)
    {
        request()->validate([
            'category' => 'required',
            'subcategory' => 'required',
            'content' => 'required|string',
        ]);

        //создаем новый пост с полученными из формы данными
        $post = new Post([
            'subcategory_id' => request('subcategory'),
            'content' => request('content'),
        ]);

        //получаем текущего юзера по его id через Auth
        $user = User::find(Auth::id());

        //записываем пост в БД, используя метод отношения save, таким образом в user_id таблицы post автоматом запишется id юзера
        $user->posts()->save($post);

        //редирект на страницу home и запись в сессию с пом-ю with() флеш-сообщения
        return redirect()->route('home')->with('success', 'Ваше объявление будет опубликовано после проверки!');
    }
}
