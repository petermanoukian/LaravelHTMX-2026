<?php

namespace App\Services;

use App\Repositories\CatRepository;
use App\Models\Cat;

class CatService
{
    protected $repo;

    public function __construct(CatRepository $repo)
    {
        $this->repo = $repo;
    }

    // Get all records
    public function all(array $filters = [], string $orderBy = 'id', string $direction = 'desc', array $with = [])
    {
        return $this->repo->all($filters, $orderBy, $direction, $with);
    }

    // Paginated list
    public function paginated(array $filters = [], string $orderBy = 'id', string $direction = 'desc', array $with = [], int $perPage = 15)
    {
        return $this->repo->paginated($filters, $orderBy, $direction, $with, $perPage);
    }

    // Find by ID
    public function findId(int $id, array $with = [])
    {
        return $this->repo->findId($id, $with);
    }

    // Find by condition
    public function findBy(string $field, $value, array $with = [])
    {
        return $this->repo->findBy($field, $value, $with);
    }

    public function existsBy(string $field, $value): bool
    {
        return $this->repo->existsBy($field, $value);
    }

    public function existsByExceptId(string $field, $value, int $id): bool
    {
        return $this->repo->existsByExceptId($field, $value, $id);
    }

    

    // Store new record
    public function store(array $data)
    {
        return $this->repo->store($data);
    }

    // Update existing record
    public function update(Cat $cat, array $data)
    {
        return $this->repo->update($cat, $data);
    }

    // Delete single record
    public function delete(Cat $cat)
    {
        return $this->repo->delete($cat);
    }

    // Delete all records (with filters)
    public function deleteAll(array $filters)
    {
        return $this->repo->deleteAll($filters);
    }
}
