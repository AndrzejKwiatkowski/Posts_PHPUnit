<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class PostsTest extends TestCase
{
      use RefreshDatabase;
      /** @test */
      public function the_posts_show_route_can_be_accessed()
      {
            $this->withoutExceptionHandling();
            // Arrange
            // Dodajemy do bazy danych wpis
            $post = factory(Post::class)->create([
                  'title' => 'Wrabiał krowe w morderstwo Cioci']);

            // Act
            // Wykonujemy zapytanie pod adres wpisu
            $response = $this->get('posts/' . $post->id);

            // Assert
            // Sprawdzamy że w odpowiedzi znajduje się tytuł wpisu

            $response->assertStatus(200)
                  ->assertSeeText('Wrabiał krowe w morderstwo Cioci');
      }




      /** @test */
      public function the_body_attribute_is_shown_on_the_posts_show_view()
      {
            //$this->withoutExceptionHandling();
            $post = factory(Post::class)->create([
                  
                  'body' => 'Mroczna tajemnica mordu w oborze długo spędzała sen z oczu policjantom z Lublina. Kto zabił 88-letnią kobietę i jej krowę?',
            ]);

            $response = $this->get('/posts/' . $post->id);

            $response->assertSeeText('Mroczna tajemnica mordu w oborze długo spędzała sen z oczu policjantom z Lublina. Kto zabił 88-letnią kobietę i jej krowę?');
      }

      // tests/Feature/PostsTest.php



/** @test */
public function only_published_posts_are_shown_on_the_posts_index_view()
{
      $this->withoutExceptionHandling();
    $publishedPost = factory(Post::class)->create([
        'published_at' => Carbon::yesterday(),
    ]);

    $unpublishedPost = factory(Post::class)->create([
        'published_at' => Carbon::tomorrow(),
    ]);

    $response = $this->get('/posts');

    $response->assertStatus(200)
        ->assertSeeText($publishedPost->title)
        ->assertDontSeeText($unpublishedPost->title);
}

/** @test */

public function a_post_can_be_created()
{
      //$this->withoutExceptionHandling();
    $user = factory(User::class)->create();

    $this->actingAs($user)->post('/posts', [
        'published_at' => '2019-11-19 12:00:00',
        'title' => 'Odebrał żelazko zamiast telefonu',
        'body' => 'Miał pomóc żonie, a skończyło się tragedią.',
    ]);

    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        'published_at' => '2019-11-19 12:00:00',
        'title' => 'Odebrał żelazko zamiast telefonu',
        'body' => 'Miał pomóc żonie, a skończyło się tragedią.',
    ]);
}
/** @test */
public function guests_cannot_create_posts()
{
    $response = $this->post('/posts', []);

    $response->assertRedirect('/login');
}

}