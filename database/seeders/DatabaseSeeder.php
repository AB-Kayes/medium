<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
        ]);

        $categories = [
            'Technology',
            'Science',
            'Health',
            'Business',
            'Entertainment',
            'Sports',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }

        $posts = [
            [
                'title' => 'Story 01: A Shared Start for DevLog',
                'content' => 'The team kicked off DevLog by wiring up authentication, database tables, and the first layout pass. It already feels like a place where small wins can be recorded together and built into something bigger.',
                'category' => 'Technology',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Story 02: Shaping the Post Workflow',
                'content' => 'We sketched the post creation flow around how developers actually share progress with one another. The goal is to keep the editor fast enough that every contributor can capture a story before it slips away.',
                'category' => 'Business',
                'published_at' => now()->subDays(9),
            ],
            [
                'title' => 'Story 03: Faster Feeds, Clearer Momentum',
                'content' => 'The dashboard queries were tightened so the latest updates appear quickly and the feed stays responsive. That keeps the collective timeline easy to scan as more stories get added.',
                'category' => 'Science',
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Story 04: Giving Each Update a Home',
                'content' => 'Each post now belongs to a category so the timeline has more structure and readers can follow the conversation by topic. The seed data feels closer to a real archive of shared progress.',
                'category' => 'Technology',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Story 05: Media That Supports the Narrative',
                'content' => 'We reviewed the media workflow and made the upload path easier to understand from the contributor side. The app still uses the same image source, but now the surrounding copy reinforces the storytelling feel.',
                'category' => 'Entertainment',
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Story 06: Profiles That Show the People Behind the Code',
                'content' => 'Profile updates and follower relationships now make the app feel more like a living dev journal. Seeing who is active helps each story feel connected to the people writing it.',
                'category' => 'Health',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Story 07: Lightweight Feedback for Every Update',
                'content' => 'The like system was tested across the feed so each interaction stays consistent after refresh. Small feedback loops help a shared space like DevLog feel active and collaborative.',
                'category' => 'Sports',
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Story 08: Reading the Feed Like a Team Journal',
                'content' => 'Spacing, typography, and content length were tuned so posts are easier to read on the page. The result keeps DevLog calm and focused while preserving the rhythm of a collective journal.',
                'category' => 'Technology',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Story 09: Making Old Notes Easy to Find',
                'content' => 'Search and filtering were planned so older updates remain useful instead of getting buried. A collective coding story should be easy to revisit when the team wants to trace how things evolved.',
                'category' => 'Business',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Story 10: Closing the Week with Shared Notes',
                'content' => 'The week wrapped with a review of the deployment checklist, seed data, and content quality. DevLog now has a solid set of sample posts that make the feed feel lived in and team-driven.',
                'category' => 'Science',
                'published_at' => now()->subDay(),
            ],
        ];

        foreach ($posts as $postData) {
            Post::factory()->create([
                'title' => $postData['title'],
                'content' => $postData['content'],
                'category_id' => Category::where('name', $postData['category'])->value('id'),
                'published_at' => $postData['published_at'],
            ]);
        }
    }
}
