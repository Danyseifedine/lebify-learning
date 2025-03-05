<form id="create-user-form" form-id="createForm" http-request route="{{ route('dashboard.users.store') }}"
    identifier="single-form-post-handler" feedback close-modal success-toast on-success="RDT">

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" feedback-id="name-feedback" placeholder="Enter Name" class="form-control form-control-solid"
            name="name" id="name">
        <div id="name-feedback" class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" feedback-id="email-feedback" placeholder="Enter Email"
            class="form-control form-control-solid" name="email" id="email">
        <div id="email-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" feedback-id="phone-feedback" placeholder="Enter Phone"
            class="form-control form-control-solid" name="phone" id="phone">
        <div id="phone-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="age" class="form-label">Age</label>
        <input type="number" feedback-id="age-feedback" placeholder="Enter Age" class="form-control form-control-solid"
            name="age" id="age">
        <div id="age-feedback" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" feedback-id="password-feedback" placeholder="Enter Password"
            class="form-control form-control-solid" name="password" id="password">
        <div id="password-feedback" class="invalid-feedback"></div>
    </div>
</form>
