<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraph(5),
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' => 1,
            'published_at' => fake()->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Post $post): void {
            // Add media using the Flowbite image URL
            $imageUrl = 'https://flowbite.com/docs/images/blog/image-1.jpg';
            
            $post
                ->addMediaFromUrl($imageUrl)
                ->toMediaCollection();
        });
    }
}
