<!-- resources/views/superadmin/announcements/create.blade.php -->
<form method="POST" action="{{ route('superadmin.announcements.store') }}">
    @csrf
    
    <!-- Title -->
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    
    <!-- Message -->
    <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
    </div>
    
    <!-- Visibility -->
    <div class="mb-3">
        <label class="form-label">Visible To</label>
        <select class="form-select" name="visible_to" required>
            <option value="all">Everyone</option>
            <option value="teachers">Teachers Only</option>
            <option value="students">Students Only</option>
            <option value="admins">Admins Only</option>
            <option value="atc">ATC Only</option>
        </select>
    </div>
    
    <!-- Active Status -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
    
    <!-- Date Range -->
    <div class="row mb-3">
        <div class="col">
            <label for="start_at" class="form-label">Start Date (optional)</label>
            <input type="datetime-local" class="form-control" id="start_at" name="start_at">
        </div>
        <div class="col">
            <label for="end_at" class="form-label">End Date (optional)</label>
            <input type="datetime-local" class="form-control" id="end_at" name="end_at">
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Create Announcement</button>
</form>