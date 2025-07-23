<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'raf',
            'name' => 'Rafael Miano',
            'email' => 'rafael@miano.com',
        ]);

        $categories = [
            'ReactJS',
            'VueJS',
            'C#',
            'Flutter',
            'Laravel',
            'Angular',
            'NodeJS',
            'Python',
            'Django',
            'JavaScript',
            'TypeScript',
            'PHP',
            'Java',
            'Spring Boot',
            'Express.js',
            'Next.js',
            'Svelte',
            'Ruby on Rails',
            'ASP.NET Core',
            'FastAPI',
            'Kotlin',
            'Swift',
            'React Native',
            'MongoDB',
            'PostgreSQL',
            'MySQL',
        ];

        foreach ($categories as $key => $category) {
            Category::create([
                'name' => $category,
            ]);
        }

        // Post::factory(100)->create();
    }
}
