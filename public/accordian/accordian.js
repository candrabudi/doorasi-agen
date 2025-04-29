const API_BASE_URL = 'https://agen-doorasi.com';
const ASSET_BASE_URL = 'https://mganik-assets.pages.dev/assets';

class DistributorSearch {
    constructor() {
        this.loadStylesheets();
        this.createDOMStructure();
        this.elements = {
            inputField: document.getElementById('input-field'),
            loading: document.getElementById('loading'),
            resultContainer: document.getElementById('result-container'),
            searchResultContainer: document.getElementById('search-result-container'),
            accordionContainer: document.getElementById('distributorsAccordion')
        };
        
        this.initEventListeners();
        this.loadDistributors();
    }

    loadStylesheets() {
        const stylesheets = [
            {
                href: 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css',
                integrity: 'sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==',
                crossorigin: 'anonymous',
                referrerpolicy: 'no-referrer'
            },
            {
                href: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'
            },
            {
                href: 'https://agen-doorasi.com/accordian/index.css'
            }
        ];

        stylesheets.forEach(sheet => {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = sheet.href;
            if (sheet.integrity) link.integrity = sheet.integrity;
            if (sheet.crossorigin) link.crossOrigin = sheet.crossorigin;
            if (sheet.referrerpolicy) link.referrerPolicy = sheet.referrerpolicy;
            document.head.appendChild(link);
        });
    }

    createDOMStructure() {
        const container = document.createElement('div');
        container.classList.add('distributor-container');

        const card = document.createElement('div');
        card.classList.add('card', 'border-0', 'bg-transparent');

        const cardBody = document.createElement('div');
        cardBody.classList.add('card-body');

        // Search Section
        const searchSection = document.createElement('section');
        searchSection.classList.add('search-section');

        const label = document.createElement('p');
        label.classList.add('label');
        label.style.color = '#FFF';
        label.textContent = 'Cari Kota/Kecamatan';

        const searchWrapper = document.createElement('div');
        searchWrapper.classList.add('search-wrapper');

        const input = document.createElement('input');
        input.type = 'text';
        input.classList.add('search-input');
        input.placeholder = 'Cari lokasi...';
        input.id = 'input-field';

        const clearIcon = document.createElement('img');
        clearIcon.src = `${ASSET_BASE_URL}/clear.svg`;
        clearIcon.alt = 'clear';
        clearIcon.classList.add('icon', 'clear');

        const loading = document.createElement('div');
        loading.id = 'loading';
        loading.classList.add('dot-flashing');
        loading.style.display = 'none';

        searchWrapper.appendChild(input);
        searchWrapper.appendChild(clearIcon);
        searchWrapper.appendChild(loading);
        searchSection.appendChild(label);
        searchSection.appendChild(searchWrapper);

        // Result Containers
        const resultContainer = document.createElement('div');
        resultContainer.id = 'result-container';
        resultContainer.classList.add('result-container');
        resultContainer.style.display = 'block';

        const searchResultContainer = document.createElement('div');
        searchResultContainer.id = 'search-result-container';
        searchResultContainer.classList.add('card-wrapper');
        searchResultContainer.style.display = 'block';

        // Accordion
        const accordion = document.createElement('nav');
        accordion.classList.add('acnav');
        accordion.id = 'distributorsAccordion';

        cardBody.appendChild(searchSection);
        cardBody.appendChild(resultContainer);
        cardBody.appendChild(searchResultContainer);
        cardBody.appendChild(accordion);
        card.appendChild(cardBody);
        container.appendChild(card);
        document.body.appendChild(container);
    }

    initEventListeners() {
        this.elements.inputField.addEventListener('input', (e) => this.handleSearch(e.target.value));
        document.querySelector('.clear').addEventListener('click', () => this.clearField());
    }

    async handleSearch(keyword) {
        if (!keyword) {
            this.clearField();
            return;
        }

        this.showLoading();
        try {
            const response = await fetch(`${API_BASE_URL}/search-regions?keyword=${encodeURIComponent(keyword)}`);
            const data = await response.json();
            this.renderRegions(data.regions);
        } catch (error) {
            console.error('Error searching regions:', error);
        } finally {
            this.hideLoading();
        }
    }

    async handleOptionClick(regionId, label) {
        this.elements.searchResultContainer.innerHTML = '<p>Loading distributor...</p>';
        try {
            const response = await fetch(`${API_BASE_URL}/get-distributors?region=${encodeURIComponent(label)}`);
            const data = await response.json();
            this.renderDistributors(data.distributors);
        } catch (error) {
            console.error('Error fetching distributors:', error);
        }
    }

    async loadDistributors() {
        try {
            const response = await fetch(`${API_BASE_URL}/show-distributors`);
            const data = await response.json();
            this.renderAccordion(data);
        } catch (error) {
            console.error('Error fetching distributors:', error);
        }
    }

    showLoading() {
        this.elements.loading.style.display = 'inline-block';
    }

    hideLoading() {
        this.elements.loading.style.display = 'none';
    }

    clearField() {
        this.elements.inputField.value = '';
        this.elements.resultContainer.innerHTML = '';
        this.elements.searchResultContainer.innerHTML = '';
    }

    renderRegions(regions) {
        this.elements.resultContainer.innerHTML = '';
        regions.forEach(region => {
            const div = document.createElement('div');
            div.classList.add('result-item');
            div.onclick = () => this.handleOptionClick(region.id, region.label);
            div.textContent = region.label;
            this.elements.resultContainer.appendChild(div);
        });
    }

    renderDistributors(distributors) {
        this.elements.searchResultContainer.innerHTML = '';
        
        if (!distributors.length) {
            this.elements.searchResultContainer.innerHTML = '<p>Tidak ada distributor di wilayah ini.</p>';
            return;
        }

        distributors.forEach(distributor => {
            this.elements.searchResultContainer.appendChild(this.createDistributorCard(distributor, true));
        });
    }

    createDistributorCard(distributor, isSearch = false) {
        const card = document.createElement('div');
        card.classList.add(isSearch ? 'distributor-card-search' : 'distributor-card');

        // Card Header
        card.appendChild(this.createCardHeader(distributor));

        // Card Body
        card.appendChild(this.createCardBody(distributor));

        // Marketplace Icons
        if (distributor.marketplaces?.length) {
            card.appendChild(this.createMarketplaceIcons(distributor.marketplaces));
        }

        // Card Footer
        card.appendChild(this.createCardFooter(distributor));

        return card;
    }

    createCardHeader(distributor) {
        const header = document.createElement('div');
        header.classList.add('card-header', 'd-flex', 'align-items-center');

        const img = document.createElement('img');
        img.src = `${API_BASE_URL}/assets/media/logos/logo-agen-doorasi.png`;
        img.classList.add('profile-img');
        img.style.width = '40px';
        img.style.height = '40px';
        img.style.objectFit = 'contain';

        const info = document.createElement('div');
        info.classList.add('ms-3');
        
        const name = document.createElement('p');
        name.classList.add('distributor-name');
        name.textContent = distributor.name || distributor.full_name;

        info.appendChild(name);
        header.appendChild(img);
        header.appendChild(info);
        return header;
    }

    createCardBody(distributor) {
        const body = document.createElement('div');
        body.classList.add('card-body');

        const address = document.createElement('p');
        address.classList.add('address');
        address.textContent = distributor.address 
            ? `${distributor.address}, ${distributor.district.name}, ${distributor.regency.name}, ${distributor.province.name}`
            : `${distributor.address}, ${distributor.district}, ${distributor.regency}, ${distributor.province}`;

        const googleMaps = document.createElement('p');
        googleMaps.innerHTML = `
            <img decoding="async" loading="lazy" class="mr-2" src="${ASSET_BASE_URL}/pinlocation_googlemaps.svg" alt="pinlocation_googlemaps">
            <a href="${distributor.maps_url || distributor.google_maps_url || '#'}" target="_blank">Peta Google</a>
        `;

        const phone = document.createElement('p');
        phone.innerHTML = `
            <img decoding="async" loading="lazy" class="mr-2" src="${ASSET_BASE_URL}/phone.svg" alt="phone-icon">
            <a href="tel:${distributor.phone || distributor.primary_phone}">${distributor.phone || distributor.primary_phone}</a>
        `;

        const shipments = document.createElement('p');
        const shipmentNames = distributor.shipments?.map(s => typeof s === 'string' ? s : s.name).join(' & ') || '';
        shipments.innerHTML = `
            <img decoding="async" loading="lazy" class="mr-2" class="contact-shipping" src="${ASSET_BASE_URL}/pengiriman.svg" alt="cod-icon">
            Kurir Lainnya ${shipmentNames}
        `;

        const cod = document.createElement('p');
        cod.innerHTML = `
            <img decoding="async" loading="lazy" class="mr-2" class="contact-shipping" src="${ASSET_BASE_URL}/cod.svg" alt="cod-icon">
            ${distributor.cod || distributor.is_cod ? 'COD / Cash on Delivery' : 'Tidak ada COD'}
        `;

        body.appendChild(address);
        body.appendChild(googleMaps);
        body.appendChild(phone);
        body.appendChild(shipments);
        body.appendChild(cod);
        return body;
    }

    createMarketplaceIcons(marketplaces) {
        const container = document.createElement('div');
        container.classList.add('marketplace-icons');

        marketplaces.forEach(link => {
            const a = document.createElement('a');
            a.href = link.pivot.url;
            a.target = '_blank';

            const img = document.createElement('img');
            img.src = `${API_BASE_URL}/storage/icons/${link.icon}`;
            img.alt = link.name;
            img.title = link.name;

            a.appendChild(img);
            container.appendChild(a);
        });

        return container;
    }

    createCardFooter(distributor) {
        const footer = document.createElement('div');
        footer.classList.add('card-footer', 'mt-3');

        const button = document.createElement('button');
        button.classList.add('btn-wa');
        button.onclick = () => this.directToWA(
            distributor.phone || distributor.primary_phone,
            distributor.phone 
                ? 'Halo saya dari website Doorasi...' 
                : 'Halo, saya tertarik untuk membeli produk Doorasi. Bisa bantu?'
        );

        const icon = document.createElement('img');
        icon.src = `${ASSET_BASE_URL}/whatsapp.png`;
        icon.alt = 'WhatsApp';

        button.appendChild(icon);
        button.appendChild(document.createTextNode(' BELI DISINI'));
        footer.appendChild(button);
        return footer;
    }

    renderAccordion(data) {
        Object.entries(data).forEach(([provinceName, province]) => {
            const provinceItem = document.createElement('li');
            provinceItem.classList.add('has-children');

            const provinceLabel = document.createElement('div');
            provinceLabel.classList.add('acnav__label');
            provinceLabel.innerHTML = `${provinceName} <i class="fa-solid fa-chevron-down chevron"></i>`;
            provinceLabel.onclick = () => this.toggleAccordion(provinceLabel);

            const regencyList = document.createElement('ul');
            regencyList.classList.add('acnav__list', 'acnav__list--level2');
            regencyList.style.display = 'none';

            Object.entries(province).forEach(([regencyName, distributors]) => {
                const regencyItem = document.createElement('li');
                regencyItem.classList.add('has-children');

                const regencyLabel = document.createElement('div');
                regencyLabel.classList.add('acnav__label');
                regencyLabel.innerHTML = `${regencyName} <i class="fa-solid fa-chevron-down chevron"></i>`;
                regencyLabel.onclick = () => this.toggleAccordion(regencyLabel);

                const distributorList = document.createElement('ul');
                distributorList.classList.add('acnav__list', 'acnav__list--level3');
                distributorList.style.display = 'none';

                distributors.forEach(distributor => {
                    const distributorItem = document.createElement('li');
                    distributorItem.appendChild(this.createDistributorCard(distributor));
                    distributorList.appendChild(distributorItem);
                });

                regencyItem.appendChild(regencyLabel);
                regencyItem.appendChild(distributorList);
                regencyList.appendChild(regencyItem);
            });

            provinceItem.appendChild(provinceLabel);
            provinceItem.appendChild(regencyList);
            this.elements.accordionContainer.appendChild(provinceItem);
        });
    }

    toggleAccordion(element) {
        const siblingList = element.nextElementSibling;
        const chevron = element.querySelector('.chevron');
        siblingList.style.display = siblingList.style.display === 'none' ? 'block' : 'none';
        chevron.classList.toggle('rotate');
    }

    directToWA(phone, message) {
        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new DistributorSearch();
});