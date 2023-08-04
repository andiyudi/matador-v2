<div class="table-actions">
    <a href="{{ route($route.'.edit', encrypt($data->id)) }}" class="btn btn-sm btn-warning action">Edit</a>
    <form action="{{ route($route.'.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?')" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger action">Delete</button>
    </form>
</div>
