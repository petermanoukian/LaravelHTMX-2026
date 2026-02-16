@extends('layouts.appadmin')

@section('title', 'SubCategories')


@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg/dist/ui/trumbowyg.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
@endsection

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        SubCategories
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                   
                                        
                    <div id="add" class="d-none mb-2 mt-2">
                        @include('admin.subcat.partials.addform')
                    </div>

                    

                    <div id="edit" class="d-none"></div>

                    </div>
                    <div>
                        <button class="btn btn-success mb-3 mt-2" onclick="toggleAdd()">
                            + Add SubCategory
                        </button>
                    </div>

                    @include('admin.subcat.partials.search', [
                        'search' => $search ?? '',
                        'endpoint' => route('admin.subcat.index'),
                        'target' => '#viewlist'
                    ])



                    <div id="viewlist" class='mt-2 mb-3'>
                        @include('admin.subcat.partials.list', ['subcats' => $subcats])
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
   
    @include('admin.scripts.subcatscript')
    @include('admin.scripts.commonscript')



@endsection
