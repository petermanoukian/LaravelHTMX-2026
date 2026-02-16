@extends('layouts.appadmin')

@section('title', 'Categories')


@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg/dist/ui/trumbowyg.min.css">

@endsection

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Categories
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">                  
                    <div id="addcat" class="d-none mb-2 mt-2">
                        @include('admin.cat.partials.catform')
                    </div>

                    <div id="editcat" class="d-none"></div>
                </div>
                <div>
                    <button class="btn btn-success mb-3 mt-2" onclick="toggleAddCat()">
                        + Add Category
                    </button>
                </div>

                @include('admin.cat.partials.catsearch', [
                    'search' => $search ?? '',
                    'endpoint' => route('admin.cat.index'),
                    'target' => '#viewcats'
                ])

                <div id="viewcats" class='mt-2 mb-3'>
                    @include('admin.cat.partials.catlist', ['cats' => $cats])
                </div>



                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
   
    @include('admin.scripts.catscript')
    @include('admin.scripts.commonscript')



    </script>
@endsection
