<?php

namespace Tests\Feature\Livewire\AdminPanel;

use App\Livewire\AdminPanel\PostCreate;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PostCreateTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $nonAdminUser;
    protected array $categories;

    protected function setUp(): void
    {
        parent::setUp();

        Livewire::withoutLazyLoading(); // Disable lazy loading for consistent test behavior

        // Seed roles and permissions for testing
        $this->seed([RoleSeeder::class, PermissionSeeder::class]);

        // Create admin and non-admin users
        $this->adminUser = User::factory()->create(['password' => bcrypt('password')])->assignRole('admin');
        $this->nonAdminUser = User::factory()->create(['password' => bcrypt('password')])->assignRole('user');

        // Create test categories
        $this->categories = Category::factory()->count(3)->create()->toArray();
    }

    /**
     * Test rendering of the post creation page for admin users.
     */
    public function test_it_renders_create_post_page_successfully_for_admin()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->assertStatus(200)
            ->assertSee(__('posts.Create Article'));
    }

    /**
     * Test that non-admin users cannot access the post creation page.
     */
    public function test_it_does_not_render_create_post_page_for_non_admin()
    {
        Livewire::actingAs($this->nonAdminUser)
            ->test(PostCreate::class)
            ->assertStatus(403);
    }

    /**
     * Test validation for required fields when creating a post.
     */
    public function test_it_validates_required_fields()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->set('title', '')
            ->set('content', '')
            ->call('createPost')
            ->assertHasErrors(['title' => 'required', 'content' => 'required']);
    }

    /**
     * Test validation for title length.
     */
    public function test_it_validates_title_length()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->set('title', 'abc') // Less than 5 characters
            ->call('createPost')
            ->assertHasErrors(['title' => 'min']);
    }

    /**
     * Test validation for content length.
     */
    public function test_it_validates_content_length()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->set('content', 'ab') // Less than 3 characters
            ->call('createPost')
            ->assertHasErrors(['content' => 'min']);
    }

    /**
     * Test successful creation of a post.
     */
    public function test_it_creates_post_successfully()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->set('title', 'New Blog Post')
            ->set('content', 'This is the content of the blog post.')
            ->set('selectedCategories', [$this->categories[0]['id'], $this->categories[1]['id']])
            ->set('featured', true)
            ->set('publishNow', false)
            ->call('createPost')
            ->assertHasNoErrors(); // Assuming no errors indicate success

        $this->assertDatabaseHas('posts', [
            'title' => 'New Blog Post',
            'is_featured' => true,
            'is_published' => false,
        ]);

        $post = Post::latest()->first();

        $this->assertDatabaseHas('category_post', [
            'post_id' => $post->id,
            'category_id' => $this->categories[0]['id'],
        ]);
    }

    /**
     * Test respecting scheduled publication date for posts.
     */
    public function test_it_respects_scheduled_publication_date()
    {
        $futureDate = now()->addDays(3)->format('Y-m-d H:i:s');

        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->set('title', 'Scheduled Future Post')
            ->set('content', 'This post will be published in the future.')
            ->set('publishNow', false)
            ->set('publicationDate', $futureDate)
            ->set('selectedCategories', [$this->categories[0]['id'], $this->categories[1]['id']])
            ->assertSet('publishNow', false)
            ->assertSet('publicationDate', $futureDate)
            ->call('createPost')
            ->assertHasNoErrors();

        $post = Post::latest()->first();
        $this->assertEquals(0, $post->is_published);
        $this->assertEquals($futureDate, $post->published_at);
    }

    /**
     * Test creating a featured post.
     */
    public function test_it_can_create_featured_post()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->set('title', 'Featured Post')
            ->set('content', 'This is a featured post.')
            ->set('publishNow', true)
            ->set('featured', true)
            ->set('selectedCategories', [$this->categories[0]['id'], $this->categories[1]['id']])
            ->call('createPost')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('posts', [
            'title' => 'Featured Post',
            'is_featured' => true,
        ]);
    }

    /**
     * Test that a post cannot be created without an author.
     */
    public function test_it_does_not_create_post_without_author()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->set('title', 'Post without Author')
            ->set('content', 'This post should fail due to lack of author.')
            ->call('createPost');

        $this->assertDatabaseMissing('posts', [
            'title' => 'Post without Author',
        ]);
    }

    /**
     * Test selecting and attaching categories to a post.
     */
    public function test_it_can_select_and_attach_categories_to_post()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->set('title', 'Categorized Post')
            ->set('content', 'This post will have multiple categories.')
            ->set('selectedCategories', [$this->categories[0]['id'], $this->categories[1]['id']])
            ->call('createPost');

        $post = Post::latest()->first();
        $this->assertTrue($post->categories()->exists());
    }

    /**
     * Test creating a post when localization is not required.
     */
    public function test_it_creates_post_without_localization()
    {
        config(['services.should_have_localization' => false]);

        Livewire::actingAs($this->adminUser)
            ->test(PostCreate::class)
            ->set('title', 'New Blog Post')
            ->set('content', 'This is the content of the blog post.')
            ->set('selectedCategories', [$this->categories[0]['id'], $this->categories[1]['id']])
            ->set('featured', true)
            ->call('createPost')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('posts', [
            'title' => 'New Blog Post',
            'is_featured' => true,
            'is_published' => true,
        ]);
    }
}
