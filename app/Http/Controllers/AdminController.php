<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showPosts()
    {
        $posts = Post::paginate(5);
        return view('admin.showPosts', ['posts' => $posts]);
    }

    //публикация объявления админом
    public function publish($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 1;
        $post->save();
        return redirect()->back();
    }

    //админ убирает объявление из публикации
    public function removeFromPublication($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 0;
        $post->save();
        return redirect()->back();
    }

    //меняет статус объявления
    public function changePostStatus($id)
    {
        $post = Post::findOrFail($id);

        if ($post->status == 0) {
            $post->status = 1;
            $post->save();
            return redirect()->back();
        }

        $post->status = 0;
        $post->save();
        return redirect()->back();
    }



    public function showUsers()
    {
        $users = User::paginate(3);
        return view('admin.showUsers', ['users' => $users]);
    }

    //меняет статус пользователя
    public function changeRole($id)
    {
        $user = User::findOrFail($id);
        $user_role = $user->role->name;

        if ($user_role == 'user') {
            $user->role_id = 2;
            $user->save();
            return redirect()->back();
        }

        $user->role_id = 1;
        $user->save();
        return redirect()->back();
    }

    //меняет статус бана
    public function changeBanStatus($id)
    {
        $user = User::findOrFail($id);
        $ban_status = $user->ban->status;

        if ($ban_status == 'notban') {
            $user->ban_id = 2;
            $user->save();
            return redirect()->back();
        }

        $user->ban_id = 1;
        $user->save();
        return redirect()->back();
    }
}
