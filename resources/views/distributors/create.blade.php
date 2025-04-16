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
                <h3 class="fw-bold m-0">User and Distributor Profile</h3>
            </div>
        </div>

        <form id="kt_modal_add_user_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
            action="{{ route('distributors.store') }}" method="POST">
            @csrf
            <div id="kt_account_settings_profile_details" class="collapse show">
                <div class="d-flex flex-column scroll-y px-5 px-lg-10">

                    <!-- User Profile Fields -->
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Nama Pengguna</label>
                        <input type="text" name="username" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Nama Pengguna" value="{{ old('username') }}" required>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="contoh@email.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">Kata Sandi <small class="text-muted">(Biarkan kosong jika tidak
                                ingin mengganti)</small></label>
                        <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Kata Sandi Baru">
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Nomor Telepon</label>
                        <input type="text" name="phone_number" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Nomor Telepon" value="{{ old('phone_number') }}" required>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Status</label>
                        <div class="d-flex align-items-center">
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" name="status" type="checkbox" id="status_toggle"
                                    value="1" {{ old('status') ? 'checked' : '' }}>
                                <span class="form-check-label">
                                    <div class="fw-bold text-gray-800">Aktif</div>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Distributor Profile Fields -->
                    <div id="distributor_fields">
                        <div class="row mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="required fw-semibold fs-6 mb-2">Nama Lengkap</label>
                                <input type="text" name="full_name" class="form-control form-control-solid"
                                    value="{{ old('full_name') }}" required>
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Telepon Utama</label>
                                <input type="text" name="primary_phone" class="form-control form-control-solid"
                                    value="{{ old('primary_phone') }}">
                            </div>
                        </div>

                        <div class="row mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Email Distributor</label>
                                <input type="email" name="distributor_email" class="form-control form-control-solid"
                                    value="{{ old('distributor_email') }}">
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Kode Agen <span
                                        class="text-muted">(Opsional)</span></label>
                                <input type="text" name="agent_code" class="form-control form-control-solid"
                                    value="{{ old('agent_code') }}">
                            </div>
                        </div>

                        <div class="row mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="fw-semibold fs-6 mb-2">URL Google Maps</label>
                                <input type="text" name="google_maps_url" class="form-control form-control-solid"
                                    value="{{ old('google_maps_url') }}">
                            </div>
                        </div>

                        <div class="row mb-7">
                            <div class="col-12 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Alamat</label>
                                <textarea name="address" class="form-control form-control-solid" rows="3">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <div class="col-12 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Opsi</label>
                                <div class="d-flex gap-5 align-items-center">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input id="is_cod" class="form-check-input" type="checkbox" name="is_cod"
                                            value="1" {{ old('is_cod') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_cod">Bayar di Tempat (COD)</label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input id="is_shipping" class="form-check-input" type="checkbox"
                                            name="is_shipping" value="1" {{ old('is_shipping') ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="is_shipping">Dukungan Pengiriman</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-7" id="shipping-methods-wrapper">
                            <div class="col-12 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Metode Pengiriman Tersedia</label>
                                <div class="d-flex flex-wrap gap-4">
                                    @foreach ($shipments as $shipment)
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="shipping_methods[]"
                                                id="shipment_{{ $shipment->id }}" value="{{ $shipment->id }}">
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
                                <label class="fw-semibold fs-6 mb-2">Provinsi</label>
                                <select id="province" name="province_id" class="form-select form-select-solid"
                                    data-control="select2" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Kabupaten/Kota</label>
                                <select id="regency" name="regency_id" class="form-select form-select-solid"
                                    data-control="select2" required>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <div class="col-md-6 fv-row">
                                <label class="fw-semibold fs-6 mb-2">Kecamatan</label>
                                <select id="district" name="district_id" class="form-select form-select-solid"
                                    data-control="select2" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <div class="col-12">
                                <label class="fw-semibold fs-6 mb-2">Marketplace</label>
                                <div class="d-flex flex-column gap-4">
                                    @foreach ($marketPlaces as $marketPlace)
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input toggle-marketplace" type="checkbox"
                                                    name="market_places[{{ $marketPlace->id }}][enabled]" value="1"
                                                    id="marketplace_{{ $marketPlace->id }}">
                                                <label class="form-check-label" for="marketplace_{{ $marketPlace->id }}">
                                                    {{ $marketPlace->name }}
                                                </label>
                                            </div>
                                            <input type="url" name="market_places[{{ $marketPlace->id }}][url]"
                                                class="form-control form-control-solid marketplace-url flex-grow-1"
                                                placeholder="URL untuk {{ $marketPlace->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('users.index') }}" class="btn btn-light me-3">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan</span>
                    </button>
                </div>
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

                // Initial state
                const urlInput = checkbox.closest('.d-flex').querySelector('.marketplace-url');
                urlInput.style.display = checkbox.checked ? 'block' : 'none';
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shippingCheckboxes = document.querySelectorAll('input[name="shipping_methods[]"]');
            const isShippingCheckbox = document.getElementById('is_shipping');

            function updateShippingSupportCheckbox() {
                const anyChecked = Array.from(shippingCheckboxes).some(cb => cb.checked);
                isShippingCheckbox.checked = anyChecked;
            }

            updateShippingSupportCheckbox();
            shippingCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateShippingSupportCheckbox);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            function loadOptions(url, targetSelect, defaultOption = 'Select') {
                $.get(url, function(res) {
                    if (res.status) {
                        let options =
                            `<option value="">${defaultOption} ${res.level.charAt(0).toUpperCase() + res.level.slice(1)}</option>`;
                        res.data.forEach(function(item) {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });
                        $(targetSelect).html(options).trigger('change');
                    }
                });
            }

            $('#province').on('change', function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    loadOptions(`{{ url('/list-of-area') }}?province_id=${provinceId}`, '#regency');
                    $('#district').html('<option value="">Select District</option>');
                }
            });

            $('#regency').on('change', function() {
                let regencyId = $(this).val();
                if (regencyId) {
                    loadOptions(`{{ url('/list-of-area') }}?regency_id=${regencyId}`, '#district');
                }
            });

            @if (old('regency_id', $user->distributor->regency_id ?? null))
                loadOptions(
                    `{{ url('/api/areas') }}?province_id={{ old('province_id', $user->distributor->province_id ?? '') }}`,
                    '#regency');
            @endif
            @if (old('district_id', $user->distributor->district_id ?? null))
                loadOptions(
                    `{{ url('/api/areas') }}?regency_id={{ old('regency_id', $user->distributor->regency_id ?? '') }}`,
                    '#district');
            @endif
        });
    </script>
@endpush
