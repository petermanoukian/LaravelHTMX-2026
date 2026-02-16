<?php

namespace App\Services;

use App\Repositories\SubcatRepository;
use App\Models\Subcat;

class SubcatService
{
    protected $repo;

    public function __construct(SubcatRepository $repo)
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

    // Existence checks
    public function existsBy(string $field, $value): bool
    {
        return $this->repo->existsBy($field, $value);
    }

    public function existsByExceptId(string $field, $value, int $id): bool
    {
        return $this->repo->existsByExceptId($field, $value, $id);
    }

    // ✅ New: existence checks with catid
    public function existsByWithCat(string $field, $value, string $field2, $value2): bool
    {
        return $this->repo->existsByWithCat($field, $value, $field2, $value2);
    }

    public function existsByWithCatExceptId(string $field, $value, string $field2, $value2, int $id): bool
    {
        return $this->repo->existsByWithCatExceptId($field, $value, $field2, $value2, $id);
    }

    // Store new record
    public function store(array $data)
    {
        return $this->repo->store($data);
    }

    // Update existing record
    public function update(Subcat $subcat, array $data)
    {
        return $this->repo->update($subcat, $data);
    }

    // Delete single record
    public function delete(Subcat $subcat)
    {
        return $this->repo->delete($subcat);
    }

    // Delete all records (with filters)
    public function deleteAll(array $filters)
    {
        return $this->repo->deleteAll($filters);
    }

    // ✅ New: get all subcats by catid with optional filters
    public function allByCat(int $catid, array $filters = [], string $orderBy = 'id', string $direction = 'desc', array $with = [])
    {
        return $this->repo->allByCat($catid, $filters, $orderBy, $direction, $with);
    }

    // ✅ New: paginated subcats by catid with optional filters
    public function paginatedByCat(int $catid, array $filters = [], string $orderBy = 'id', string $direction = 'desc', array $with = [], int $perPage = 15)
    {
        return $this->repo->paginatedByCat($catid, $filters, $orderBy, $direction, $with, $perPage);
    }
}
