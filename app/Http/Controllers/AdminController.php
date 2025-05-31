<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Удаляем конструктор с middleware
    // public function __construct()
    // {
    //     $this->middleware('auth:admin');
    // }

    public function products()
    {
        $drinks = Drink::all();
        return view('admin.products', compact('drinks'));
    }

// получаем все напитки из бд и возвращаем представление, 
// передавая туда список напитков

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

// получаем всех юзеров из бд и возвращаем представление, 
// передавая туда список юзеров

    public function createProduct()
    {
        return view('admin.create-product');
    }

// возвращаем форму для создания нового продукта

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'volumes' => 'required|array',
            'volumes.*' => 'required|string',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',
            'is_hit' => 'boolean',
            'is_new' => 'boolean',
            'is_discount' => 'boolean',
        ]);

//валидируем входные данные
//name - обязательное строковое поле (макс. 255 символов)
//description - обязательное строковое поле (описание напитка)
//image - обязательное изображение (jpeg,png,jpg,gif) (макс. 2MB)
//volumes - массив строк (объёмы напитка)
//prices - массив чисел (цены для соответствующих объёмов)
//Флаги is_hit, is_new, is_discount - необязательные булевы значения
// флаги типа евляется/не является (хит, новинка, выгдно)


        $imagePath = $request->file('image')->store('drinks', 'public');

//сохраняем картинку в папку с изображениями

        Drink::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'volumes' => $request->volumes,
            'prices' => $request->prices,
            'is_hit' => $request->has('is_hit'),
            'is_new' => $request->has('is_new'),
            'is_discount' => $request->has('is_discount'),
        ]);

        return redirect()->route('admin.products')->with('success', 'Напиток успешно добавлен');
    }

//создаем новую запись напитка в бд и возвращаемся обратно к таблице 

    public function editProduct($id)
    {
        $drink = Drink::findOrFail($id);
        return view('admin.edit-product', compact('drink'));
    }

//находим напиток и возвращаем форму редактирования напитка

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'volumes' => 'required|array',
            'volumes.*' => 'required|string',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0',
            'is_hit' => 'boolean',
            'is_new' => 'boolean',
            'is_discount' => 'boolean',
        ]);

        $drink = Drink::findOrFail($id);

// такая же валидация, но "'image' => 'nullable" необязательно менять
//и находим существующий напиток для обновления данных

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'volumes' => $request->volumes,
            'prices' => $request->prices,
            'is_hit' => $request->has('is_hit'),
            'is_new' => $request->has('is_new'),
            'is_discount' => $request->has('is_discount'),
        ];

        if ($request->hasFile('image')) {
            // удвляем старую картинку
            if ($drink->image) {
                Storage::disk('public')->delete($drink->image);
            }
            
            $imagePath = $request->file('image')->store('drinks', 'public');
            $data['image'] = $imagePath;
        }

//подготавливаем данные для обновления обозначая че куда
//если есть картинка то удаляем старую, сохраняем новую
//пишем путь к новой картинке чтобы обновился

        $drink->update($data);

        return redirect()->route('admin.products')->with('success', 'Напиток успешно обновлен');
    }

//обновляем че написали и возвращяемся туда где были 

    public function deleteProduct($id)
    {
        $drink = Drink::findOrFail($id);
        
        // удаляем картинку
        if ($drink->image) {
            Storage::disk('public')->delete($drink->image);
        }
        
        $drink->delete();

        return redirect()->route('admin.products')->with('success', 'Напиток успешно удален');
    }

//находим напиток по id, удаляем картинку, удаляем запись из бд,
//возвращаемся где были

    public function createUser()
    {
        return view('admin.create-user');
    }

//возвращаем форму для создания нового пользователя

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

//валидируем данные нового пользователя 
// имя обязятельно строкой максимум 255
// номер обязательно строкой уникально для таблицы
// почту обязательно как почту с @ и тд уникально для таблицы
// пароль обязательно строкой минимум 8

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'Пользователь успешно добавлен');
    }
}

// создаем запись в таблице юзеров
// имя, номер и почта прям из запроса, а пароль хешируем
// возвращаяемся где были и радуемся
// 
