<table class="table table-striped">

    @include('components.tableheader', [
        'columns' => [
            ['label' => 'ID', 'field' => 'id', 'orderable' => true],
            ['label' => 'Name', 'field' => 'name', 'orderable' => true],
            ['label' => 'Image', 'orderable' => false],
            ['label' => 'File', 'orderable' => false],
            ['label' => 'Actions', 'orderable' => false],
        ],
        'currentSortField' => $sortField ?? 'id',
        'currentSortDirection' => $sortDirection ?? 'desc',
        'bulkSelect' => true,
        'endpoint' => route('admin.cat.index'),
        'target' => '#viewcats'
    ])
        


    <tbody>
        @foreach($cats as $cat)
            <tr>
                <td>
                    <input type="checkbox" class="cat-checkbox" value="{{ $cat->id }}" onchange="updateBulkDeleteBtn()">
                </td>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td>
                    @if($cat->img2)
                        <img src="{{ asset($cat->img2) }}" alt="Thumbnail" style="max-width: 80px;">
                    @endif
                </td>
                <td>
                    @if($cat->filer)
                        <a href="{{ asset($cat->filer) }}" target="_blank">Download</a>
                    @endif
                </td>
                <td>


                    <a hx-get="{{ route('admin.cat.edit', $cat->id) }}"
                    hx-target="#editCatBody"
                    hx-swap="innerHTML"
                    class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#editCatModal">
                    Edit
                    </a>

                    <a href="{{ route('admin.subcat.index', ['catid' => $cat->id]) }}"
                        class="btn btn-sm btn-primary">
                        Subcategories ({{ $cat->subcats()->count() }})
                    </a>


                    <form hx-delete="{{ route('admin.cat.destroy', $cat->id) }}"
                        hx-target="#viewcats"
                        hx-swap="innerHTML"
                        hx-confirm="Are you sure you want to delete this category?"
                        style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>


                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- ... your table ... -->

    <!-- Pagination with hx-boost (recommended) -->
    <?php
    /*
    <div class="d-flex justify-content-center mt-4" hx-boost="true"
    hx-target="#viewcats" hx-swap="innerHTML">
        {{ $cats->appends(request()->except('page'))->links('pagination::bootstrap-5') }}  <!-- or default / tailwind -->
    </div>
    */
    ?>
   @include('components.pagination', ['paginator' => $cats, 'target' => '#viewcats'])

    <!-- Optional: global loading indicator near pagination -->
    <div id="loading" class="htmx-indicator text-center my-3 d-none">
        <div class="spinner-border text-primary" role="status"></div>
    </div>







<button id="bulkDeleteBtn" class="btn btn-danger d-none" onclick="bulkDelete()">Delete Selected</button>


