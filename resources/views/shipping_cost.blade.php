<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cek Ongkir | Agen Doorasi</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/logo.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body {
            background-color: #f9f9f9;
        }

        .card {
            border-radius: 1rem;
        }

        .search-results {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            margin-top: 5px;
            border-radius: 4px;
            background-color: white;
            position: absolute;
            width: 100%;
            z-index: 999;
        }

        .search-results li {
            padding: 8px;
            cursor: pointer;
            list-style: none;
        }

        .search-results li:hover {
            background-color: #f0f0f0;
        }

        .shipping-rate-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .shipping-rate-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        .shipping-rate-card img {
            max-width: 100%;
            height: auto;
        }

        .shipping-rate-card.recommended {
            border: 2px solid #28a745;
            background-color: #e8fff0;
        }

        .recommended-label {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background-color: #2ecc71;
            color: #000;
            font-size: 0.8rem;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 0.5rem;
        }

        @media (max-width: 576px) {
            #shippingRatesContainer {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            #shippingRatesContainer .col {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .form-label {
                font-size: 14px;
            }
        }
    </style>

    <style>
        .search-results {
            max-height: 200px;
            overflow-y: auto;
            border-radius: 8px;
            background-color: #ffffff;
            position: absolute;
            width: 100%;
            z-index: 999;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .search-results li {
            padding: 12px;
            cursor: pointer;
            list-style: none;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .search-results li:hover {
            background-color: #f9f9f9;
        }

        .search-results li:active {
            background-color: #e0e0e0;
        }

        .search-results li .location-name {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .search-results li .location-detail {
            font-size: 12px;
            color: #666;
        }

        .search-results {
            display: none;
        }
    </style>

    <style>
        #searchInput {
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease;
        }

        #searchInput:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.3);
        }

        #loadingIndicator {
            display: none;
            margin-top: 20px;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.3rem;
        }

        @media (max-width: 576px) {
            #searchInput {
                font-size: 14px;
            }

            .spinner-border {
                width: 2rem;
                height: 2rem;
            }
        }
    </style>


</head>

<body>
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div id="kt_app_content_container" class="app-container  container-fluid ">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <div class="bg-white rounded-4 shadow-sm p-4">
                        <h2 class="fw-bold text-center mb-4">🚚 Cek Ongkir & Cari Agen</h2>
                        <div class="row g-4">
                            <div class="col-12 col-lg-4">
                                <div class="bg-light p-4 rounded-3 shadow-sm h-100">
                                    <h5 class="mb-4 fw-semibold">📍 Tujuan & Berat Barang</h5>

                                    <div class="mb-3 position-relative">
                                        <label for="destination" class="form-label">Alamat Tujuan</label>
                                        <input type="text" id="destination" class="form-control"
                                            placeholder="Ketik alamat...">
                                        <ul id="search-results"
                                            class="search-results list-group position-absolute w-140 z-1"
                                            style="display: none;"></ul>
                                    </div>

                                    <div class="mb-3">
                                        <label for="weight" class="form-label">Berat Barang (KG)</label>
                                        <input type="number" id="weight" class="form-control"
                                            placeholder="Contoh: 2" value="1" min="1" required>
                                    </div>

                                    <input type="hidden" id="selected-location" name="selected_location"
                                        value='{"sub_district_id":1,"district":"Kecamatan A","city":"Kota B","province":"Provinsi C"}'>

                                    <input type="hidden" id="province_id">
                                    <input type="hidden" id="city_id">
                                    <input type="hidden" id="district_id">
                                    <input type="hidden" id="sub_district_id">
                                    <input type="hidden" id="postal_code">
                                    <input type="hidden" id="province">
                                    <input type="hidden" id="city">
                                    <input type="hidden" id="city_short">
                                    <input type="hidden" id="district">
                                    <input type="hidden" id="sub_district">

                                    <button id="cek-ongkir-btn" class="btn btn-success w-100 mt-3">Cek Ongkir</button>
                                </div>
                            </div>


                            <div class="col-12 col-lg-8">
                                <div
                                    class="d-flex justify-content-between align-items-center mb-3 flex-column flex-sm-row gap-2">
                                    <div class="btn-group" role="group">
                                        <button type="button" id="sortByDistance" class="btn btn-primary">📍 Jarak
                                            Terdekat</button>
                                        <button type="button" id="sortByPrice" class="btn btn-outline-success">💰
                                            Ongkir Termurah</button>
                                    </div>
                                </div>

                                <ul id="rateTabs" class="nav nav-pills mb-3 justify-content-center">
                                    <li class="nav-item">
                                        <button class="nav-link" data-filter="All">All</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link active" data-filter="JNE">JNE</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-filter="J&T Express">J&T Express</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-filter="ID Express">IDEXPRESS</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-filter="SAP Logistic">SAP Logistic</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-filter="SiCepat">SICEPAT</button>
                                    </li>
                                </ul>

                                <div id="loadingIndicator" class="text-center mt-3" style="display: none;">
                                    <div class="spinner-border text-success" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>

                                <div id="shippingRatesContainer"
                                    class="row g-3 row-cols-1 row-cols-sm-2 row-cols-lg-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function debounce(func, delay) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(this, args), delay);
            };
        }

        const fetchLocation = debounce(function() {
            const destination = document.getElementById('destination').value.trim();
            const resultsContainer = document.getElementById('search-results');

            if (destination.length < 3) {
                resultsContainer.style.display = 'none';
                return;
            }

            const encodedDestination = encodeURIComponent(destination);
            fetch(`https://popaket.com/service/logistic/v2/public/location?name=${encodedDestination}`, {
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Use-Api-Key': 'true'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const locations = data?.data?.locations || [];
                    resultsContainer.innerHTML = '';

                    if (locations.length > 0) {
                        locations.forEach(location => {
                            const listItem = document.createElement('li');
                            listItem.innerHTML = `
                                <div class="location-name">${location.name}</div>
                                <div class="location-detail">${location.district}, ${location.city}, ${location.province}</div>
                            `;
                            listItem.dataset.province = location.province;
                            listItem.dataset.city = location.city;
                            listItem.dataset.district = location.district;
                            listItem.dataset.sub_district = location.sub_district;
                            listItem.dataset.postal_code = location.postal_code;
                            listItem.dataset.province_id = location.province_id;
                            listItem.dataset.city_id = location.city_id;
                            listItem.dataset.district_id = location.district_id;
                            listItem.dataset.sub_district_id = location.sub_district_id;
                            listItem.dataset.postal_code = location.postal_code;

                            resultsContainer.appendChild(listItem);

                            listItem.addEventListener('click', function() {
                                document.getElementById('destination').value = location.name;
                                resultsContainer.style.display = 'none';
                                document.getElementById('province_id').value = location
                                    .province_id;
                                document.getElementById('city_id').value = location.city_id;
                                document.getElementById('district_id').value = location
                                    .district_id;
                                document.getElementById('sub_district_id').value = location
                                    .sub_district_id;
                                document.getElementById('postal_code').value = location
                                    .postal_code;
                                const selectedLocation = {
                                    name: location.name,
                                    province_id: location.province_id,
                                    city_id: location.city_id,
                                    district_id: location.district_id,
                                    sub_district_id: location.sub_district_id,
                                    postal_code: location.postal_code,
                                    province: location.province,
                                    city: location.city,
                                    city_short: location.city_short,
                                    district: location.district,
                                    sub_district: location.sub_district
                                };
                                document.getElementById('selected-location').value = JSON
                                    .stringify(selectedLocation);
                            });
                        });

                        resultsContainer.style.display = 'block';
                    } else {
                        resultsContainer.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    resultsContainer.innerHTML =
                        '<li class="text-danger">Terjadi kesalahan saat memuat data.</li>';
                    resultsContainer.style.display = 'block';
                });
        }, 500);

        document.getElementById('destination').addEventListener('input', fetchLocation);

        document.addEventListener('click', function(e) {
            const resultsContainer = document.getElementById('search-results');
            if (!resultsContainer.contains(e.target) && e.target !== document.getElementById('destination')) {
                resultsContainer.style.display = 'none';
            }
        });
    </script>

    <script>
        const cekOngkirBtn = document.getElementById('cek-ongkir-btn');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const container = document.getElementById('shippingRatesContainer');
        const rateTabs = document.getElementById('rateTabs');

        const sortByDistanceBtn = document.getElementById('sortByDistance');
        const sortByPriceBtn = document.getElementById('sortByPrice');

        let originalData = [];
        let currentTab = 'JNE';
        let sortMode = 'distance';

        cekOngkirBtn.addEventListener('click', function(e) {
            e.preventDefault();

            const destination = document.getElementById('destination').value.trim();
            const weight = document.getElementById('weight').value.trim();
            const selectedLocationRaw = document.getElementById('selected-location').value;

            if (!destination || !weight || !selectedLocationRaw) {
                alert('Harap lengkapi semua data sebelum melakukan cek ongkir.');
                return;
            }

            let selectedLocation;
            try {
                selectedLocation = JSON.parse(selectedLocationRaw);
            } catch (err) {
                alert('Data lokasi tidak valid!');
                return;
            }

            const params = new URLSearchParams({
                sub_district_id: selectedLocation.sub_district_id,
                district: selectedLocation.district,
                city: selectedLocation.city,
                province: selectedLocation.province,
                weight: weight
            });

            loadingIndicator.style.display = 'block';
            container.innerHTML = '';

            fetch('/cek-ongkir/process?' + params.toString(), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    originalData = data;
                    filterAndRender();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat melakukan perhitungan ongkir.');
                })
                .finally(() => {
                    loadingIndicator.style.display = 'none';
                });
        });

        function filterAndRender() {
            let filtered = [...originalData];

            if (currentTab !== 'All') {
                filtered = filtered.filter(rate => rate.logistic_name === currentTab);
            }

            if (sortMode === 'distance') {
                filtered.sort((a, b) => a.distance_km - b.distance_km);
            } else {
                filtered.sort((a, b) => a.shipment_price - b.shipment_price);
            }

            renderCards(filtered);
        }

        function renderCards(data) {
            container.innerHTML = '';

            if (!Array.isArray(data) || data.length === 0) {
                container.innerHTML = '<div class="col-12 text-center text-muted">Tidak ada data ongkir ditemukan.</div>';
                return;
            }

            const minPrice = Math.min(...data.map(r => r.shipment_price));

            data.forEach(rate => {
                const col = document.createElement('div');
                col.className = 'col';

                const card = document.createElement('div');
                card.classList.add('shipping-rate-card', 'card', 'p-3', 'h-100', 'shadow-sm', 'position-relative');

                if (rate.shipment_price === minPrice) {
                    const label = document.createElement('div');
                    label.classList.add('recommended-label');
                    label.textContent = '⭐ Rekomendasi';
                    card.appendChild(label);
                }

                const logo = document.createElement('img');
                logo.src = rate.logistic_logo_url;
                logo.classList.add('mb-2');
                logo.style.width = '100px';
                card.appendChild(logo);

                const logisticName = document.createElement('div');
                logisticName.classList.add('logistic-name', 'fw-bold');
                logisticName.textContent = rate.logistic_name + ' - ' + rate.rate_name;
                card.appendChild(logisticName);

                const shipmentPrice = document.createElement('div');
                shipmentPrice.classList.add('shipment-price', 'text-danger', 'fw-bold', 'fs-4');
                shipmentPrice.textContent = `Rp ${rate.shipment_price.toLocaleString()}`;
                card.appendChild(shipmentPrice);

                const duration = document.createElement('div');
                duration.classList.add('duration', 'text-muted');
                duration.textContent = `Estimasi: ${rate.duration} ${rate.duration_type.toLowerCase()}`;
                card.appendChild(duration);

                const distributor = document.createElement('div');
                distributor.classList.add('distributor', 'mt-2');
                distributor.textContent = `Distributor: ${rate.distributor_name}`;
                card.appendChild(distributor);

                const address = document.createElement('div');
                address.classList.add('address');
                address.textContent = `Alamat: ${rate.province_name}, ${rate.regency_name}, ${rate.district_name}`;
                card.appendChild(address);

                const distance_location = document.createElement('div');
                distance_location.classList.add('distance_location', 'fw-bold');
                distance_location.textContent = `Jarak: ${rate.distance_km} KM`;
                card.appendChild(distance_location);

                const phone = document.createElement('div');
                phone.classList.add('phone');
                phone.textContent = `Kontak: ${rate.primary_phone}`;
                card.appendChild(phone);

                col.appendChild(card);
                container.appendChild(col);
            });
        }

        rateTabs.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON') {
                const buttons = rateTabs.querySelectorAll('.nav-link');
                buttons.forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');
                currentTab = e.target.dataset.filter;
                filterAndRender();
            }
        });

        sortByDistanceBtn.addEventListener('click', function() {
            sortMode = 'distance';
            sortByDistanceBtn.classList.add('btn-primary');
            sortByDistanceBtn.classList.remove('btn-outline-primary');
            sortByPriceBtn.classList.remove('btn-success');
            sortByPriceBtn.classList.add('btn-outline-success');
            filterAndRender();
        });

        sortByPriceBtn.addEventListener('click', function() {
            sortMode = 'price';
            sortByPriceBtn.classList.add('btn-success');
            sortByPriceBtn.classList.remove('btn-outline-success');
            sortByDistanceBtn.classList.remove('btn-primary');
            sortByDistanceBtn.classList.add('btn-outline-primary');
            filterAndRender();
        });

        window.addEventListener('DOMContentLoaded', () => {
            sortByDistanceBtn.classList.add('btn-primary');
            sortByDistanceBtn.classList.remove('btn-outline-primary');
            document.querySelector('#rateTabs button[data-filter="JNE"]').classList.add('active');
        });
    </script>


    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>

</html>
