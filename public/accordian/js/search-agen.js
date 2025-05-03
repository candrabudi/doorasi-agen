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
    if (!e.target.classList.contains("result-item")) return;
  
    const province = e.target.getAttribute("data-province");
    const regency = e.target.getAttribute("data-regency");
  
    distributorContainer.innerHTML = "";
    loadingIndicator.style.display = "inline-block";
  
    fetch(`https://agen-doorasi.com/search-distributors?province_name=${encodeURIComponent(province)}&region_name=${encodeURIComponent(regency)}`)
      .then((response) => response.json())
      .then((data) => {
        loadingIndicator.style.display = "none";
  
        const distributors = data.distributors;
  
        if (!distributors.length) {
          distributorContainer.innerHTML = '<div class="result-item">Distributor tidak ditemukan</div>';
          return;
        }
  
        distributorContainer.innerHTML = distributors.map((d) => {
          const shipmentsList = d.shipments?.map(s => s.name).join(", ") || "";
        
          return `
            <div class="distributor-card-search">
              <div class="card-header d-flex align-items-center">
                <img src="${d.image_url || "https://agen-doorasi.com/assets/media/logos/logo-agen-doorasi.png"}"
                     class="profile-img"
                     style="width: 40px; height: 40px; object-fit: contain;">
                <div class="ms-3">
                  <p class="distributor-name">${d.full_name}</p>
                </div>
              </div>
        
              <div class="card-body">
                <div class="address-container">
                  ${d.address}<br>
                  ${d.district?.name}, ${d.regency?.name}<br>
                  ${d.regency?.province?.name}
                </div>
        
                <div class="info-row">
                  <img src="https://mganik-assets.pages.dev/assets/pinlocation_googlemaps.svg" class="info-icon">
                  ${d.google_maps_url
                    ? `<a href="${d.google_maps_url}" target="_blank">Peta Google</a>`
                    : "Lokasi tidak tersedia"}
                </div>
        
                <div class="info-row">
                  <img src="https://mganik-assets.pages.dev/assets/phone.svg" class="info-icon">
                  <a href="tel:${d.primary_phone}">${d.primary_phone}</a>
                </div>
        
                ${shipmentsList ? `
                  <div class="info-row align-start">
                    <img src="https://mganik-assets.pages.dev/assets/pengiriman.svg" class="info-icon mt-1">
                    <span>${shipmentsList}</span>
                  </div>` : ""
                }
        
                ${d.is_cod ? `
                  <div class="info-row">
                    <img src="https://mganik-assets.pages.dev/assets/cod.svg" class="info-icon">
                    <span>COD / Cash on Delivery</span>
                  </div>` : ""
                }
        
                ${d.marketplaces?.length
                  ? `<div class="marketplace-icons mt-2">
                      ${d.marketplaces.map(m => `
                        <a href="${m.pivot?.url || "#"}" target="_blank">
                          <img src="https://agen-doorasi.com/storage/icons/${m.icon}" alt="${m.name}" title="${m.name}" style="width: 30px; margin-right: 6px;">
                        </a>
                      `).join("")}
                    </div>` : ""
                }
              </div>
        
              <div class="card-footer mt-3">
                <button class="btn-wa" onclick="directToWA('${d.primary_phone}', 'Halo, saya tertarik membeli produk Doorasi.')">
                  <img src="https://mganik-assets.pages.dev/assets/whatsapp.png" alt="WhatsApp" width="18" style="margin-right: 6px;">
                  BELI DISINI
                </button>
              </div>
            </div>
          `;
        }).join("");
        
      })
      .catch((err) => {
        loadingIndicator.style.display = "none";
        console.error("Gagal memuat distributor:", err);
        distributorContainer.innerHTML = '<div class="result-item">Gagal memuat distributor</div>';
      });
  });
  
});

function directToWA(phone, message) {
  window.open(
    `https://wa.me/${phone}?text=${encodeURIComponent(message)}`,
    "_blank"
  );
}
