<?php

use App\Models\Post;
use App\Models\PostMedia;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_can_have_multiple_media_files()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        Membership::create([
            'user_id' => $user->id,
            'plan' => 'basic',
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);
        $this->actingAs($user);

        $imageFile = UploadedFile::fake()->image('test-image.jpg');
        $videoFile = UploadedFile::fake()->create('test-video.mp4', 1024);

        $response = $this->post(route('posts.store'), [
            'title' => 'Test Post with Media',
            'content' => 'This is a test post with multiple media files.',
            'category' => '城市旅行',
            'media' => [$imageFile, $videoFile],
        ]);

        $response->assertRedirect(route('discovery'));
        $response->assertSessionHas('success');

        $post = Post::where('title', 'Test Post with Media')->first();
        $this->assertNotNull($post);

        $this->assertEquals(2, $post->media()->count());

        $media = $post->media()->orderBy('sort_order')->get();
        $this->assertEquals('image', $media[0]->file_type);
        $this->assertEquals('video', $media[1]->file_type);

        Storage::disk('public')->assertExists($media[0]->file_path);
        Storage::disk('public')->assertExists($media[1]->file_path);
    }

    public function test_post_shows_first_image_in_discovery()
    {
        $user = User::factory()->create();

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'Test Post',
            'content' => 'Test content',
            'category' => '城市旅行',
        ]);

        PostMedia::create([
            'post_id' => $post->id,
            'file_path' => 'posts/image1.jpg',
            'file_name' => 'image1.jpg',
            'mime_type' => 'image/jpeg',
            'file_type' => 'image',
            'sort_order' => 0,
        ]);

        PostMedia::create([
            'post_id' => $post->id,
            'file_path' => 'posts/image2.jpg',
            'file_name' => 'image2.jpg',
            'mime_type' => 'image/jpeg',
            'file_type' => 'image',
            'sort_order' => 1,
        ]);

        $post->refresh();

        $this->assertNotNull($post->first_image);
        $this->assertEquals('posts/image1.jpg', $post->first_image->file_path);
    }
}