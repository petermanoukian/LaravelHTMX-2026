<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CatStoreRequest;
use App\Http\Requests\Admin\CatUpdateRequest;
use App\Services\CatService;
use App\Services\ImageUploadService;
use App\Services\FileUploaderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cat;

class CatController extends Controller
{
    protected $service;
    protected $imageUpload;
    protected $fileUpload;

    public function __construct(
        CatService $service,
        ImageUploadService $imageUpload,
        FileUploaderService $fileUpload
    ) {
        $this->service     = $service;
        $this->imageUpload = $imageUpload;
        $this->fileUpload  = $fileUpload;
    }

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = (int) $request->input('per_page', 5);
        
        // Validate per_page
        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 5;
        }
        
        $sortField = $request->input('sort_field', 'id');
        $sortDirection = $request->input('sort_direction', 'desc');
        
        $allowedSortFields = ['id', 'name', 'email'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'id';
        }
        
        $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'desc';
        
        $filters = $request->except(['page', '_token', '_method', 'sort_field', 'sort_direction', 'search', 'per_page']);
        
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        
        $cats = $this->service->paginated(
            filters: $filters,
            orderBy: $sortField,
            direction: $sortDirection,
            with: [],
            perPage: $perPage
        );

        if ($request->header('HX-Request')) {
            return view('admin.cat.partials.catlist', compact('cats', 'sortField', 'sortDirection', 'search', 'perPage'));
        }

        return view('admin.cat.index', compact('cats', 'filters', 'sortField', 'sortDirection', 'search', 'perPage'));
    }

    // JSON endpoint for HTMX or API
    public function indexJson(Request $request)
    {
        $filters = $request->query();
        $cats = $this->service->paginated($filters, 'id', 'desc', [], 15);

        return response()->json($cats);
    }

    // Show create form
    public function create()
    {
        return view('admin.cat.create');
    }


    public function store(CatStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) {
            $imgPaths = $this->imageUpload->upload(
                $request,
                'img',
                'uploads/cat/img',
                'uploads/cat/img/thumb',
                1500, 1000, null, 100, 100
            );
            $data['img']  = $imgPaths['large'];
            $data['img2'] = $imgPaths['small'];
        }

        if ($request->hasFile('filer')) {
            $fileMeta = $this->fileUpload->upload(
                $request, 'filer', 'uploads/cat/file', $data['name'], time()
            );
            $data['filer'] = $fileMeta['path'];
        }

        $cat = $this->service->store($data);

        $currentPage = $request->query('page', 1);
        
        if ($request->headers->has('HX-Request')) { 
            $cats = $this->service->paginated([], 'id', 'desc', [], 5)->setPage($currentPage);
            //$cats = $this->service->paginated([], 'id', 'desc', [], 5)->setPage(1);
            //$cats = $this->service->paginated([], 'id', 'desc', [], 5);
            return response()->view('admin.cat.partials.catlist', compact('cats'))
            ->header('HX-Trigger', 'list-mutated');
        }

        return redirect()->route('admin.cat.index')->with('success', 'Cat created'); // ✅ Uncomment this
    }

    public function update(CatUpdateRequest $request, Cat $cat)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) {
            $imgPaths = $this->imageUpload->upload(
                $request, 'img', 'uploads/cat/img', 'uploads/cat/img/thumb',
                1500, 1000, null, 100, 100
            );
            $data['img']  = $imgPaths['large'];
            $data['img2'] = $imgPaths['small'];
        }

        if ($request->hasFile('filer')) {
            $fileMeta = $this->fileUpload->upload(
                $request, 'filer', 'uploads/cat/file', $data['name'], time()
            );
            $data['filer'] = $fileMeta['path'];
        }

        $this->service->update($cat, $data);
        $currentPage = $request->query('page', 1);
        if ($request->headers->has('HX-Request')) { 
            $cats = $this->service->paginated([], 'id', 'desc', [], 5)->setPage($currentPage);
            //$cats = $this->service->paginated([], 'id', 'desc', [], 5)->setPage(1);
            //$cats = $this->service->paginated([], 'id', 'desc', [], 5);
            return response()->view('admin.cat.partials.catlist', compact('cats'))
            ->header('HX-Trigger', 'list-mutated');
        }

        return redirect()->route('admin.cat.index')->with('success', 'Cat updated');
    }

    // Show single cat
    public function show(int $id)
    {
        $cat = $this->service->findId($id, []);
        return view('admin.cat.show', compact('cat'));
    }

    public function edit(Cat $cat)
    {
        if (request()->headers->has('HX-Request')) {
            return view('admin.cat.partials.editform', compact('cat'));
        }

        //return view('admin.cat.edit', compact('cat'));
    }



    public function validateNameAdd(Request $request)
    {
        $name = $request->input('name');

        // 0 characters → do nothing
        if ($name === null || $name === '') {
            return response()->json([
                'valid'   => null,
                'message' => ''
            ]);
        }

        // 1–2 characters → spinner message
        if (strlen($name) <= 2) {
            return response()->json([
                'valid'   => null,
                'message' => '...searching..'
            ]);
        }

        // ≥3 characters → only here we run $exists
        if (strlen($name) > 2) {
            $exists = $this->service->existsBy('name', $name);

            if ($exists) {
                return response()->json([
                    'valid'   => false,
                    'message' => 'Name already taken.'
                ]);
            }

            return response()->json([
                'valid'   => true,
                'message' => 'Name is available.'
            ]);
        }
    }

    public function validateNameUpdate(Request $request, $id = null)
    {
        // Normalize ID from route, query, or request body
        $id   = $id ?? $request->query('id') ?? $request->input('id');
        $name = $request->input('name');

        if (!$id) {
            return response()->json([
                'valid'   => false,
                'message' => 'Missing cat ID for update validation.'
            ], 400);
        }

        // 0 characters → do nothing
        if ($name === null || $name === '') {
            return response()->json([
                'valid'   => null,
                'message' => ''
            ]);
        }

        // 1–2 characters → spinner message
        if (strlen($name) <= 2) {
            return response()->json([
                'valid'   => null,
                'message' => '...searching..'
            ]);
        }

        // ≥3 characters → only here we run $exists
        if (strlen($name) > 2) {
            $exists = $this->service->existsByExceptId('name', $name, (int) $id);

            if ($exists) {
                return response()->json([
                    'valid'   => false,
                    'message' => 'Name already taken by another cat.'
                ]);
            }

            return response()->json([
                'valid'   => true,
                'message' => 'Name is available.'
            ]);
        }
    }
    

    // Delete single cat
    public function destroy(Cat $cat)
    {
        $this->service->delete($cat);
        $currentPage = $request->query('page', 1);
        if ($request->headers->has('HX-Request')) { 
            //$cats = $this->service->paginated([], 'id', 'desc', [], 5)->setPage($currentPage);
            $cats = $this->service->paginated([], 'id', 'desc', [], 5)->setPage(1);
            //$cats = $this->service->paginated([], 'id', 'desc', [], 5);
            return response()->view('admin.cat.partials.catlist', compact('cats'))
            ->header('HX-Trigger', 'list-mutated');
        }

        //return redirect()->route('admin.cat.index')->with('success', 'Cat deleted');
    }


    public function destroyAll(Request $request)
    {
        Log::info('=== destroyAll called ===');
        Log::info('Request data:', [$request->all()]);
        
        $ids = $request->input('ids', []);
        Log::info('IDs received:', ['ids' => $ids, 'type' => gettype($ids)]);
        
        // Convert to array if it's a single value - BEFORE counting
        if (!is_array($ids)) {
            $ids = [$ids];
            Log::info('Converted single value to array');
        }
        
        Log::info('IDs after conversion:', ['ids' => $ids, 'count' => count($ids)]);

        if (!empty($ids)) {
            try {
                $result = $this->service->deleteAll($ids);
                Log::info('Delete result:', ['result' => $result]);
            } catch (\Exception $e) {
                Log::error('Delete failed:', ['error' => $e->getMessage()]);
                throw $e;
            }
        }
        $currentPage = $request->query('page', 1);
        /*
        if ($request->headers->has('HX-Request')) { 
            //$cats = $this->service->paginated([], 'id', 'desc', [], 5)->setPage($currentPage);
            //$cats = $this->service->paginated([], 'id', 'desc', [], 5)->setPage(1);
            $cats = $this->service->paginated([], 'id', 'desc', [], 5);
            return response()->view('admin.cat.partials.catlist', compact('cats'))
            ->header('HX-Trigger', 'list-mutated');
        }
    */
        return redirect()->route('admin.cat.index')->with('success', 'Selected cats deleted');
    }



}
