<div class="table-actions">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Action
        </button>
        <div class="dropdown-menu">
            @if ($tender->status == '0')
                <a class="dropdown-item" href="{{ route($route.'.edit', $tender->id) }}">Edit</a>
                <a class="dropdown-item" href="{{ route($route.'.show', $tender->id) }}">Show</a>
                <form action="{{ route($route.'.destroy', $tender->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item">Delete</button>
                </form>
                <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#printModal" data-tender="{{ $tender }}">
                    Print
                </a>
                <a class="dropdown-item" href="{{ route('schedule.index', $tender->id) }}" target="_blank">Schedule</a>
                <a class="dropdown-item" href="{{ route($route.'.view', $tender->id) }}">Decision</a>
            @elseif ($tender->status == '1')
                <a class="dropdown-item" href="{{ route($route.'.detail', $tender->id) }}">Detail & Evaluation</a>
            @elseif ($tender->status == '2')
                <a class="dropdown-item" href="{{ route($route.'.detail', $tender->id) }}">Detail</a>
            @elseif ($tender->status == '3')
                <a class="dropdown-item" href="{{ route($route.'.detail', $tender->id) }}">Detail</a>
            @endif
        </div>
    </div>
</div>
