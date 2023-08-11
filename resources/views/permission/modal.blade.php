<!-- Modal Create -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('permission.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createPermissionModalLabel">Create Permission Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label required">Permission Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Input Permission Name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="guard_name" class="form-label required">Guard Name</label>
                        <input type="text" class="form-control" id="guard_name" name="guard_name" placeholder="Input Guard Name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
