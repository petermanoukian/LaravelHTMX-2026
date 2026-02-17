<table class="table table-striped">

    @include('components.tableheader', [
        'columns' => [
            ['label' => 'ID', 'field' => 'id', 'orderable' => true],
            ['label' => 'Name', 'field' => 'name', 'orderable' => true],
            ['label' => 'Category', 'field' => 'catid', 'orderable' => true],
            ['label' => 'Image', 'orderable' => false],
            ['label' => 'File', 'orderable' => false],
            ['label' => 'Actions', 'orderable' => false],
        ],
        'currentSortField' => $sortField ?? 'id',
        'currentSortDirection' => $sortDirection ?? 'desc',
        'bulkSelect' => true,
        'endpoint' => route('admin.subcat.index', ['catid' => $catid ?? null]),
        'target' => '#viewlist'
    ])

    <tbody>
        @foreach($subcats as $subcat)
            <tr>
                <td>
                    <input type="checkbox" class="checkbox" value="{{ $subcat->id }}" onchange="updateBulkDeleteBtn()">
                </td>
                <td>{{ $subcat->id }}</td>
                <td>{{ $subcat->name }}</td>
                <td>{{ $subcat->cat->name ?? '' }}</td>
                <td>
                    @if($subcat->img2)
                        <img src="{{ asset($subcat->img2) }}" alt="Thumbnail" style="max-width: 80px;">
                    @endif
                </td>
                <td>
                    @if($subcat->filer)
                        <a href="{{ asset($subcat->filer) }}" target="_blank">Download</a>
                    @endif
                </td>
                <td>


                    <a hx-get="{{ route('admin.subcat.edit', $subcat->id) }}"
                    hx-target="#editSubCatBody"
                    hx-swap="innerHTML"
                    class="btn btn-sm btn-primary"
                    data-bs-toggle="modal" data-bs-target="#editModal">
                    Edit
                    </a>

                    <form hx-delete="{{ route('admin.subcat.destroy', $subcat->id) }}"
                        hx-target="#viewlist"
                        hx-swap="innerHTML"
                        hx-confirm="Are you sure you want to delete this ?"
                        style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


@include('components.pagination', ['paginator' => $subcats, 'target' => '#viewlist'])

<div id="loading" class="htmx-indicator text-center my-3 d-none">
    <div class="spinner-border text-primary" role="status"></div>
</div>
<button id="bulkDeleteBtn" class="btn btn-danger d-none" onclick="bulkDelete()">Delete Selected</button>
