<div class="d-grid gap-2 mx-auto">
    <a href="{{ route($route.'.show', ($procurement->id)) }}" class="btn btn-sm btn-primary">Evaluation</a>
    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#determinationModal" data-procurement="{{ json_encode($procurement) }}">
        Print
    </button>
</div>
