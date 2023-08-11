<div class="table-actions">
    @can('permission-edit')
    <a href="{{ route($route.'.edit', $data->id) }}" class="btn btn-sm btn-pill btn-warning action">Edit</a>
    @endcan
    @can('permission-delete')
    <form action="{{ route($route.'.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?')" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-pill btn-danger action">Delete</button>
    </form>
    @endcan
</div>
