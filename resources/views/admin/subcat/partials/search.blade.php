<div class="mb-3">
    <form id="search-form" class="row g-3">
        <div class="col-md-4">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Search by id,name,category" 
                value="{{ $search ?? '' }}"
                hx-get="{{ $endpoint }}"
                hx-trigger="keyup changed delay:1000ms"

                hx-target="{{ $target ?? '#viewlist' }}"
                hx-include="#search-form"
            >
        </div>

        <div class="col-md-3">
            <select 
                name="catid" 
                class="searchable form-select"
                hx-get="{{ $endpoint }}"
                hx-trigger="change"
                hx-target="{{ $target ?? '#viewlist' }}"
                hx-include="#search-form"
            >
                <option value="">All Categories</option>
                @foreach($cats as $cat)
                    <option value="{{ $cat->id }}" {{ ($catid ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>





        <div class="col-md-2">
            <select 
                name="per_page" 
                class="form-select"
                hx-get="{{ $endpoint }}"
                hx-trigger="change"
                hx-target="{{ $target ?? '#viewlist' }}"
                hx-include="#search-form"
            >
                <option value="5" {{ ($perPage ?? 5) == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ ($perPage ?? 5) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ ($perPage ?? 5) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ ($perPage ?? 5) == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ ($perPage ?? 5) == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>



        <div class="col-md-2">
            <button 
                type="button" 
                class="btn btn-secondary"
                hx-get="{{ $endpoint }}"
                hx-target="{{ $target ?? '#viewlist' }}"
                onclick="document.querySelector('[name=search]').value = ''; this.click();"
            >
                Clear
            </button>
        </div>
    </form>
</div>