<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

//если пользователь вошел в систему, он не попадет на эти маршруты, а перенаправляется на /home или /dashboard
Route::middleware('guest')->group(function (){

    //маршрут с формой регистрации пользователя
    Route::get('register', [UserController::class, 'create'])->name('user.register');
    //маршрут, получающий данные из формы регистрации
    Route::post('register', [UserController::class, 'store'])->name('user.store');

    //маршрут для страницы с формой для входа в учетную запись
    Route::get('login', [UserController::class, 'login'])->name('login');
    //маршрут, получающий данные из формы входа в учетную запись
    Route::post('login', [UserController::class, 'loginAuth'])->name('login.auth');

});
// Только аутентифицированные пользователи могут получить доступ к этим маршрутам
//Когда посредник auth обнаруживает неаутентифицированного пользователя, он перенаправляет пользователя на именованный маршрут login.
// Можно изменить это поведение, обновив функцию redirectTo в файле app/Http/Middleware/Authenticate.php вашего приложения
Route::middleware('auth')->group(function (){

    //маршруты для формы создания объявления
    Route::get('post', [PostController::class, 'create'])->name('post.create');
    //для реализации зависимого выпадающего списка
    Route::get('subcategory/{id}', [PostController::class, 'subcategory'])->name('subcategory');

    //маршрут, получающий данные из формы с новым объявлением
    Route::post('post', [PostController::class, 'store'])->name('post.store');

    Route::get('profile', [UserController::class, 'profile'])->name('profile');

    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});


Route::middleware([Admin::class])->group(function (){

    //маршрут админ панели - весь список объявлений
    Route::get('admin/show-posts', [AdminController::class, 'showPosts'])->name('admin.showPosts');

    //маршрут для изменения статуса объявления
    Route::get('admin/change-post-status/{id}', [AdminController::class, 'changePostStatus'])->name('admin.changePostStatus');

    //маршрут админ панели - все пользователи
    Route::get('admin/show-users', [AdminController::class, 'showUsers'])->name('admin.showUsers');

    //маршрут для изменения статуса пользователя - user/admin
    Route::get('admin/change-role/{id}', [AdminController::class, 'changeRole'])->name('admin.changeRole');

    //маршрут для изменения статуса бана пользователя - ban/notban
    Route::get('admin/change-ban/{id}', [AdminController::class, 'changeBanStatus'])->name('admin.changeBanStatus');
});
