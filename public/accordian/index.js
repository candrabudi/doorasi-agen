const API_BASE_URL = 'https://agen-doorasi.com';
const ASSET_BASE_URL = 'https://mganik-assets.pages.dev/assets';

class DistributorSearch {
    constructor() {
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

    initEventListeners() {
        this.elements.inputField.addEventListener('input', (e) => this.handleSearch(e.target.value));
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
            div.className = 'result-item';
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
        card.className = isSearch ? 'distributor-card-search' : 'distributor-card';

        card.appendChild(this.createCardHeader(distributor));

        card.appendChild(this.createCardBody(distributor));

        if (distributor.marketplaces?.length) {
            card.appendChild(this.createMarketplaceIcons(distributor.marketplaces));
        }

        card.appendChild(this.createCardFooter(distributor));

        return card;
    }

    createCardHeader(distributor) {
        const header = document.createElement('div');
        header.className = 'card-header d-flex align-items-center';

        const img = document.createElement('img');
        img.src = `${API_BASE_URL}/assets/media/logos/logo-agen-doorasi.png`;
        img.className = 'profile-img';
        img.style.width = '40px';
        img.style.height = '40px';
        img.style.objectFit = 'contain';

        const info = document.createElement('div');
        info.className = 'ms-3';
        
        const name = document.createElement('p');
        name.className = 'distributor-name';
        name.textContent = distributor.name || distributor.full_name;

        info.appendChild(name);
        header.appendChild(img);
        header.appendChild(info);
        return header;
    }

    createCardBody(distributor) {
        const body = document.createElement('div');
        body.className = 'card-body';

        const address = document.createElement('p');
        console.log(distributor);
        address.className = 'address';
        address.textContent = distributor.address 
            ? `${distributor.address}, ${distributor.district}, ${distributor.regency}, ${distributor.province}`
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
            <img decoding="async" loading="lazy" class="mr-2 contact-shipping" src="${ASSET_BASE_URL}/pengiriman.svg" alt="cod-icon">
            Kurir Lainnya ${shipmentNames}
        `;

        const cod = document.createElement('p');
        cod.innerHTML = `
            <img decoding="async" loading="lazy" class="mr-2 contact-shipping" src="${ASSET_BASE_URL}/cod.svg" alt="cod-icon">
            ${distributor.cod || distributor.is_cod ?"COD / Cash on Delivery" : "Tidak ada COD"}
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
        container.className = 'marketplace-icons';

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
        footer.className = 'card-footer mt-3';

        const button = document.createElement('button');
        button.className = 'btn-wa';
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
            provinceItem.className = 'has-children';

            const provinceLabel = document.createElement('div');
            provinceLabel.className = 'acnav__label';
            provinceLabel.innerHTML = `${provinceName} <i class="fa-solid fa-chevron-down chevron"></i>`;
            provinceLabel.onclick = () => this.toggleAccordion(provinceLabel);

            const regencyList = document.createElement('ul');
            regencyList.className = 'acnav__list acnav__list--level2';
            regencyList.style.display = 'none';

            Object.entries(province).forEach(([regencyName, distributors]) => {
                const regencyItem = document.createElement('li');
                regencyItem.className = 'has-children';

                const regencyLabel = document.createElement('div');
                regencyLabel.className = 'acnav__label';
                regencyLabel.innerHTML = `${regencyName} <i class="fa-solid fa-chevron-down chevron"></i>`;
                regencyLabel.onclick = () => this.toggleAccordion(regencyLabel);

                const distributorList = document.createElement('ul');
                distributorList.className = 'acnav__list acnav__list--level3';
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