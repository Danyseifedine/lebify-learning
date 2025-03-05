<form id="create-instructor-form" form-id="createForm" http-request
    route="{{ route('dashboard.users.instructors.store') }}" identifier="single-form-post-handler" feedback close-modal
    success-toast on-success="RDT">

    <div class="mb-3">
        <label for="user_id" class="form-label">User</label>
        <select name="user_id" id="user_id" data-control="select2" data-placeholder="Select User"
            feedback-id="user_id-feedback" class="form-select form-select-solid">
            <option value="">Select User</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        <div id="user_id-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="specialization" class="form-label">Specialization</label>
        <input type="text" class="form-control form-control-solid" placeholder="Enter Specialization"
            feedback-id="specialization-feedback" name="specialization" id="specialization">
        <div id="specialization-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="bio" class="form-label">Bio</label>
        <textarea name="bio" id="bio" class="form-control form-control-solid" placeholder="Enter Bio"
            feedback-id="bio-feedback"></textarea>
        <div id="bio-feedback" class="invalid-feedback"></div>
    </div>
</form>
