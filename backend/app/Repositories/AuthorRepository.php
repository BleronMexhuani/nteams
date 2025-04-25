<?php

namespace App\Repositories;

use App\Models\Authors;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Authors::filter(request()->all())->paginate($perPage)->withQueryString();
    }

    public function findOrFail(int $id): Authors
    {
        return Authors::with('books')->findOrFail($id);
    }

    public function create(array $data): Authors
    {
        return Authors::create($data);
    }

    public function update(int $id, array $data): Authors
    {
        $author = $this->findOrFail($id);
        $author->update($data);
        return $author->fresh();
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function search(string $query): LengthAwarePaginator
    {
        return Authors::filter(['search' => $query])->paginate(config('pagination.default_per_page'))->withQueryString();
    }
}
