<!-- Widget Container -->
<div id="distributor-widget">
    <input type="text" id="search-input" placeholder="Cari Provinsi / Kabupaten..." />
    <div id="regions-list"></div>
    <div id="distributors-list"></div>
</div>
<style>
    #distributor-widget {
        width: 300px;
        font-family: Arial, sans-serif;
    }

    #search-input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
    }

    #regions-list {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }

    .region-item {
        padding: 8px;
        cursor: pointer;
    }

    .region-item:hover {
        background-color: #f1f1f1;
    }

    #distributors-list {
        display: none;
    }

    .distributor-item {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .distributor-item:last-child {
        border-bottom: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const regionsList = document.getElementById('regions-list');
        const distributorsList = document.getElementById('distributors-list');

        // Menampilkan semua wilayah dan distributor pada halaman pertama
        fetchAllRegions();

        // Fungsi untuk fetch semua provinsi dan kabupaten, serta distributor mereka
        function fetchAllRegions() {
            fetch('/show-distributors') // Mengambil semua data provinsi dan kabupaten
                .then(response => response.json())
                .then(data => {
                    const regions = data.regions;
                    regionsList.innerHTML = ''; // Clear previous results

                    // Menampilkan semua provinsi
                    Object.keys(regions).forEach(provinceName => {
                        const provinceItem = document.createElement('div');
                        provinceItem.classList.add('province-item');
                        provinceItem.textContent = provinceName;

                        // Membuat elemen untuk menampilkan kabupaten dalam provinsi
                        const regenciesList = document.createElement('div');
                        regenciesList.classList.add('regencies-list');

                        // Menampilkan kabupaten dalam provinsi
                        Object.keys(regions[provinceName]).forEach(regencyName => {
                            const regencyItem = document.createElement('div');
                            regencyItem.classList.add('regency-item');
                            regencyItem.textContent = regencyName;

                            // Tambahkan event listener untuk mengambil distributor berdasarkan kabupaten
                            regencyItem.addEventListener('click', function() {
                                fetchDistributorsByRegion(provinceName,
                                regencyName);
                            });
                            regenciesList.appendChild(regencyItem);
                        });

                        // Tambahkan kabupaten ke dalam provinsi
                        provinceItem.appendChild(regenciesList);
                        regionsList.appendChild(provinceItem);
                    });
                })
                .catch(error => console.error('Error fetching all regions:', error));
        }


        // Fungsi untuk menghandle pencarian daerah
        searchInput.addEventListener('input', function() {
            const keyword = searchInput.value;
            if (keyword.length >= 3) { // Mulai mencari setelah 3 karakter
                fetchRegions(keyword);
            } else {
                regionsList.innerHTML = ''; // Clear results if input is too short
                fetchAllRegions(); // Tampilkan semua wilayah jika pencarian kosong
            }
        });

        // Fungsi untuk fetch daerah berdasarkan kata kunci
        function fetchRegions(keyword) {
            fetch('/search-regions?keyword=' + encodeURIComponent(keyword))
                .then(response => response.json())
                .then(data => {
                    const regions = data.regions;
                    regionsList.innerHTML = ''; // Clear previous results

                    regions.forEach(region => {
                        const regionItem = document.createElement('div');
                        regionItem.classList.add('region-item');
                        regionItem.textContent = region.label;
                        regionItem.addEventListener('click', function() {
                            fetchDistributorsByRegion(region.label);
                        });
                        regionsList.appendChild(regionItem);
                    });
                })
                .catch(error => console.error('Error fetching regions:', error));
        }

        // Fungsi untuk fetch distributor berdasarkan wilayah
        function fetchDistributorsByRegion(regionLabel) {
            fetch(`/get-distributors-by-region?region=${encodeURIComponent(regionLabel)}`)
                .then(response => response.json())
                .then(data => {
                    const distributors = data.distributors;
                    distributorsList.innerHTML = ''; // Clear previous results
                    distributorsList.style.display = 'block'; // Show distributors list

                    distributors.forEach(distributor => {
                        const distributorItem = document.createElement('div');
                        distributorItem.classList.add('distributor-item');

                        // Displaying distributor info
                        distributorItem.innerHTML = `
                        <h4>${distributor.name}</h4>
                        <p>${distributor.address}</p>
                        <p><strong>Phone:</strong> ${distributor.phone}</p>
                        <p><strong>Marketplaces:</strong></p>
                        <ul>
                            ${distributor.marketplaces.map(mp => `
                                <li>
                                    <img src="${mp.icon}" alt="${mp.name}" width="20" />
                                    <a href="${mp.pivot.url}" target="_blank">${mp.name}</a>
                                </li>
                            `).join('')}
                        </ul>
                        <p><strong>COD Available:</strong> ${distributor.cod ? 'Yes' : 'No'}</p>
                    `;

                        distributorsList.appendChild(distributorItem);
                    });
                })
                .catch(error => console.error('Error fetching distributors:', error));
        }
    });
</script>
