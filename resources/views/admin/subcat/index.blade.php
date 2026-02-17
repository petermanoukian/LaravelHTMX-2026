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

                    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true" 
                        data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content p-2">

                                <!-- Modal header with close button -->
                                <div class="modal-header">
                                    <h5 class="modal-title">Add SubCategory</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body" id="addSubCatBody">
                                    @include('admin.subcat.partials.addform')
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" 
                        data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content p-2">

                                <!-- Modal header with close button -->
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit SubCategory</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body" id="editSubCatBody">
                                    <!-- HTMX loads edit form here -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div>
                    <button class="btn btn-success mb-3 mt-2" data-bs-toggle="modal" 
                    data-bs-target="#addModal"> 
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
@endsection


@section('scripts')
   
    @include('admin.scripts.subcatscript')
    @include('admin.scripts.commonscript')



@endsection
