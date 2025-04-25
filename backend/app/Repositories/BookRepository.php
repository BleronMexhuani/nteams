<?php

namespace App\Repositories;

use App\Models\Books;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Books::with('author')
            ->filter(request()->all())
            ->orderBy('title')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findOrFail(int $id): Books
    {
        return Books::with('author')->findOrFail($id);
    }

    public function create(array $data): Books
    {
        return Books::create([
            'title' => $data['title'],
            'isbn' => $this->normalizeIsbn($data['isbn']),
            'author_id' => $data['author_id'],
            'description' => $data['description'] ?? null,
            'published_date' => $data['published_date'],
            'cover_url' => $data['cover_url'] ?? null
        ]);
    }

    public function update(int $id, array $data): Books
    {
        $book = $this->findOrFail($id);

        $updateData = [
            'title' => $data['title'] ?? $book->title,
            'author_id' => $data['author_id'] ?? $book->author_id,
            'description' => $data['description'] ?? $book->description,
            'published_date' => $data['published_date'] ?? $book->published_date,
        ];

        if (isset($data['isbn']) && $data['isbn'] !== $book->isbn) {
            $updateData['isbn'] = $this->normalizeIsbn($data['isbn']);
        }

        $book->update($updateData);

        return $book->fresh();
    }

    public function delete(int $id): void
    {
        $book = $this->findOrFail($id);
        $book->delete();
    }

    public function updateCover(int $id, string $url): void
    {
        $book = $this->findOrFail($id);
        $book->update(['cover_url' => $url]);
    }

    public function search(string $query): LengthAwarePaginator
    {
        return Books::with('author')
            ->filter(['search' => $query])
            ->paginate(config('pagination.default_per_page'))
            ->withQueryString();
    }

    private function normalizeIsbn(string $isbn): string
    {
        return strtoupper(preg_replace('/[^0-9X]/', '', $isbn));
    }
}
