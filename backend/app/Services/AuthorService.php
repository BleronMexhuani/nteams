<?php

namespace App\Services;

use App\Repositories\Interfaces\AuthorRepositoryInterface;

class AuthorService
{
    public function __construct(private AuthorRepositoryInterface $repository) {}

    public function all($perPage = 15)
    {
        return $this->repository->getAllPaginated($perPage);
    }

    public function find($id)
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        $this->repository->delete($id);
    }

    public function search($query)
    {
        return $this->repository->search($query);
    }
}
