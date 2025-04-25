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
        try {
            $cacheKey = "book_cover_{$isbn}";
            $cachedCoverUrl = Cache::get($cacheKey);

            if ($cachedCoverUrl) {
                return $cachedCoverUrl;
            }

            $coverUrl = "https://covers.openlibrary.org/b/id/{$isbn}-L.jpg";

            $response = Http::get($coverUrl);

            if ($response->failed()) {
                throw new BookCoverException("We couldn't find a cover for ISBN: $isbn");
            }

            Cache::put($cacheKey, $coverUrl, now()->addDays(7));

            return $coverUrl;
        } catch (\Exception $e) {
            throw new BookCoverException("An error occurred: " . $e->getMessage());
        }
    }
}
