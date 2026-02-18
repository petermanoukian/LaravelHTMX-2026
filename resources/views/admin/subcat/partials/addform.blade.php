<form hx-post="{{ route('admin.subcat.store') }}" 
      hx-target="#viewlist" 
      hx-swap="innerHTML"
      hx-push-url="{{ route('admin.subcat.index', ['catid' => $catid ?? null]) }}"
      hx-disabled-elt="button[type=submit]"   
      enctype="multipart/form-data" id ='addsubcat'>

    @csrf


    <div class="mb-2 zindex99">
        <label for="catid" class="form-label">Parent Category</label>
        <select name="catid" id="catid" class="searchable form-control zindex99 " required>
            <option value="">-- Select Category --</option>
            @foreach($cats as $row)
                <option value="{{ $row->id }}" 
                    @if(isset($catid) && $catid == $row->id) selected @endif>
                    {{ $row->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-2">
        <label for="name" class="form-label">SubCategory Name</label>
        <input type="text" name="name" id="name" class="form-control" 
        hx-post="{{ route('admin.subcat.validateNameAdd') }}" required
        hx-trigger="keyup changed delay:500ms"
        hx-target="#name-validationadd"
        hx-swap="none"
        hx-include="#catid">
        <div id="name-validationadd" class="form-text"></div>
    </div>

    <div class="mb-2">
        <label for="des" class="form-label">Short Description</label>
        <textarea class="form-control" id="des" name="des"></textarea>
    </div>

    <div class="mb-2">
        <label for="dess" class="form-label">Details</label>
        <textarea class="dess form-control" id="dess" name="dess"></textarea>
    </div>

    <div class="row mb-2">
        <div class="col-md-6">
            <label for="img" class="form-label">Image</label>
            <input type="file" class="form-control" id="img" name="img" accept="image/*" onchange="previewImage(event, 'previewAdd')">
            <div class="mt-2">
                <img id="previewAdd" class="img-thumbnail d-none" style="max-width:150px;" alt="Preview">
            </div>
        </div>

        <div class="col-md-6">
            <label for="filer" class="form-label">File</label>
            <input type="file" class="form-control" id="filer" name="filer">
        </div>
    </div>
    <button type="submit" class="btn btn-primary" >Add SubCategory</button>
</form>
