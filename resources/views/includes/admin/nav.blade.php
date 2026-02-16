<nav class="navbar navbar-expand-lg navbar-dark container">
    <a class="navbar-brand" href="{{ url('/dashboard') }}">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.cat.index') }}">Categories</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.subcat.index') }}">SubCategories</a>
            </li>

            
        </ul>
    </div>
</nav>
