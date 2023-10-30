<form action="{{ route('password.update') }}" method="post">
    @csrf
    @method('put')
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Password" required>
            <label for="current_password">Current Password</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            <label for="password">New Password</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-floating">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password" required>
            <label for="password_confirmation">Confirm Password</label>
        </div>
    </div>
    <div class="col-md-6 mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-pill btn-success">Save</button>
    </div>
</form>
