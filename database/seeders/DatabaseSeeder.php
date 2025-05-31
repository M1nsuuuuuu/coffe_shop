<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administrator;
use App\Models\User;
use App\Models\Drink;
use App\Models\Favorite;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Administrator
        Administrator::create([
            'email' => 'cofeshop2505525@mail.com',
            'password' => Hash::make('qqwerty7890'),
        ]);

        // Create Users
        $user1 = User::create([
            'name' => 'Александр',
            'phone' => '+79001234567',
            'email' => 'korotchuk8673@gmail.com',
            'password' => Hash::make('851293271SID'),
        ]);

        $user2 = User::create([
            'name' => 'Никита',
            'phone' => '+79009876543',
            'email' => 'kurashovnikita8517@gmail.com',
            'password' => Hash::make('8235918KSJH'),
        ]);

        // Create Drinks
        $drink1 = Drink::create([
            'name' => 'Флэт Уайт',
            'description' => 'Кофейный напиток на основе двойного эспрессо с добавлением взбитого молока',
            'image' => 'drinks/flat-white.jpg',
            'prices' => [150],
            'volumes' => ['0.2 л'],
            'is_discount' => true,
        ]);

        $drink2 = Drink::create([
            'name' => 'Латте',
            'description' => 'Лёгкий молочно-кофейный напиток на основе нежно взбитого молока с добавлением эспрессо',
            'image' => 'drinks/latte.jpg',
            'prices' => [200, 250, 300],
            'volumes' => ['0.3 л', '0.4 л', '0.5 л'],
        ]);

        $drink3 = Drink::create([
            'name' => 'Американо',
            'description' => 'Классический кофе на основе эспрессо с добавлением воды.',
            'image' => 'drinks/americano.jpg',
            'prices' => [150, 200, 250, 300],
            'volumes' => ['0.2 л', '0.3 л', '0.4 л', '0.5 л'],
        ]);

        $drink4 = Drink::create([
            'name' => 'Капучино',
            'description' => 'Молочный кофейный напиток на основе эспрессо и нежного взбитого молока',
            'image' => 'drinks/cappuccino.jpg',
            'prices' => [150, 200, 250, 300],
            'volumes' => ['0.2 л', '0.3 л', '0.4 л', '0.5 л'],
        ]);

        $drink5 = Drink::create([
            'name' => 'Какао',
            'description' => 'Любимый с детства классический какао со взбитым молоком и воздушной сладкой пастилой «маршмеллоу».',
            'image' => 'drinks/cocoa.jpg',
            'prices' => [250, 300, 350],
            'volumes' => ['0.3 л', '0.4 л', '0.5 л'],
            'is_hit' => true,
        ]);

        $drink6 = Drink::create([
            'name' => 'Матча',
            'description' => 'Культовый японский чай — источник энергии и один из самых популярных суперфудов',
            'image' => 'drinks/matcha.jpg',
            'prices' => [250, 300, 350],
            'volumes' => ['0.3 л', '0.4 л', '0.5 л'],
        ]);

        // Add favorites
        Favorite::create([
            'user_id' => $user1->id,
            'drink_id' => $drink2->id,
        ]);

        Favorite::create([
            'user_id' => $user1->id,
            'drink_id' => $drink4->id,
        ]);
    }
}