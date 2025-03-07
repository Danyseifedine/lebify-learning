<div class="card container card-bg mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ __('common.settings') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->

    <!--begin::Content-->
    <div id="kt_account_settings_profile_details" class="collapse show">

        <!--begin::Form-->
        <form form-id="settings-form" http-request route="{{ route('students.profile.settings.update') }}"
            identifier="single-form-post-handler" feedback success-toast on-success="clearForm">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <div class="col-lg-12">
                        <label
                            class="col-lg-12 col-form-label required fw-semibold fs-6">{{ __('common.old_password') }}</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-12 fv-row fv-plugins-icon-container">
                            <input type="password" name="password" feedback-id="password-feedback-x"
                                class="form-control form-control-lg input-bg-in-card mb-3 mb-lg-0"
                                placeholder="{{ __('common.old_password') }}...">
                            <div id="password-feedback-x" class="invalid-feedback"></div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="col-lg-12 mt-3">
                        <label
                            class="col-lg-12 col-form-label required fw-semibold fs-6">{{ __('common.new_password') }}</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-12 fv-row fv-plugins-icon-container">
                            <input type="password" name="new-password" feedback-id="new-password-feedback-x"
                                class="form-control form-control-lg input-bg-in-card mb-3 mb-lg-0"
                                placeholder="{{ __('common.new_password') }}...">
                            <div id="new-password-feedback-x" class="invalid-feedback"></div>
                        </div>
                        <!--end::Col-->
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Input group-->
        </form>
    </div>
    <!--end::Card body-->

    <!--begin::Actions-->
    <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="submit" class="btn bg-logo"
            submit-form-id="settings-form">{{ __('common.save_changes') }}</button>
    </div>
    <!--end::Form-->
</div>
<!--end::Content-->
</div>
