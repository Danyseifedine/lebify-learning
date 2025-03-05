<form id="edit-instructor-form" form-id="editForm" http-request route="{{ route('dashboard.users.instructors.update') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">
    <input type="hidden" name="id" id="id" value="{{ $instructor->id }}">

    <div class="mb-3">
        <label for="user_id" class="form-label">User</label>
        <select name="user_id" id="user_id" data-control="select2" data-placeholder="Select User"
            feedback-id="user_id-feedback" class="form-select form-select-solid">
            <option value="">Select User</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $instructor->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="specialization" class="form-label">Specialization</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter Specialization"
            feedback-id="specialization-feedback" name="specialization" id="specialization"
            value="{{ $instructor->specialization }}">
        <div id="specialization-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="bio" class="form-label">Bio</label>
        <textarea name="bio" id="bio" class="form-control form-control-solid" placeholder="Enter Bio"
            feedback-id="bio-feedback">{{ $instructor->bio }}</textarea>
        <div id="bio-feedback" class="invalid-feedback"></div>
    </div>
</form>
