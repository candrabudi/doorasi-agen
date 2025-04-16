<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
    <style>
        li {
            list-style: none;
        }

        .distributor-container {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .opt-location {
            font-size: 1rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 1rem;
        }

        .acnav__label {
            background-color: #ff4d4d;
            color: #FFF;
            font-size: 1rem;
            font-weight: 600;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            border: 1px solid #ffb8b8;
            transition: background-color 0.2s ease;
        }

        .acnav__label:hover {
            background-color: #ff3838;
        }

        .acnav__list--level2,
        .acnav__list--level3 {
            padding-left: 1rem;
            margin-bottom: 1rem;
        }

        .distributor-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin: 16px 0;
            padding: 24px;
            transition: box-shadow 0.2s ease-in-out;
            border: 1px solid #f1f1f1;
        }

        .distributor-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .distributor-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1c1e21;
            margin-bottom: 6px;
        }

        .address,
        .contact-shipping {
            font-size: 0.95rem;
            color: #606770;
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .contact-shipping a {
            color: #1877f2;
            text-decoration: none;
        }

        .contact-shipping a:hover {
            text-decoration: underline;
        }

        .btn-whatsapp {
            display: flex;
            align-items: center;
            background-color: #25D366;
            color: #fff;
            border-radius: 9999px;
            padding: 10px 18px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-whatsapp img {
            height: 18px;
            margin-right: 8px;
        }

        .btn-whatsapp:hover {
            background-color: #128C7E;
        }

        .chevron {
            transition: transform 0.3s ease;
        }

        .rotate {
            transform: rotate(180deg);
        }

        @media (max-width: 768px) {
            .distributor-card {
                padding: 16px;
            }

            .btn-whatsapp {
                font-size: 0.85rem;
                padding: 8px 14px;
            }

            .distributor-name {
                font-size: 1rem;
            }

            .distributor-container {
                /* padding: 0 12px; */
            }
        }

        .marketplace-links {
            margin-top: 12px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .marketplace-links a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #f0f2f5;
            border-radius: 9999px;
            padding: 8px 14px;
            font-size: 0.85rem;
            color: #050505;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid #ddd;
            transition: background-color 0.2s ease;
        }

        .marketplace-links a:hover {
            background-color: #e4e6eb;
        }

        .search-section {
            max-width: 700px;
            margin: 0 auto 2rem;
        }


        .label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 30px;
            padding: 8px 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 8px;
            font-size: 14px;
            background: transparent;
        }

        .icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            cursor: pointer;
        }

        .clear {
            margin-left: 8px;
        }

        .result-container {
            max-width: 700px;
            margin: 0 auto 2rem;
            border: 1px solid #ff4d4d;
            border-radius: 10px;
            overflow: hidden;
        }

        .result-item {
            padding: 12px 16px;
            background: white;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            color: #ff4d4d;
            font-weight: 500;
            transition: background 0.2s;
        }

        .result-item:hover {
            background: #fff5da;
        }

        .card-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }

        .distributor-card {
            border: 1px solid #ff4d4d;
            border-radius: 16px;
            margin-bottom: 20px;
            padding: 16px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }

        .card-header {
            display: flex;
            gap: 16px;
            margin-bottom: 12px;
        }

        .profile-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }

        .distributor-name {
            font-weight: bold;
            margin: 0;
        }

        .address {
            font-size: 14px;
            color: #666;
        }

        .map-link {
            text-decoration: underline;
            color: #007bff;
            font-size: 14px;
        }

        .card-body p {
            font-size: 14px;
            margin: 6px 0;
        }

        .marketplace-icons img {
            width: 32px;
            margin-right: 8px;
        }

        .card-footer {
            margin-top: 10px;
            text-align: right;
        }

        .btn-wa {
            background-color: #25d366;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .btn-wa img {
            width: 20px;
        }
    </style>

    <div class="distributor-container">
        <div class="card border-0 bg-transparent">
            <div class="card-body">

                <!-- SEARCH BAR -->
                <section class="search-section">
                    <p class="label">Cari Kota/Kecamatan</p>
                    <div class="search-wrapper">
                        <input type="text" class="search-input" placeholder="Cari lokasi..."
                            oninput="handleChange(this.value)" id="input-field">
                        <img src="https://mganik-assets.pages.dev/assets/clear.svg" alt="clear" class="icon clear"
                            onclick="clearField()">
                        <div class="dot-flashing" id="loading" style="display: none;"></div>
                    </div>
                </section>
                <div id="result-container" class="result-container" style="display: block;"></div>
                <div id="search-result-container" class="card-wrapper" style="display: block;"></div>

                <script>
                    function handleChange(value) {
                        const loading = document.getElementById('loading');
                        const resultContainer = document.getElementById('result-container');
                        loading.style.display = 'inline-block';

                        fetch(`/search-regions?keyword=${encodeURIComponent(value)}`)
                            .then(res => res.json())
                            .then(data => {
                                loading.style.display = 'none';
                                resultContainer.innerHTML = '';

                                data.regions.forEach(region => {
                                    const div = document.createElement('div');
                                    div.className = 'result-item';
                                    div.setAttribute('onclick', `handleOptionClick('${region.id}', '${region.label}')`);
                                    div.textContent = region.label;
                                    resultContainer.appendChild(div);
                                });
                            });
                    }

                    function handleOptionClick(regionId, label) {
                        const resultContainer = document.getElementById('search-result-container');
                        resultContainer.innerHTML = '<p>Loading distributor...</p>';

                        fetch(`/get-distributors?region=${encodeURIComponent(label)}`)
                            .then(res => res.json())
                            .then(data => {
                                resultContainer.innerHTML = '';

                                if (data.distributors.length === 0) {
                                    resultContainer.innerHTML = '<p>Tidak ada distributor di wilayah ini.</p>';
                                    return;
                                }

                                data.distributors.forEach(distributor => {
                                    const card = `
                                    <div class="distributor-card">
                                        <div class="card-header">
                                            <img src="${distributor.photo_url}" class="profile-img" alt="Foto Distributor">
                                            <div>
                                                <p class="distributor-name">${distributor.name}</p>
                                                <p class="address">${distributor.address}, ${distributor.district.name}, ${distributor.regency.name}, ${distributor.province.name}</p>
                                                <a href="${distributor.maps_url}" target="_blank" class="map-link btn btn-primary btn-sm text-white" style="text-decoration: none;">📍 Peta Google</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>📞 <a href="tel:${distributor.phone}">${distributor.phone}</a></p>
                                            <p>🚚 ${distributor.shipments.join(', ')}</p>
                                            <p>💵 ${distributor.cod ? 'COD Tersedia' : 'Tidak ada COD'}</p>

                                            <div class="marketplace-icons">
                                                ${distributor.marketplaces.map(link => `
                                                                    <a href="${link.pivot.url}" target="_blank">
                                                                        <img src="${link.icon}" alt="${link.name}" title="${link.name}">
                                                                    </a>
                                                                `).join('')}
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button onclick="directToWA('${distributor.phone}', 'Halo saya dari website Doorasi...')" class="btn-wa">
                                                <img src="https://mganik-assets.pages.dev/assets/whatsapp.png" alt="WhatsApp">
                                                BELI DISINI
                                            </button>
                                        </div>
                                    </div>
                                `;
                                    resultContainer.innerHTML += card;
                                });
                            });
                    }


                    function clearField() {
                        document.getElementById('input-field').value = '';
                        document.getElementById('result-container').innerHTML = '';
                        document.getElementById('search-result-container').innerHTML = '';
                    }

                    function directToWA(phone, message) {
                        const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
                        window.open(url, '_blank');
                    }
                </script>

                <nav class="acnav">
                    @foreach ($distributorsByRegion as $provinceName => $regencies)
                        <li class="has-children">
                            <div class="acnav__label" onclick="toggleAccordion(this)">
                                {{ $provinceName }}
                                <i class="fa-solid fa-chevron-down chevron"></i>
                            </div>
                            <ul class="acnav__list acnav__list--level2" style="display: none;">
                                @foreach ($regencies as $regencyName => $distributors)
                                    <li class="has-children">
                                        <div class="acnav__label" onclick="toggleAccordion(this)">
                                            {{ $regencyName }}
                                            <i class="fa-solid fa-chevron-down chevron"></i>
                                        </div>
                                        <ul class="acnav__list acnav__list--level3" style="display: none;">
                                            @foreach ($distributors as $distributor)
                                                <li>
                                                    <div class="distributor-card">
                                                        {{-- Card Header --}}
                                                        <div class="card-header d-flex">
                                                            <img src="https://mganik-assets.pages.dev/assets/placeholder_foto.png"
                                                                class="profile-img" alt="Foto Distributor">
                                                            <div class="ms-3">
                                                                <p class="distributor-name">
                                                                    {{ $distributor->full_name }}</p>
                                                                <p class="address">{{ $distributor->address }}</p>
                                                                <a href="{{ $distributor->google_maps_url }}"
                                                                    target="_blank" class="map-link btn btn-primary btn-sm text-white" style="text-decoration: none;">📍 Lihat di Google
                                                                    Maps</a>
                                                            </div>
                                                        </div>

                                                        {{-- Card Body --}}
                                                        <div class="card-body">
                                                            <p>📞 <a
                                                                    href="tel:{{ $distributor->primary_phone }}">{{ $distributor->primary_phone }}</a>
                                                            </p>
                                                            <p>🚚
                                                                {{ $distributor->shipments->pluck('name')->join(', ') }}
                                                            </p>
                                                            <p>💵 COD Tersedia</p>

                                                            <div class="location-info">
                                                                <p>🌍 Provinsi: {{ strtoupper($provinceName) }}</p>
                                                                <p>🏙️ Kabupaten: {{ strtoupper($regencyName) }}</p>
                                                                <p>🏞️ Kecamatan:
                                                                    {{ strtoupper($distributor->district->name ?? '-') }}
                                                                </p>
                                                                <p>🏡 Desa:
                                                                    {{ strtoupper($distributor->village->name ?? '-') }}
                                                                </p>
                                                            </div>

                                                            @if ($distributor->marketplaces && count($distributor->marketplaces))
                                                                <div class="marketplace-icons mt-2">
                                                                    @foreach ($distributor->marketplaces as $marketplace)
                                                                        <a href="{{ $marketplace->url }}"
                                                                            target="_blank">
                                                                            <img src="{{ asset('storage/icons/' . $marketplace->icon) }}"
                                                                                alt="{{ $marketplace->name }}"
                                                                                title="{{ $marketplace->name }}">
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- Card Footer --}}
                                                        <div class="card-footer mt-3">
                                                            <button
                                                                onclick="directToWA('{{ $distributor->primary_phone }}', 'Halo, saya tertarik untuk membeli produk Doorasi. Bisa bantu?')"
                                                                class="btn-wa">
                                                                <img src="https://mganik-assets.pages.dev/assets/whatsapp.png"
                                                                    alt="WhatsApp">
                                                                BELI DISINI
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </nav>

            </div>
        </div>
    </div>


    <script>
        function toggleAccordion(element) {
            const chevron = element.querySelector('.chevron');
            const nextUl = element.nextElementSibling;

            if (nextUl.style.display === 'block') {
                nextUl.style.display = 'none';
                chevron?.classList.remove('rotate');
            } else {
                nextUl.style.display = 'block';
                chevron?.classList.add('rotate');
            }
        }

        function directToWA(phone, text) {
            const encodedText = encodeURIComponent(text);
            window.open(`https://wa.me/${phone}?text=${encodedText}`, '_blank');
        }
    </script>


</body>

</html>
