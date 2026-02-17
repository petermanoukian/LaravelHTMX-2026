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


                   <div class="modal fade" id="addCatModal" tabindex="-1" aria-hidden="true" 
                        data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable"> 
                            <div class="modal-content p-2">  

                                <!-- Modal header with close button -->
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body" id="addCatBody">
                                    @include('admin.cat.partials.catform')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editCatModal" tabindex="-1" aria-hidden="true" 
                        data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content p-2">

                                <!-- Modal header with close button -->
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body" id="editCatBody">
                                    <!-- HTMX loads edit form here -->
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
                <div class ='mb-3 mt-2'>
                    <button class="btn btn-sm btn-success mt-3 mb-3"
                            data-bs-toggle="modal"
                            data-bs-target="#addCatModal">
                    Add Category
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
@endsection


@section('scripts')
   
    @include('admin.scripts.catscript')
    @include('admin.scripts.commonscript')



    </script>
@endsection
