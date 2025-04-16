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
                                Distributor List
                            </li>
                            <li class="breadcrumb-item mx-n1">
                                <i class="ki-duotone ki-right fs-4 text-gray-700"></i>
                            </li>
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                Distributor Edit
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">User Profile</h3>
            </div>
        </div>
        <form id="kt_modal_add_user_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
            action="{{ route('users.update', $user->id) }}" method="POST">
            <div id="kt_account_settings_profile_details" class="collapse show">
                @csrf
                @method('PUT')
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true"
                    data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px"
                    style="max-height: 611px;">

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Username</label>
                        <input type="text" name="username" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Username" value="{{ old('username', $user->username) }}" required>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="example@domain.com" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">Password <small class="text-muted">(Leave blank to keep
                                current)</small></label>
                        <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="New Password">
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Phone Number" value="{{ old('phone_number', $user->phone_number) }}" required>
                    </div>

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

                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('users.index') }}" class="btn btn-light me-3">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Update</span>
                    <span class="indicator-progress">
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>


    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Distributor Profile</h3>
            </div>
        </div>
        <form id="kt_modal_add_user_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
            action="{{ route('distributors.update', $user->id) }}" method="POST">
            <div id="kt_account_settings_profile_details" class="collapse show">
                @csrf
                @method('PUT')
                <div class="d-flex flex-column scroll-y px-5 px-lg-10">

                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                            <input type="text" name="full_name" class="form-control form-control-solid"
                                value="{{ old('full_name', $user->distributor->full_name ?? '') }}" required>
                        </div>

                        <div class="col-md-6 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Primary Phone</label>
                            <input type="text" name="primary_phone" class="form-control form-control-solid"
                                value="{{ old('primary_phone', $user->distributor->primary_phone ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Secondary Phone</label>
                            <input type="text" name="secondary_phone" class="form-control form-control-solid"
                                value="{{ old('secondary_phone', $user->distributor->secondary_phone ?? '') }}">
                        </div>

                        <div class="col-md-6 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Distributor Email</label>
                            <input type="email" name="distributor_email" class="form-control form-control-solid"
                                value="{{ old('distributor_email', $user->distributor->email ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Agent Code</label>
                            <input type="text" name="agent_code" class="form-control form-control-solid"
                                value="{{ old('agent_code', $user->distributor->agent_code ?? '') }}">
                        </div>

                        <div class="col-md-6 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Google Maps URL</label>
                            <input type="text" name="google_maps_url" class="form-control form-control-solid"
                                value="{{ old('google_maps_url', $user->distributor->google_maps_url ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-12 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Address</label>
                            <textarea name="address" class="form-control form-control-solid" rows="3">{{ old('address', $user->distributor->address ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-12 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Options</label>
                            <div class="d-flex gap-5 align-items-center">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input id="is_cod" class="form-check-input" type="checkbox" name="is_cod"
                                        value="1"
                                        {{ old('is_cod', $user->distributor->is_cod ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_cod">Cash on Delivery (COD)</label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid">
                                    <input id="is_shipping" class="form-check-input" type="checkbox" name="is_shipping"
                                        value="1"
                                        {{ old('is_shipping', $user->distributor->is_shipping ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_shipping">Shipping Support</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-7" id="shipping-methods-wrapper" style="display: none;">
                        <div class="col-12 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Available Shipping Methods</label>
                            <div class="d-flex flex-wrap gap-4">
                                @foreach ($shipments as $shipment)
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="shipping_methods[]"
                                            id="shipment_{{ $shipment->id }}" value="{{ $shipment->id }}"
                                            {{ collect(old('shipping_methods', $user->distributor->shipments->pluck('id')->toArray()))->contains($shipment->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="shipment_{{ $shipment->id }}">
                                            {{ $shipment->name }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Province</label>
                            <select id="province" name="province_id" class="form-select form-select-solid"
                                data-control="select2" required>
                                <option value="">Select Province</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ old('province_id', $user->distributor->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 fv-row">
                            <label class="fw-semibold fs-6 mb-2">Regency</label>
                            <select id="regency" name="regency_id" class="form-select form-select-solid"
                                data-control="select2" required>
                                <option value="">Select Regency</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="fw-semibold fs-6 mb-2">District</label>
                            <select id="district" name="district_id" class="form-select form-select-solid"
                                data-control="select2" required>
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mb-7">
                        <div class="col-12">
                            <label class="fw-semibold fs-6 mb-2">Marketplaces</label>
                            <div class="d-flex flex-column gap-4">
                                @foreach ($marketPlaces as $marketPlace)
                                    @php
                                        $existing = $user->distributor->marketPlaces->firstWhere(
                                            'id',
                                            $marketPlace->id,
                                        );
                                    @endphp
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input toggle-marketplace" type="checkbox"
                                                name="market_places[{{ $marketPlace->id }}][enabled]" value="1"
                                                id="marketplace_{{ $marketPlace->id }}"
                                                {{ old("market_places.{$marketPlace->id}.enabled", $existing ? true : false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="marketplace_{{ $marketPlace->id }}">
                                                {{ $marketPlace->name }}
                                            </label>
                                        </div>
                                        <input type="url" name="market_places[{{ $marketPlace->id }}][url]"
                                            class="form-control form-control-solid marketplace-url flex-grow-1"
                                            placeholder="URL for {{ $marketPlace->name }}"
                                            value="{{ old("market_places.{$marketPlace->id}.url", $existing->pivot->url ?? '') }}"
                                            style="{{ $existing ? '' : 'display:none;' }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('users.index') }}" class="btn btn-light me-3">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Update</span>
                    <span class="indicator-progress">
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.toggle-marketplace');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const urlInput = this.closest('.d-flex').querySelector('.marketplace-url');
                    urlInput.style.display = this.checked ? 'block' : 'none';
                });

                const urlInput = checkbox.closest('.d-flex').querySelector('.marketplace-url');
                urlInput.style.display = checkbox.checked ? 'block' : 'none';
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isShippingCheckbox = document.getElementById('is_shipping');
            const shippingWrapper = document.getElementById('shipping-methods-wrapper');

            function toggleShippingOptions() {
                shippingWrapper.style.display = isShippingCheckbox.checked ? 'block' : 'none';
            }

            toggleShippingOptions();
            isShippingCheckbox.addEventListener('change', toggleShippingOptions);
        });
    </script>
    <script>
        $(document).ready(function() {
            function loadOptions(url, targetSelect, selectedId = null, defaultOption = 'Select', callback = null) {
                $.get(url, function(res) {
                    if (res.status) {
                        let options =
                            `<option value="">${defaultOption} ${res.level.charAt(0).toUpperCase() + res.level.slice(1)}</option>`;
                        res.data.forEach(function(item) {
                            options +=
                                `<option value="${item.id}" ${selectedId == item.id ? 'selected' : ''}>${item.name}</option>`;
                        });
                        $(targetSelect).html(options).trigger('change');

                        if (callback && typeof callback === 'function') {
                            callback();
                        }
                    }
                });
            }

            $('#province').on('change', function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    loadOptions(`{{ url('/list-of-area') }}?province_id=${provinceId}`, '#regency', '',
                        'Select Regency');
                    $('#district').html('<option value="">Select District</option>');
                }
            });

            $('#regency').on('change', function() {
                let regencyId = $(this).val();
                if (regencyId) {
                    loadOptions(`{{ url('/list-of-area') }}?regency_id=${regencyId}`, '#district', '',
                        'Select District');
                }
            });

            const provinceId = `{{ old('province_id', $user->distributor->province_id ?? '') }}`;
            const regencyId = `{{ old('regency_id', $user->distributor->regency_id ?? '') }}`;
            const districtId = `{{ old('district_id', $user->distributor->district_id ?? '') }}`;

            if (provinceId) {
                loadOptions(`{{ url('/list-of-area') }}?province_id=${provinceId}`, '#regency', regencyId,
                    'Select Regency',
                    function() {
                        if (regencyId) {
                            loadOptions(`{{ url('/list-of-area') }}?regency_id=${regencyId}`, '#district',
                                districtId, 'Select District');
                        }
                    });
            }
        });
    </script>
@endpush
