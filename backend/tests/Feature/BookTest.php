<?php

use App\Models\Books;
use App\Models\Authors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('can create a book', function () {
    $author = Authors::factory()->create();
    $book = Books::factory()->create(['author_id' => $author->id]);

    expect($book)->toBeInstanceOf(Books::class)
        ->and($book->title)->toBe($book->title)
        ->and($book->isbn)->toBe($book->isbn)
        ->and($book->author_id)->toBe($author->id);
});

it('can update a book', function () {
    $author = Authors::factory()->create();
    $book = Books::factory()->create(['author_id' => $author->id]);

    $book->update(['title' => 'Updated Title']);

    expect($book->title)->toBe('Updated Title');
});

it('can delete a book', function () {
    $author = Authors::factory()->create();
    $book = Books::factory()->create(['author_id' => $author->id]);

    $book->delete();

    expect(Books::find($book->id))->toBeNull();
});

it('can retrieve a book by id', function () {
    $author = Authors::factory()->create();
    $book = Books::factory()->create(['author_id' => $author->id]);

    $response = $this->getJson("/api/books/{$book->id}");

    $response->assertOk();
    $response->assertJsonFragment(['id' => $book->id]);
    $response->assertJsonFragment(['title' => $book->title]);
});

it('can retrieve an author with their books', function () {
    $author = Authors::factory()->create();
    $books = Books::factory()->count(3)->create(['author_id' => $author->id]);

    $response = $this->getJson("/api/authors/{$author->id}");

    $response->assertOk();
    $response->assertJsonFragment(['id' => $author->id]);
    foreach ($books as $book) {
        $response->assertJsonFragment(['title' => $book->title]);
    }
});
