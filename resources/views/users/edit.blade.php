@extends('layouts.app')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  pt-7 pt-lg-10 ">
        <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex align-items-stretch ">
            <div class="d-flex flex-stack flex-row-fluid">
                <div class="d-flex flex-column flex-row-fluid">
                    <div class="page-title d-flex align-items-center gap-1 me-3">
                        <span class="text-gray-900 fw-bolder fs-2x lh-1">
                            Users
                        </span>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base ms-3 d-flex mb-0">
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                <a href="index-2.html" class="text-gray-700 text-hover-primary">
                                    <i class="ki-duotone ki-home fs-3 text-gray-500 ms-2"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item mx-n1">
                                <i class="ki-duotone ki-right fs-4 text-gray-700"></i>
                            </li>
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                User List
                            </li>
                            <li class="breadcrumb-item mx-n1">
                                <i class="ki-duotone ki-right fs-4 text-gray-700"></i>
                            </li>
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                User Edit
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-body py-4">
        <div id="kt_table_users_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <form id="kt_modal_add_user_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!--begin::Scroll-->
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                    data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px"
                    style="max-height: 611px;">

                    <!-- Username -->
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Username</label>
                        <input type="text" name="username" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Username" value="{{ old('username', $user->username) }}" required>
                    </div>

                    <!-- Email -->
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="example@domain.com" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- Password -->
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">Password <small class="text-muted">(Leave blank to keep current)</small></label>
                        <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="New Password">
                    </div>

                    <!-- Phone Number -->
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Phone Number" value="{{ old('phone_number', $user->phone_number) }}" required>
                    </div>

                    <!-- Role -->
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Role</label>
                        <div class="d-flex fv-row">
                            <div class="form-check form-check-custom form-check-solid me-5">
                                <input class="form-check-input me-3" name="role" type="radio" value="admin"
                                    id="role_admin" {{ $user->role === 'admin' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_admin">
                                    <div class="fw-bold text-gray-800">Administrator</div>
                                </label>
                            </div>

                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input me-3" name="role" type="radio" value="distributor"
                                    id="role_distributor" {{ $user->role === 'distributor' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_distributor">
                                    <div class="fw-bold text-gray-800">Distributor</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Status</label>
                        <div class="d-flex align-items-center">
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" name="status" type="checkbox" id="status_toggle"
                                    value="1" {{ $user->status ? 'checked' : '' }}>
                                <span class="form-check-label">
                                    <div class="fw-bold text-gray-800">Active</div>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="text-left pt-10">
                        <a href="{{ route('users.index') }}" class="btn btn-light me-3">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Update</span>
                            <span class="indicator-progress">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection