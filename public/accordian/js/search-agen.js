document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("input-field");
  const resultContainer = document.getElementById("result-container");
  const distributorContainer = document.getElementById(
    "search-result-container"
  );
  const loadingIndicator = document.getElementById("loading");

  let debounceTimeout;

  function debounce(func, delay) {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(func, delay);
  }

  input.addEventListener("input", function () {
    const keyword = input.value.trim();
    resultContainer.innerHTML = "";
    distributorContainer.innerHTML = "";

    if (keyword.length < 2) return;

    loadingIndicator.style.display = "inline-block";

    debounce(function () {
      fetch(
        `https://agen-doorasi.com/show-regions/distributor?keyword=${encodeURIComponent(
          keyword
        )}`
      )
        .then((response) => response.json())
        .then((data) => {
          loadingIndicator.style.display = "none";

          if (!data.regions.length) {
            resultContainer.innerHTML =
              '<div class="result-item">Wilayah tidak ditemukan</div>';
            return;
          }

          resultContainer.innerHTML = data.regions
            .map(
              (region) => `
                        <div class="result-item" data-province="${
                          region.label.split(" > ")[0]
                        }" data-regency="${region.label.split(" > ")[1]}">
                            ${region.label}
                        </div>
                    `
            )
            .join("");
        })
        .catch((err) => {
          loadingIndicator.style.display = "none";
          console.error("Error saat memuat wilayah:", err);
          resultContainer.innerHTML =
            '<div class="result-item">Terjadi kesalahan</div>';
        });
    }, 300);
  });

  resultContainer.addEventListener("click", function (e) {
    if (e.target.classList.contains("result-item")) {
      const province = e.target.getAttribute("data-province");
      const regency = e.target.getAttribute("data-regency");

      distributorContainer.innerHTML = "";
      loadingIndicator.style.display = "inline-block";

      fetch(
        `https://agen-doorasi.com/search-distributors?province_name=${encodeURIComponent(
          province
        )}&region_name=${encodeURIComponent(regency)}`
      )
        .then((response) => response.json())
        .then((data) => {
          loadingIndicator.style.display = "none";

          const distributors = data.distributors;

          if (!distributors.length) {
            distributorContainer.innerHTML =
              '<div class="result-item">Distributor tidak ditemukan</div>';
            return;
          }

          distributorContainer.innerHTML = distributors
            .map(
              (d) => `
                        <div class="distributor-card-search">
                            <div class="card-header d-flex align-items-center">
                                <img src="${
                                  d.image_url ||
                                  "https://agen-doorasi.com/assets/media/logos/logo-agen-doorasi.png"
                                }" class="profile-img" style="width: 40px; height: 40px; object-fit: contain;">
                                <div class="ms-3">
                                    <p class="distributor-name">${
                                      d.full_name
                                    }</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="address">${d.address}, ${
                d.district?.name || ""
              }, ${d.regency?.name || ""}, ${
                d.regency?.province?.name || ""
              }</p>
                                
                                <p>
                                    <img class="mr-2" src="https://mganik-assets.pages.dev/assets/pinlocation_googlemaps.svg" alt="pinlocation_googlemaps">
                                    ${
                                      d.google_maps_url
                                        ? `<a href="${d.google_maps_url}" target="_blank">Peta Google</a>`
                                        : "Lokasi tidak tersedia"
                                    }
                                </p>
                                
                                <p>
                                    <img class="mr-2" src="https://mganik-assets.pages.dev/assets/phone.svg" alt="phone-icon">
                                    <a href="tel:${d.primary_phone}">${
                d.primary_phone
              }</a>
                                </p>
                                
                                ${
                                  d.is_shipping
                                    ? `
                                    <p>
                                        <img class="mr-2 contact-shipping" src="https://mganik-assets.pages.dev/assets/pengiriman.svg" alt="pengiriman-icon">
                                        Kurir Lainnya
                                    </p>`
                                    : ""
                                }

                                ${
                                  d.is_cod
                                    ? `
                                    <p>
                                        <img class="mr-2 contact-shipping" src="https://mganik-assets.pages.dev/assets/cod.svg" alt="cod-icon">
                                        COD / Cash on Delivery
                                    </p>`
                                    : ""
                                }

                                ${
                                  d.marketplaces && d.marketplaces.length
                                    ? `
                                    <div class="marketplace-icons mt-2">
                                        ${d.marketplaces
                                          .map(
                                            (m) => `
                                            <a href="${m.pivot.url}" target="_blank">
                                                <img src="https://agen-doorasi.com/storage/icons/${m.icon}" alt="${m.name}" title="${m.name}">
                                            </a>
                                        `
                                          )
                                          .join("")}
                                    </div>
                                `
                                    : ""
                                }
                            </div>
                            <div class="card-footer mt-3">
                                <button class="btn-wa" onclick="directToWA('${
                                  d.primary_phone
                                }', 'Halo, saya tertarik membeli produk Doorasi.')">
                                    <img src="https://mganik-assets.pages.dev/assets/whatsapp.png" alt="WhatsApp"> BELI DISINI
                                </button>
                            </div>
                        </div>
                    `
            )
            .join("");
        })
        .catch((err) => {
          loadingIndicator.style.display = "none";
          console.error("Gagal memuat distributor:", err);
          distributorContainer.innerHTML =
            '<div class="result-item">Gagal memuat distributor</div>';
        });
    }
  });
});

function directToWA(phone, message) {
  window.open(
    `https://wa.me/${phone}?text=${encodeURIComponent(message)}`,
    "_blank"
  );
}
