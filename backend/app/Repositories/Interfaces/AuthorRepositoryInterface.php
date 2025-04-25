<?php

namespace App\Repositories\Interfaces;

interface AuthorRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15);
    public function findOrFail(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function search(string $query);
}
