<?php

namespace App\Services;

use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\BookCoverException;
use App\Models\Books;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BookService
{
    public function __construct(
        private BookRepositoryInterface $repository,
    ) {}

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getAllPaginated($perPage);
    }

    public function findOrFail(int $id): Books
    {
        try {
            return $this->repository->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Book with id : $id not found .");
        }
    }

    public function create(array $data): Books
    {
        $coverUrl = $this->fetchCoverFromExternalApi($data['isbn']);
        $data['cover_url'] = $coverUrl;

        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Books
    {
        if (isset($data['isbn'])) {
            $coverUrl = $this->fetchCoverFromExternalApi($data['isbn']);
            $data['cover_url'] = $coverUrl;
        }

        return $this->repository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->repository->search($query);
    }

    private function fetchCoverFromExternalApi(string $isbn): string
    {
        $cacheKey = "book_cover_{$isbn}";

        return Cache::remember($cacheKey, 3600, function () use ($isbn) {
            try {
                $response = Http::get("https://covers.openlibrary.org/b/id/{$isbn}-L.jpg");

                if ($response->failed()) {
                    throw new BookCoverException("We didn't find ISBN: $isbn");
                }

                return $response->body();
            } catch (\Exception $e) {
                throw new BookCoverException("An error: " . $e->getMessage());
            }
        });
    }
}
