<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PetCategory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём пользователей
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Volunteer',
            'email' => 'volunteer@volunteer.com',
            'password' => bcrypt('password'),
            'role' => 'volunteer',
            'volunteer_start_date' => now(),
            'is_active' => true,
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'role' => 'adopter',
        ]);

        // Создаём категории питомцев
        $categories = ['Собаки', 'Кошки', 'Грызуны', 'Птицы', 'Рептилии'];
        foreach ($categories as $category) {
            PetCategory::create([
                'name' => $category,
                'slug' => strtolower($category),
                'description' => "Описание категории {$category}",
            ]);
        }
    }
}
