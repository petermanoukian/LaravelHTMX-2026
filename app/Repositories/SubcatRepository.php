<?php

namespace App\Repositories;

use App\Models\Subcat;

class SubcatRepository
{
    // Get all records, with optional filters, ordering, and relations
    public function all(array $filters = [], string $orderBy = 'id', string $direction = 'desc', array $with = [])
    {
        $query = Subcat::query();

        // ✅ Remove _token and _method from filters
        $filters = array_filter($filters, function($key) {
            return !in_array($key, ['_token', '_method']);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->orderBy($orderBy, $direction)->get();
    }

    // Paginated records
    public function paginated(
        array $filters = [],
        string $orderBy = 'id',
        string $direction = 'desc',
        array $with = [],
        int $perPage = 15
    ) {
        $query = Subcat::query();

        $filters = array_filter($filters, function($key) {
            return !in_array($key, ['_token', '_method']);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                if ($field === 'search') {
                    $query->where(function($q) use ($value) {
                        $q->where('subcats.name', 'like', "%{$value}%")
                        ->orWhere('subcats.id', $value)
                        // ✅ Search also by related category name
                        ->orWhereHas('cat', function($catQuery) use ($value) {
                            $catQuery->where('name', 'like', "%{$value}%");
                        });
                    });
                } else {
                    $query->where($field, $value);
                }
            }
        }

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->orderBy($orderBy, $direction)
                    ->paginate($perPage)
                    ->withQueryString();
    }


    // Find by ID
    public function findId(int $id, array $with = [])
    {
        $query = Subcat::where('id', $id);

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->firstOrFail();
    }

    // Find by condition
    public function findBy(string $field, $value, array $with = [])
    {
        $query = Subcat::where($field, $value);

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->firstOrFail();
    }

    public function existsBy(string $field, $value): bool
    {
        return Subcat::where($field, $value)->exists();
    }

    public function existsByExceptId(string $field, $value, int $id): bool
    {
        return Subcat::where($field, $value)
            ->where('id', '!=', $id)
            ->exists();
    }

    // Check existence by field + catid
    public function existsByWithCat(string $field, $value, string $field2, $value2): bool
    {
        return Subcat::where($field, $value)
                    ->where($field2, $value2)
                    ->exists();
    }

    // Check existence by field + catid, excluding a given subcat ID
    public function existsByWithCatExceptId(string $field, $value, string $field2, $value2, int $id): bool
    {
        return Subcat::where($field, $value)
                    ->where($field2, $value2)
                    ->where('id', '!=', $id)
                    ->exists();
    }



    // Store new record
    public function store(array $data)
    {
        return Subcat::create($data);
    }

    // Update existing record
    public function update(Subcat $subcat, array $data)
    {
        $subcat->update($data);
        return $subcat;
    }

    // Delete single record
    public function delete(Subcat $subcat)
    {
        return $subcat->delete();
    }

    // Delete multiple records
    public function deleteAll(array $filters)
    {
        $query = Subcat::query();

        if (array_is_list($filters)) {
            return $query->whereIn('id', $filters)->delete();
        }

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }

        return $query->delete();
    }

    // ✅ Additional: Get all subcats by catid with optional filters
    public function allByCat(int $catid, array $filters = [], string $orderBy = 'id', string $direction = 'desc', array $with = [])
    {
        $query = Subcat::query()->where('catid', $catid);

        $filters = array_filter($filters, function($key) {
            return !in_array($key, ['_token', '_method']);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->orderBy($orderBy, $direction)->get();
    }

    // ✅ Additional: Paginated subcats by catid with optional filters
    public function paginatedByCat(int $catid, array $filters = [], string $orderBy = 'id', string $direction = 'desc', array $with = [], int $perPage = 15)
    {
        $query = Subcat::query()->where('catid', $catid);

        $filters = array_filter($filters, function($key) {
            return !in_array($key, ['_token', '_method']);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                if ($field === 'search') {
                    $query->where(function($q) use ($value) {
                        $q->where('name', 'like', "%{$value}%")
                          ->orWhere('id', '=', "{$value}");
                    });
                } else {
                    $query->where($field, $value);
                }
            }
        }

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->orderBy($orderBy, $direction)->paginate($perPage)->withQueryString();
    }
}
