<div class="table-actions">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Action
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route($route.'.edit', $tender->id) }}">Edit</a>
            <a class="dropdown-item" href="{{ route($route.'.show', $tender->id) }}">Show</a>
            <form action="{{ route($route.'.destroy', $tender->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item">Delete</button>
            </form>
            <a class="dropdown-item" href="{{ route($route.'.show', $tender->id) }}">Pick Vendor</a>
            <a class="dropdown-item" href="{{ route($route.'.show', $tender->id) }}">Second Tender</a>
            <a class="dropdown-item" href="{{ route($route.'.show', $tender->id) }}">Cancel</a>
        </div>
    </div>
</div>
