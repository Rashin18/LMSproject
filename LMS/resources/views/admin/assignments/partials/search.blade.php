<div class="mb-4">
    <form action="{{ route('admin.assignments.index') }}" method="GET">
        <div class="input-group">
            <input type="text" name="search" class="form-control" 
                   placeholder="Search assignments..." 
                   value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="search">Search
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                <a href="{{ route('admin.assignments.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times">Clear</i>
                </a>
                @endif
            </div>
        </div>
    </form>
</div>
