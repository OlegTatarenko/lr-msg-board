<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\Category;
use App\Models\Post;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Builder;

class HomeController extends Controller
{
    public function home()
    {
        //выбираем из таблицы bans только запись notban
        $not_ban = Ban::where('status', '=', 'notban')->get();

        //загрузить только тех юзеров, у которых нет бана
        $users = User::whereBelongsTo($not_ban)->get();

        //загрузить только посты опубликованные админом (со статусом 1) тех юзеров, у которых нет бана, посты отсортировать по подкатегориям
        //c жадной загрузкой  with('user') для сокращения числа запросов в БД
        $posts = Post::with('user')->whereBelongsTo($users)->where('status', '=', 1)->orderBy('subcategory_id')->paginate(3);

        return view('home', compact('posts'));
    }

    //метод для реализации зависимого выпадающего списка подкатегорий
    public function subcategory($id)
    {
        $subcategories = Subcategory::
        where('category_id', $id)
            ->pluck('name', 'id');
        return json_encode($subcategories);
    }
}
