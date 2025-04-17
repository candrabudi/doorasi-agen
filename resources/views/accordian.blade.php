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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body style="background: #000000">
    <style>
        .card-header img {
            border: none;
            border-radius: 0;
            box-shadow: none;
            max-width: 100%;
            height: 100% !important;
        }

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
            padding: 6px 10px;
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
            padding-left: 0rem;
            margin-bottom: 0rem;
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

        .distributor-card-search {
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
            margin-left: -20px;
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
            margin-bottom: 15px;
            margin-left: -20px;
        }

        .card-body{
            margin-top: -10px;
        }

        .card-body p {
            font-size: 14px;
            display: block;
            margin-left: -15px;
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
                <section class="search-section">
                    <p class="label" style="color: #FFF;">Cari Kota/Kecamatan</p>
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

                        fetch(`https://doorasi.indobuzz.my.id/search-regions?keyword=${encodeURIComponent(value)}`)
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

                        fetch(`https://doorasi.indobuzz.my.id/get-distributors?region=${encodeURIComponent(label)}`)
                            .then(res => res.json())
                            .then(data => {
                                resultContainer.innerHTML = '';

                                if (data.distributors.length === 0) {
                                    resultContainer.innerHTML = '<p>Tidak ada distributor di wilayah ini.</p>';
                                    return;
                                }

                                data.distributors.forEach(distributor => {
                                    const card = `
                                    <div class="distributor-card-search">
                                        <div class="card-header">
                                            <img src="https://doorasi.indobuzz.my.id/assets/media/logos/logo-doorasi.png" class="profile-img" alt="Foto Distributor">
                                            <div>
                                                <p class="distributor-name">${distributor.name}</p>
                                                <p class="address">${distributor.address}, ${distributor.district.name}, ${distributor.regency.name}, ${distributor.province.name}</p>
                                                <a href="${distributor.maps_url}" target="_blank" class="map-link btn btn-primary btn-sm text-white" style="text-decoration: none;">📍 Peta Google</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p><i class="fas fa-phone" style="color: gray;"></i> <a href="tel:${distributor.phone}">${distributor.phone}</a></p>
                                            <p><i class="fas fa-truck" style="color: gray;"></i> Kurir Lainnya ${distributor.shipments.join(' & ')}</p>
                                            <p><i class="fas fa-money-bill-wave" style="color: gray;"></i> ${distributor.cod ? 'COD / Cash on Delivery' : 'Tidak ada COD'}</p>

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

                <nav class="acnav" id="distributorsAccordion">

                </nav>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('/show-distributors')
                .then(response => response.json())
                .then(data => {
                    const accordionContainer = document.getElementById('distributorsAccordion');
                    for (let provinceName in data) {
                        if (data.hasOwnProperty(provinceName)) {
                            const province = data[provinceName];
                            const provinceItem = document.createElement('li');
                            provinceItem.classList.add('has-children');

                            const provinceLabel = document.createElement('div');
                            provinceLabel.classList.add('acnav__label');
                            provinceLabel.innerHTML =
                                `${provinceName} <i class="fa-solid fa-chevron-down chevron"></i>`;
                            provinceLabel.onclick = function() {
                                toggleAccordion(this);
                            };
                            const regencyList = document.createElement('ul');
                            regencyList.classList.add('acnav__list', 'acnav__list--level2');
                            regencyList.style.display = 'none';

                            for (let regencyName in province) {
                                if (province.hasOwnProperty(regencyName)) {
                                    const distributors = province[regencyName];
                                    const regencyItem = document.createElement('li');
                                    regencyItem.classList.add('has-children');

                                    const regencyLabel = document.createElement('div');
                                    regencyLabel.classList.add('acnav__label');
                                    regencyLabel.innerHTML =
                                        `${regencyName} <i class="fa-solid fa-chevron-down chevron"></i>`;
                                    regencyLabel.onclick = function() {
                                        toggleAccordion(this);
                                    };
                                    const distributorList = document.createElement('ul');
                                    distributorList.classList.add('acnav__list', 'acnav__list--level3');
                                    distributorList.style.display = 'none';

                                    distributors.forEach(distributor => {
                                        const distributorItem = document.createElement('li');
                                        const card = document.createElement('div');
                                        card.classList.add('distributor-card');

                                        const cardHeader = document.createElement('div');
                                        cardHeader.classList.add('card-header', 'd-flex',
                                            'align-items-center'
                                            ); // Added 'align-items-center' for vertical alignment
                                        const profileImg = document.createElement('img');
                                        profileImg.src =
                                            'https://doorasi.indobuzz.my.id/assets/media/logos/logo-doorasi.png';
                                        profileImg.classList.add('profile-img');
                                        profileImg.style.width =
                                        '40px'; // Adjust the width of the profile image
                                        profileImg.style.height =
                                        '40px'; // Adjust the height of the profile image
                                        profileImg.style.objectFit =
                                        'contain'; // Ensure the logo stays proportional

                                        const infoContainer = document.createElement('div');
                                        infoContainer.classList.add('ms-3'); // Add margin to the left

                                        const name = document.createElement('p');
                                        name.classList.add('distributor-name');
                                        name.innerHTML = distributor.full_name;

                                        infoContainer.appendChild(name);
                                        cardHeader.appendChild(profileImg);
                                        cardHeader.appendChild(infoContainer);
                                        card.appendChild(cardHeader);

                                        const cardBody = document.createElement('div');
                                        cardBody.classList.add('card-body');

                                        // Address and map link are moved here
                                        const address = document.createElement('p');
                                        address.classList.add('address');
                                        address.innerHTML =
                                            `${distributor.address}, ${distributor.district}, ${distributor.regency}, ${distributor.province}`;

                                        const mapLink = document.createElement('a');
                                        mapLink.href = distributor.google_maps_url;
                                        mapLink.target = '_blank';
                                        mapLink.classList.add('map-link', 'btn', 'btn-primary',
                                            'btn-sm', 'text-white');
                                        mapLink.style.textDecoration = 'none';
                                        mapLink.innerHTML =
                                            '<img loading="lazy" class="mr-2" src="https://mganik-assets.pages.dev/assets/pinlocation_googlemaps.svg" alt="pinlocation_googlemaps"> Peta Google';

                                        cardBody.appendChild(address);
                                        cardBody.appendChild(mapLink);

                                        // Other distributor info
                                        const phone = document.createElement('p');
                                        phone.innerHTML =
                                            `<img loading="lazy" alt="phone-icon" class="mr-2" src="https://mganik-assets.pages.dev/assets/phone.svg"> <a href="tel:${distributor.primary_phone}">${distributor.primary_phone}</a>`;

                                        const shipments = document.createElement('p');
                                        shipments.innerHTML =
                                            `<img loading="lazy" alt="cod-icon" class="mr-2 contact-shipping" src="https://mganik-assets.pages.dev/assets/pengiriman.svg"> Kurir Lainnya ${distributor.shipments.map(ship => ship.name).join(' & ')}`;

                                        const cod = document.createElement('p');
                                        cod.innerHTML =
                                            `<img loading="lazy" alt="cod-icon" class="mr-2 contact-shipping" src="https://mganik-assets.pages.dev/assets/cod.svg"> ${distributor.is_cod ? 'COD / Cash on Delivery' : 'Tidak ada COD'}`;

                                        cardBody.appendChild(phone);
                                        cardBody.appendChild(shipments);
                                        cardBody.appendChild(cod);
                                        card.appendChild(cardBody);

                                        if (distributor.marketplaces && distributor.marketplaces
                                            .length) {
                                            const marketplaceIcons = document.createElement('div');
                                            marketplaceIcons.classList.add('marketplace-icons', 'mt-2');
                                            distributor.marketplaces.forEach(marketplace => {
                                                const marketplaceLink = document.createElement(
                                                    'a');
                                                marketplaceLink.href = marketplace.url;
                                                marketplaceLink.target = '_blank';

                                                const marketplaceImg = document.createElement(
                                                    'img');
                                                marketplaceImg.src =
                                                    `https://doorasi.indobuzz.my.id/storage/icons/${marketplace.icon}`;
                                                marketplaceImg.alt = marketplace.name;
                                                marketplaceImg.title = marketplace.name;

                                                marketplaceLink.appendChild(marketplaceImg);
                                                marketplaceIcons.appendChild(marketplaceLink);
                                            });
                                            card.appendChild(marketplaceIcons);
                                        }

                                        const cardFooter = document.createElement('div');
                                        cardFooter.classList.add('card-footer', 'mt-3');
                                        const waButton = document.createElement('button');
                                        waButton.classList.add('btn-wa');
                                        waButton.onclick = function() {
                                            directToWA(distributor.primary_phone,
                                                'Halo, saya tertarik untuk membeli produk Doorasi. Bisa bantu?'
                                            );
                                        };
                                        const waIcon = document.createElement('img');
                                        waIcon.src =
                                            "https://mganik-assets.pages.dev/assets/whatsapp.png";
                                        waIcon.alt = "WhatsApp";
                                        waButton.appendChild(waIcon);
                                        waButton.appendChild(document.createTextNode('BELI DISINI'));
                                        cardFooter.appendChild(waButton);
                                        card.appendChild(cardFooter);

                                        distributorItem.appendChild(card);
                                        distributorList.appendChild(distributorItem);
                                    });

                                    regencyItem.appendChild(regencyLabel);
                                    regencyItem.appendChild(distributorList);
                                    regencyList.appendChild(regencyItem);
                                }
                            }


                            provinceItem.appendChild(provinceLabel);
                            provinceItem.appendChild(regencyList);
                            accordionContainer.appendChild(provinceItem);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });

        function toggleAccordion(element) {
            const siblingList = element.nextElementSibling;
            const chevron = element.querySelector('.chevron');
            if (siblingList.style.display === 'none') {
                siblingList.style.display = 'block';
                chevron.classList.add('rotate');
            } else {
                siblingList.style.display = 'none';
                chevron.classList.remove('rotate');
            }
        }


        function directToWA(phone, text) {
            const encodedText = encodeURIComponent(text);
            window.open(`https://wa.me/${phone}?text=${encodedText}`, '_blank');
        }
    </script>
</body>

</html>
