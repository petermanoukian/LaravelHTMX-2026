<form hx-post="{{ route('admin.subcat.update', $row->id) }}" 
      hx-target="#viewlist" 
      hx-swap="innerHTML"
      hx-push-url="{{ route('admin.subcat.index', ['catid' => $row->catid]) }}"
      enctype="multipart/form-data"
      hx-disabled-elt="button[type=submit]" id ='editsubcat' class="editsubcat">

    @csrf
    @method('PUT')

    <div class="mb-2 zindex99">
        <label for="catid" class="form-label">Parent Category</label>
        <select name="catid" id="catid" class="searchable form-control zindex99 " required>
            <option value="">-- Select Category --</option>
            @foreach($cats as $cat)
                <option value="{{ $cat->id }}" 
                    @if($row->catid == $cat->id) selected @endif>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('catid')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-2">
        <label for="name" class="form-label">SubCategory Name</label>
        <input type="hidden" name="id" value="{{ $row->id }}">
        <input type="text" name="name" id="nameupd" class="form-control" 
            value="{{ $row->name }}"  required
            hx-post="{{ route('admin.subcat.validateNameUpdate') }}"
            hx-trigger="keyup changed delay:500ms"
            hx-target="#name-validationupd"
            hx-swap="none"
            hx-include="#catid, [name=id]">

        <div id="name-validationupd" class="form-text"></div>
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-2">
        <label for="des" class="form-label">Description</label>
        <textarea class="form-control" id="des" name="des">{{ $row->des }}</textarea>
        @error('des')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-2">
        <label for="dess" class="form-label">Details</label>
        <textarea class="dessx form-control" id="dess" name="dess">{{ $row->dess }}</textarea>
        @error('dess')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-2 row">
        <div class="col-md-6">
            <label for="img" class="form-label">Image</label>
            <div class="mb-2">
                @if($row->img)
                    <img src="{{ asset($row->img) }}"
                        id="previewEdit"
                        alt="Current Image"
                        class="img-thumbnail"
                        style="max-width:150px;">
                @else
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
            @error('img')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="filer" class="form-label">File</label> 
            <div class="mb-2">
            @if($row->filer)  
                <a href="{{ asset($row->filer) }}" target="_blank">Current File</a>  
            @endif  
            </div>
            <input type="file" class="form-control" id="filer" name="filer">
            @error('filer')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary" >Update</button>
</form>
