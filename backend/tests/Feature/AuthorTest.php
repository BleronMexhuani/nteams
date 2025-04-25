<?php


use App\Models\Authors;
use App\Models\Books;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('can create an author', function () {
    $author = Authors::factory()->create();

 
    expect($author)->toBeInstanceOf(Authors::class)
        ->and($author->name)->not()->toBeEmpty()  
        ->and($author->biography)->not()->toBeEmpty() 
        ->and($author->birthdate->format('Y-m-d'))->not()->toBeEmpty(); 
});

it('can have many books', function () {
    $author = Authors::factory()->create();

    $book1 = Books::factory()->create(['author_id' => $author->id]);
    $book2 = Books::factory()->create(['author_id' => $author->id]);

    expect($author->books)->toHaveCount(2)
        ->and($author->books->first())->toBeInstanceOf(Books::class);
});

it('can update an author', function () {
 
    $author = Authors::factory()->create([
        'name' => 'Old Name',
    ]);


    $response = $this->putJson("/api/authors/{$author->id}", [
        'name' => 'Updated Name',
        'biography' => $author->biography, 
        'birthdate' => $author->birthdate,  
    ]);


    $response->assertOk();

   
    $this->assertDatabaseHas('authors', [
        'id' => $author->id,
        'name' => 'Updated Name',
    ]);
});

it('can delete an author', function () {
    $author = Authors::factory()->create();

    $response = $this->deleteJson("/api/authors/{$author->id}");

    $response->assertNoContent();
    $this->assertDatabaseMissing('authors', ['id' => $author->id]);
});

it('returns an author with their books', function () {
    $author = Authors::factory()->create();
    $books  = Books::factory()->count(3)->create(['author_id' => $author->id]);

    $response = $this->getJson("/api/authors/{$author->id}");

    $response->assertOk();
    $response->assertJsonFragment(['id' => $author->id]);

    foreach ($books as $book) {
        $response->assertJsonFragment(['title' => $book->title]);
    }
});
