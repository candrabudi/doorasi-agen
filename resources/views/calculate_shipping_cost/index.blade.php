@extends('layouts.app')

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar  pt-7 pt-lg-10 ">
        <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex align-items-stretch ">
            <div class="d-flex flex-stack flex-row-fluid">
                <div class="d-flex flex-column flex-row-fluid">
                    <div class="page-title d-flex align-items-center gap-1 me-3">
                        <span class="text-gray-900 fw-bolder fs-2x lh-1">
                            Pengiriman
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
                                Cek Ongkos Kirim
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
        <div class="card-header border-0 pt-6">
            <h3 class="card-title">Cari Agen Terdekat</h3>
        </div>
        <div class="card-body py-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Cari Agen Terdekat</h5>
                        </div>
                        <div class="card-body">
                            <form id="form-cari-agen">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <select id="provinsi" name="province_id" class="form-select">
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="regency" class="form-label">Kabupaten/Kota</label>
                                    <select id="regency" name="regency_id" class="form-select">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="district" class="form-label">Kecamatan</label>
                                    <select id="district" name="district_id" class="form-select">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Cari Agen Terdekat</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div id="hasil-agen" class="row g-3">
                        <!-- Agen cards will be inserted here -->
                    </div>

                    <!-- Berat Barang dan Tombol Kalkulasi Ongkir akan muncul setelah agen dipilih -->
                    <div id="berat-dan-ongkir" style="display: none;">
                        <div class="mb-3">
                            <label for="weight" class="form-label">Berat Barang (KG)</label>
                            <input type="number" id="weight" name="weight" class="form-control"
                                placeholder="Masukkan berat barang" required min="1">
                        </div>
                        <button id="btn-kalkulasi-ongkir" class="btn btn-success w-100" onclick="calculateShippingCost()"
                            disabled>
                            Kalkulasi Ongkir
                        </button>
                    </div>
                </div>
            </div>
            <div id="shipping-options" class="row mt-4">
                <!-- Shipping options cards will appear here -->
            </div>
        </div>

    </div>

    <style>
        /* Gaya untuk card agen umum */
        .card.agen-card:hover {
            transition: transform 0.3s ease-in-out;
        }

        .card.agen-card .card-body {
            cursor: pointer;
        }

        .card.agen-card:hover .card-body {
            background-color: #f7f7f7;
        }

        /* Gaya untuk card agen rekomendasi */
        .card.recommended-card {
            border: 3px solid #ff9800;
            background-color: #fff3e0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            /* Tambahkan untuk mengatur posisi label */
        }

        /* Label "Rekomendasi" agar tidak menutupi nama */
        .card.recommended-card .recommended-label {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #ff9800;
            color: white;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            z-index: 1;
        }


        #shipping-options {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .shipping-card-wrapper {
            position: relative;
        }

        .shipping-card {
            border-radius: 12px;
            padding: 16px;
            border: 1px solid #ccc;
            background-color: #ffffff;
        }

        .shipping-card-recommended {
            border: 2px solid #7e57c2;
            background-color: #ede7f6;
        }

        /* Label "Rekomendasi" */
        .shipping-recommend-label {
            position: absolute;
            top: -10px;
            left: -10px;
            background-color: #7e57c2;
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
            z-index: 1;
        }

        .shipping-card-body {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .shipping-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .shipping-card-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
            color: #333;
        }

        .shipping-card-text {
            font-size: 14px;
            margin-bottom: 2px;
            color: #555;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #shipping-options {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            #shipping-options {
                grid-template-columns: 1fr;
            }

            .shipping-card-body {
                flex-direction: column;
                text-align: center;
            }

            .shipping-logo {
                margin-bottom: 10px;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let selectedAgentId = null;

            function fetchProvinces() {
                fetch('/calculate-shipping-cost/provinces')
                    .then(res => res.json())
                    .then(data => populateSelect('provinsi', data));
            }

            function populateSelect(selectId, data) {
                const selectElement = document.getElementById(selectId);
                selectElement.innerHTML = `<option value="">Pilih</option>`;
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.text = item.name;
                    selectElement.appendChild(option);
                });
            }

            document.getElementById('provinsi').addEventListener('change', function() {
                const provinceId = this.value;
                if (provinceId) {
                    fetch(`/calculate-shipping-cost/regencies?province_id=${provinceId}`)
                        .then(res => res.json())
                        .then(data => populateSelect('regency', data));
                    resetSelect('district');
                }
            });

            document.getElementById('regency').addEventListener('change', function() {
                const regencyId = this.value;
                if (regencyId) {
                    fetch(`/calculate-shipping-cost/districts?regency_id=${regencyId}`)
                        .then(res => res.json())
                        .then(data => populateSelect('district', data));
                } else {
                    resetSelect('district');
                }
            });

            function resetSelect(selectId) {
                const selectElement = document.getElementById(selectId);
                selectElement.innerHTML = `<option value="">Pilih Kecamatan</option>`;
            }

            // Handle form submit to fetch agents
            document.getElementById('form-cari-agen').addEventListener('submit', function(e) {
                e.preventDefault();
                const districtId = document.getElementById('district').value;
                if (!districtId) {
                    alert('Silakan pilih kecamatan terlebih dahulu.');
                    return;
                }

                fetch(`/calculate-shipping-cost/distributors/nearby?district_id=${districtId}`)
                    .then(res => res.json())
                    .then(data => {
                        displayDistributors(data);
                    });
            });

            function displayDistributors(data) {
                const container = document.getElementById('hasil-agen');
                container.innerHTML = '';

                if (data.length === 0) {
                    container.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-warning">Tidak ada agen ditemukan di dekat Anda.</div>
                    </div>`;
                } else {
                    data.forEach((d, index) => {
                        if (index === 0) {
                            container.innerHTML += createRecommendedAgentCard(d);
                            selectAgent(d.id); // Pilih agen pertama
                        } else {
                            container.innerHTML += createAgentCard(d);
                        }
                    });
                }
            }

            function createAgentCard(d) {
                return `
                <div class="col-md-4 col-lg-4">
                    <div class="card agen-card shadow-sm h-100" onclick="selectAgent(${d.id})">
                        <div class="card-body">
                            <h5 class="card-title">${d.full_name}</h5>
                            <p class="card-text">${d.address || '-'}</p>
                            <p class="card-text"><strong>Telp:</strong> ${d.primary_phone || '-'}</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="agen" id="agen-${d.id}" value="${d.id}">
                                <label class="form-check-label" for="agen-${d.id}">
                                    Pilih Agen
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            }

            function createRecommendedAgentCard(d) {
                return `
        <div class="col-md-4 col-lg-4">
            <div class="card agen-card recommended-card shadow-sm h-100" onclick="selectAgent(${d.id})">
                <div class="recommended-label">Rekomendasi</div>
                <div class="card-body">
                    <h5 class="card-title">${d.full_name}</h5>
                    <p class="card-text">${d.address || '-'}</p>
                    <p class="card-text"><strong>Telp:</strong> ${d.primary_phone || '-'}</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="agen" id="agen-${d.id}" value="${d.id}">
                        <label class="form-check-label" for="agen-${d.id}">
                            Pilih Agen
                        </label>
                    </div>
                </div>
            </div>
        </div>
    `;
            }


            window.selectAgent = function(agentId) {
                selectedAgentId = agentId;
                const radioButton = document.getElementById(`agen-${agentId}`);
                if (radioButton) {
                    radioButton.checked = true;
                }
                // Menampilkan form berat dan tombol kalkulasi ongkir setelah agen dipilih
                document.getElementById('berat-dan-ongkir').style.display = 'block';
                document.getElementById('btn-kalkulasi-ongkir').disabled = false;
            };

            window.calculateShippingCost = function() {
                const districtId = document.getElementById('district').value;
                const weight = document.getElementById('weight').value; // Ambil berat barang
                if (!weight || weight <= 0) {
                    alert('Silakan masukkan berat barang yang valid.');
                    return;
                }

                fetch(
                        `/calculate-shipping-cost/calculate?district_id=${districtId}&weight=${weight}&agent_id=${selectedAgentId}`
                    )
                    .then(res => res.json())
                    .then(data => {
                        if (data && Array.isArray(data) && data.length > 0) {
                            displayShippingOptions(data);
                        } else {
                            alert('Gagal menghitung ongkir.');
                        }
                    });
            };

            function displayShippingOptions(data) {
                const container = document.getElementById('shipping-options');
                container.innerHTML = '';

                data.forEach((option, index) => {
                    const isRecommended = index === 0;
                    const bgColor = isRecommended ? '#ede7f6' : '#ffffff';

                    const card = `
            <div class="shipping-card-wrapper">
                <div class="shipping-card ${isRecommended ? 'shipping-card-recommended' : ''}" style="background-color: ${bgColor};">
                    ${isRecommended ? '<div class="shipping-recommend-label">Rekomendasi</div>' : ''}
                    <div class="shipping-card-body d-flex align-items-center">
                        <img src="${option.logistic_logo_url}" alt="${option.logistic_name}" class="shipping-logo me-3" />
                        <div>
                            <h5 class="shipping-card-title">${option.logistic_name}</h5>
                            <p class="shipping-card-text"><strong>Tarif:</strong> ${option.rate_name}</p>
                            <p class="shipping-card-text"><strong>Durasi:</strong> ${option.duration} ${option.duration_type}</p>
                            <p class="shipping-card-text"><strong>Harga:</strong> Rp ${option.shipment_price.toLocaleString()}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
                    container.innerHTML += card;
                });
            }

            fetchProvinces();
        });
    </script>
@endsection
