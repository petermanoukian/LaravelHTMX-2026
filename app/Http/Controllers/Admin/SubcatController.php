<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubcatStoreRequest;
use App\Http\Requests\Admin\SubcatUpdateRequest;
use App\Services\CatService;
use App\Services\SubcatService;
use App\Services\ImageUploadService;
use App\Services\FileUploaderService;
use Illuminate\Http\Request;
use App\Models\Subcat;
use Illuminate\Support\Facades\Log;


class SubcatController extends Controller
{
    protected $service;
    protected $catservice;
        protected $imageUpload;
    protected $fileUpload;

    public function __construct(SubcatService $service, CatService $catservice, 
            ImageUploadService $imageUpload,
        FileUploaderService $fileUpload)
    {
        $this->service = $service;
        $this->catservice = $catservice;
                $this->imageUpload = $imageUpload;
        $this->fileUpload  = $fileUpload;
    }

    // List all subcats (optionally filter by catid)
    public function index(Request $request, $catid = null)
    {
        $search = $request->input('search', '');
        $perPage = (int) $request->input('per_page', 5);
        if (!in_array($perPage, [5,10,25,50,100])) {
            $perPage = 5;
        }

        $sortField = $request->input('sort_field','id');
        $sortDirection = $request->input('sort_direction','desc');
        $allowedSortFields = ['id','name','catid'];
        if (!in_array($sortField,$allowedSortFields)) {
            $sortField = 'id';
        }
        $sortDirection = in_array($sortDirection,['asc','desc']) ? $sortDirection : 'desc';

        $filters = $request->except(['page','_token','_method','sort_field','sort_direction','search','per_page']);
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        if ($catid) {
            $filters['catid'] = $catid;
        }

        $subcats = $this->service->paginated(
            filters: $filters,
            orderBy: $sortField,
            direction: $sortDirection,
            with: ['cat'],
            perPage: $perPage
        );

        $cats = $this->catservice->all([], 'name', 'asc', []);

        if ($request->header('HX-Request')) {
            return view('admin.subcat.partials.list', compact('cats','subcats','sortField','sortDirection','search','perPage','catid'));
        }

        return view('admin.subcat.index', compact('cats','subcats','filters','sortField','sortDirection','search','perPage','catid'));
    }

    // JSON endpoint (optionally filter by catid)
    public function indexJson(Request $request, $catid = null)
    {
        $filters = $request->query();
        if ($catid) {
            $filters['catid'] = $catid;
        }
        $cats = $this->catservice->all([], 'name', 'asc', []);
        $subcats = $this->service->paginated($filters,'id','desc',['cat'],15);

        return response()->json([
            'subcats' => $subcats,
            'cats'    => $cats
        ]);

    }

    
    // Validation: Add
    public function validateNameAdd(Request $request)
    {
        $name  = $request->input('name');
        $catid = $request->input('catid');

        // Neutral guard
        if (empty($name) || empty($catid)) {
            return response()->json(['valid' => true, 'message' => '']);
        }

        if (strlen($name) <= 2) {
            return response()->json(['valid' => null, 'message' => '...searching..']);
        }

        $exists = $this->service->existsByWithCat('name', $name, 'catid', $catid);

        return response()->json([
            'valid'   => !$exists,
            'message' => $exists
                ? 'Name already taken in this category.'
                : 'Name is available in this category.'
        ]);
    }

    // Validation: Update
    public function validateNameUpdate(Request $request)
    {
        $id    = (int) $request->input('id');   // comes from hidden field
        $name  = $request->input('name');
        $catid = $request->input('catid');

        // Neutral guard
        if (empty($id) || empty($name) || empty($catid)) {
            return response()->json(['valid' => true, 'message' => '']);
        }

        if (strlen($name) <= 2) {
            return response()->json(['valid' => null, 'message' => '...searching..']);
        }

        $exists = $this->service->existsByWithCatExceptId('name', $name, 'catid', $catid, $id);

        return response()->json([
            'valid'   => !$exists,
            'message' => $exists
                ? 'Name already taken in this category.'
                : 'Name is available in this category.'
        ]);
    }



    // Show create form (optional catid in route)
    public function create($catid = null)
    {
        $cats = $this->catservice->all([], 'name', 'asc', []);
        return view('admin.subcat.create', compact('catid', 'cats'));
    }


    public function store(SubcatStoreRequest $request)
    {
        try {
            $data = $request->validated();
            Log::info('Subcat store request validated', $data);

            // ✅ Handle image upload
            if ($request->hasFile('img')) {
                $imgPaths = $this->imageUpload->upload(
                    $request,
                    'img',
                    'uploads/subcat/img',
                    'uploads/subcat/img/thumb',
                    1500, 1000, null, 100, 100
                );
                $data['img']  = $imgPaths['large'];
                $data['img2'] = $imgPaths['small'];
            }

            // ✅ Handle file upload
            if ($request->hasFile('filer')) {
                $fileMeta = $this->fileUpload->upload(
                    $request, 'filer', 'uploads/subcat/file', $data['name'], time()
                );
                $data['filer'] = $fileMeta['path'];
            }

            // ✅ Store subcat
            $subcat = $this->service->store($data);
            Log::info('Subcat created successfully', ['id' => $subcat->id]);

            $catidx = $request->input('catid'); // comes from hidden input
            $filters = [];
            if ($catidx) {
                $filters['catid'] = $catidx;
            }

            if ($request->headers->has('HX-Request')) {
                $subcats = $this->service->paginated($filters, 'id', 'desc', ['cat'], 5);

                return response()
                    ->view('admin.subcat.partials.list', compact('subcats'))
                    ->header('HX-Trigger', 'list-mutated')
                    ->header('HX-Push-Url', route('admin.subcat.index', ['catid' => $catidx ]));
            }

            return redirect()
                ->route('admin.subcat.index')
                ->with('success', 'Subcategory created');
        } catch (\Throwable $e) {
            Log::error('Error storing subcategory', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            if ($request->headers->has('HX-Request')) {
                return response()
                    ->view('admin.subcat.partials.error', [
                        'error' => 'Failed to create subcategory: ' . $e->getMessage()
                    ], 500);
            }

            return redirect()
                ->route('admin.subcat.index')
                ->with('error', 'Failed to create subcategory: ' . $e->getMessage());
        }
    }


    public function update(SubcatUpdateRequest $request, Subcat $subcat)
    {
        $data = $request->validated();


        if ($request->hasFile('img')) {
            $imgPaths = $this->imageUpload->upload(
                $request,
                'img',
                'uploads/subcat/img',
                'uploads/subcat/img/thumb',
                1500, 1000, null, 100, 100
            );
            $data['img']  = $imgPaths['large'];
            $data['img2'] = $imgPaths['small'];
        }

        // ✅ Handle file upload
        if ($request->hasFile('filer')) {
            $fileMeta = $this->fileUpload->upload(
                $request, 'filer', 'uploads/subcat/file', $data['name'], time()
            );
            $data['filer'] = $fileMeta['path'];
        }

        $this->service->update($subcat,$data);

        $currentPage = $request->query('page',1);

        $catidx = $request->input('catid'); // comes from hidden input
        $filters = [];
        if ($catidx) {
            $filters['catid'] = $catidx;
        }


        if ($request->headers->has('HX-Request')) {
            $subcats = $this->service->paginated($filters, 'id','desc',['cat'],5);
            return response()->view('admin.subcat.partials.list', compact('subcats'))
                ->header('HX-Trigger','list-mutated')
                ->header('HX-Push-Url', route('admin.subcat.index', ['catid' => $catidx ]));
        }

        return redirect()->route('admin.subcat.index')->with('success','Subcategory updated');
    }




    // Show single subcat
    public function show(int $id)
    {
        $subcat = $this->service->findId($id,['cat']);
        return view('admin.subcat.show', compact('subcat'));
    }

    // Edit form
    public function edit(int $id)
    {
        $row = $this->service->findId($id);
        $cats = $this->catservice->all([], 'name', 'asc', []);
        if (request()->headers->has('HX-Request')) {
            return view('admin.subcat.partials.editform', compact('row', 'cats'));
        }
    }

    // Update existing subcat


    // Delete single subcat
    public function destroy(Subcat $subcat, Request $request)
    {
        $this->service->delete($subcat);
        $currentPage = $request->query('page',1);

        if ($request->headers->has('HX-Request')) {
            $subcats = $this->service->paginated([], 'id','desc',['cat'],5)->setPage(1);
            return response()->view('admin.subcat.partials.list', compact('subcats'))
                ->header('HX-Trigger','list-mutated');
        }
    }

    // Bulk delete
    public function destroyAll(Request $request)
    {
        $ids = $request->input('ids',[]);
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        if (!empty($ids)) {
            $this->service->deleteAll($ids);
        }
        return redirect()->route('admin.subcat.index')->with('success','Selected subcategories deleted');
    }
}
