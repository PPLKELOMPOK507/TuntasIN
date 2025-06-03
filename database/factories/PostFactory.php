<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(), // pastikan CategoryFactory ada, atau isi manual id kategori
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            // tambahkan field lain kalau tabel post kamu ada field wajib lainnya
        ];
    }
}