<form hx-post="{{ route('admin.cat.update', $cat->id) }}" 
      hx-target="#viewcats" 
      hx-swap="innerHTML"
      hx-push-url="{{ route('admin.cat.index') }}"
      enctype="multipart/form-data"
     hx-disabled-elt="button[type=submit]" id = 'editcat'
    >
    @csrf

    @method('PUT')

  

    <div class="mb-2">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" 
               class="form-control" 
               id="nameupd" 
               name="name" 
               value="{{ $cat->name }}" 
               required
               hx-post="{{ route('admin.cat.validateNameUpdate', $cat->id) }}"
               hx-trigger="keyup changed delay:500ms"
               hx-target="#name-validationupd"
               hx-swap="none">
        <div id="name-validationupd" class="name-validationupd form-text"></div>
    </div>

    <div class="mb-2">
        <label for="des" class="form-label">Description</label>
        <textarea class="form-control" id="des" name="des">{{ $cat->des }}</textarea>
    </div>

    <div class="mb-2">
        <label for="dess" class="form-label">Details</label>
        <textarea class="dessx form-control" id="dess" name="dess">{{ $cat->dess }}</textarea>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <label for="img" class="form-label">Image</label>

            <div class="mb-2">
                @if($cat->img)
                    {{-- Show current image if present --}}
                    <img src="{{ asset($cat->img) }}"
                        id="previewEdit"
                        alt="Current Image"
                        class="img-thumbnail"
                        style="max-width:150px;">
                @else
                    {{-- Hidden preview until a file is selected --}}
                    <img id="previewEdit"
                        class="img-thumbnail d-none"
                        style="max-width:150px;"
                        alt="New Preview">
                @endif
            </div>

            
            <input type="file"
                class="form-control"
                id="imgEdit"
                name="img"
                accept="image/*"
                onchange="previewImage(event, 'previewEdit')">
        </div>



        <div class="col-md-6">
            <label for="filer" class="form-label">File</label>
            @if($cat->filer)
                <div class="mb-2">
                    <a href="{{ asset($cat->filer) }}" target="_blank">Current File</a>
                </div>
            @endif
            <input type="file" class="form-control" id="filer" name="filer">
        </div>
    </div>
    <button type="submit" class="btn btn-primary" onClick ="returnToPage1()">Update Category</button>
</form>
