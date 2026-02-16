<?php

namespace App\Repositories;

use App\Models\Cat;

class CatRepository
{
    // Get all records, with optional filters, ordering, and relations
// Get all records, with optional filters, ordering, and relations
    public function all(array $filters = [], string $orderBy = 'id', string $direction = 'desc', array $with = [])
    {
        $query = Cat::query();

        // ✅ Remove _token and _method from filters
        $filters = array_filter($filters, function($key) {
            return !in_array($key, ['_token', '_method']);
        }, ARRAY_FILTER_USE_KEY);

        // apply filters
        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }

        // eager load relations if any
        if (!empty($with)) {
            $query->with($with);
        }

        return $query->orderBy($orderBy, $direction)->get();
    }


    public function paginated(array $filters = [], string $orderBy = 'id', string $direction = 'desc', array $with = [], int $perPage = 15)
    {
        $query = Cat::query();

        // ✅ Remove _token, _method, and other non-filter keys
        $filters = array_filter($filters, function($key) {
            return !in_array($key, ['_token', '_method']);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                // Special handling for search
                if ($field === 'search') {
                    $query->where(function($q) use ($value) {
                        $q->where('name', 'like', "%{$value}%")
                        ->orWhere('id', '=', "{$value}");
                        // Add more searchable fields as needed
                    });
                } else {
                    // Exact match for other filters
                    $query->where($field, $value);
                }
            }
        }

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->orderBy($orderBy, $direction)->paginate($perPage)->withQueryString();
    }



    // Find by ID (no filters, no order)
    public function findId(int $id, array $with = [])
    {
        $query = Cat::where('id', $id);

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->firstOrFail();
    }


    // Find by condition (single field/value)
    public function findBy(string $field, $value, array $with = [])
    {
        $query = Cat::where($field, $value);

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->firstOrFail();
    }


    public function existsBy(string $field, $value): bool
    {
        return Cat::where($field, $value)->exists();
    }

    public function existsByExceptId(string $field, $value, int $id): bool
    {
        return Cat::where($field, $value)
            ->where('id', '!=', $id)
            ->exists();
    }

    

    // Store new record
    public function store(array $data)
    {
        return Cat::create($data);
    }

    // Update existing record
    public function update(Cat $cat, array $data)
    {
        $cat->update($data);
        return $cat;
    }

    // Delete single record
    public function delete(Cat $cat)
    {
        return $cat->delete();
    }

    public function deleteAll(array $filters)
    {
        $query = Cat::query();

        // Check if it's a numeric array of IDs
        if (array_is_list($filters)) {
            // It's an array of IDs like [7, 5, 8]
            return $query->whereIn('id', $filters)->delete();
        }

        // It's an associative array of filters like ['status' => 'active']
        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }

        return $query->delete();
    }

}
