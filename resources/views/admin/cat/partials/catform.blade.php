<form hx-post="{{ route('admin.cat.store') }}" 
      hx-target="#viewcats" 
      hx-swap="innerHTML"
      hx-push-url="{{ route('admin.cat.index') }}"
      hx-disabled-elt="button[type=submit]"   
      enctype="multipart/form-data" id ='addcat'
      
      >
 
    @csrf

    <div class="mb-2">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" 
            class="form-control" 
            name="name" id='name'
            required
            hx-post="{{ route('admin.cat.validateNameAdd') }}"
            hx-trigger="keyup changed delay:500ms"
            hx-target="#name-validationadd"
            hx-swap="none"
            >
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

    <button type="submit" class="btn btn-primary" onClick ="returnToPage1()">Add Category</button>
</form>
