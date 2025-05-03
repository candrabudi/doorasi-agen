const API_BASE_URL = "https://agen-doorasi.com";
const ASSET_BASE_URL = "https://mganik-assets.pages.dev/assets";

class DistributorSearch {
  constructor() {
    this.elements = {
      accordionContainer: document.getElementById("distributorsAccordion"),
      searchInput: document.getElementById("input-field"),
    };

    this.elements.searchInput.addEventListener("input", () =>
      this.searchDistributors()
    );
    this.loadProvinceDistributors();
  }

  async loadProvinceDistributors() {
    try {
      const response = await fetch(`${API_BASE_URL}/get-province-distributors`);
      const provinces = await response.json();

      const accordion = this.elements.accordionContainer;
      accordion.innerHTML = "";

      provinces.forEach((province) => {
        const provinceItem = document.createElement("li");
        provinceItem.className = "has-children";

        const label = document.createElement("div");
        label.className = "acnav__label";
        label.innerHTML = `${province.name} <i class="fa-solid fa-chevron-down chevron"></i>`;
        label.onclick = () => this.handleProvinceClick(province.id, label);

        const regencyList = document.createElement("ul");
        regencyList.className = "acnav__list acnav__list--level2";
        regencyList.style.display = "none";

        provinceItem.appendChild(label);
        provinceItem.appendChild(regencyList);
        accordion.appendChild(provinceItem);
      });
    } catch (error) {
      console.error("Error loading provinces:", error);
    }
  }

  async handleProvinceClick(provinceId, label) {
    const regencyList = label.nextElementSibling;

    if (regencyList.dataset.loaded === "true") {
      this.toggleAccordion(label);
      return;
    }

    regencyList.innerHTML = "";
    regencyList.style.display = "block";

    try {
      const response = await fetch(
        `${API_BASE_URL}/get-regency-distributors?province_id=${provinceId}`
      );
      const regencies = await response.json();

      regencyList.innerHTML = "";

      regencies.forEach((regency) => {
        const regencyItem = document.createElement("li");
        regencyItem.className = "has-children";

        const regencyLabel = document.createElement("div");
        regencyLabel.className = "acnav__label";
        regencyLabel.innerHTML = `${regency.name} <i class="fa-solid fa-chevron-down chevron"></i>`;
        regencyLabel.onclick = () =>
          this.handleRegencyClick(regency.id, regencyLabel);

        const distributorList = document.createElement("ul");
        distributorList.className = "acnav__list acnav__list--level3";
        distributorList.style.display = "none";

        regencyItem.appendChild(regencyLabel);
        regencyItem.appendChild(distributorList);
        regencyList.appendChild(regencyItem);
      });

      regencyList.dataset.loaded = "true";
    } catch (error) {
      console.error("Error loading regencies:", error);
      regencyList.innerHTML = "<li>Gagal memuat kabupaten/kota</li>";
    }
  }

  async handleRegencyClick(regencyId, label) {
    const distributorList = label.nextElementSibling;

    if (distributorList.dataset.loaded === "true") {
      this.toggleAccordion(label);
      return;
    }

    distributorList.innerHTML = "";
    distributorList.style.display = "block";

    try {
      const response = await fetch(
        `${API_BASE_URL}/get-distributors?regency_id=${regencyId}`
      );
      const data = await response.json();

      distributorList.innerHTML = "";

      data.distributors.forEach((distributor) => {
        const distributorItem = document.createElement("li");
        distributorItem.appendChild(this.createDistributorCard(distributor));
        distributorList.appendChild(distributorItem);
      });

      distributorList.dataset.loaded = "true";
    } catch (error) {
      console.error("Error loading distributors:", error);
      distributorList.innerHTML = "<li>Gagal memuat distributor</li>";
    }
  }

  toggleAccordion(element) {
    const siblingList = element.nextElementSibling;
    const chevron = element.querySelector(".chevron");
    siblingList.style.display =
      siblingList.style.display === "none" ? "block" : "none";
    chevron.classList.toggle("rotate");
  }

  createDistributorCard(distributor) {
    const card = document.createElement("div");
    card.className = "distributor-card";
  
    // --- Header ---
    const header = document.createElement("div");
    header.className = "card-header d-flex align-items-center";
  
    const img = document.createElement("img");
    img.src =
      distributor.image_url ||
      "https://agen-doorasi.com/assets/media/logos/logo-agen-doorasi.png";
    img.className = "profile-img";
    img.style.width = "40px";
    img.style.height = "40px";
    img.style.objectFit = "contain";
  
    const info = document.createElement("div");
    info.className = "ms-2"; // Jarak lebih dekat antar logo dan nama
  
    const name = document.createElement("p");
    name.className = "distributor-name";
    name.textContent = distributor.name || distributor.full_name;
  
    // ✅ Checklist hijau di samping nama
    const checkIcon = document.createElement("i");
    checkIcon.className = "fa-solid fa-circle-check";
    checkIcon.style.color = "green";
    checkIcon.style.marginLeft = "6px";
  
    const nameWrapper = document.createElement("div");
    nameWrapper.style.display = "flex";
    nameWrapper.style.alignItems = "center";
    nameWrapper.appendChild(name);
    nameWrapper.appendChild(checkIcon);
  
    info.appendChild(nameWrapper);
    header.appendChild(img);
    header.appendChild(info);
    card.appendChild(header);
  
    // --- Body ---
    const body = document.createElement("div");
    body.className = "card-body";
  
    // Address
    const address = document.createElement("p");
    address.className = "address";
    const district = distributor.district && distributor.district.name || "";
    const regency = distributor.regency && distributor.regency.name || "";
    const province = distributor.regency && distributor.regency.province && distributor.regency.province.name || "";
    address.textContent = `${distributor.address}, ${district}, ${regency}, ${province}`;
    body.appendChild(address);
  
    // Info rows
    const infoRows = [
      {
        icon: "https://mganik-assets.pages.dev/assets/pinlocation_googlemaps.svg",
        text: `<a href="${distributor.google_maps_url || "#"}" target="_blank">Peta Google</a>`
      },
      {
        icon: "https://mganik-assets.pages.dev/assets/phone.svg",
        text: `<a href="tel:${distributor.primary_phone}">${distributor.primary_phone}</a>`
      }
    ];
  
    if (distributor.is_shipping) {
      infoRows.push({
        icon: "https://mganik-assets.pages.dev/assets/pengiriman.svg",
        text: 'Kurir Lainnya'
      });
    }
  
    if (distributor.is_cod) {
      infoRows.push({
        icon: "https://mganik-assets.pages.dev/assets/cod.svg",
        text: 'COD / Cash on Delivery'
      });
    }
  
    infoRows.forEach(({ icon, text }) => {
      const row = document.createElement("div");
      row.className = "info-row";
  
      const img = document.createElement("img");
      img.src = icon;
      img.className = "info-icon";
      img.alt = "";
  
      const span = document.createElement("span");
      span.innerHTML = text;
  
      row.appendChild(img);
      row.appendChild(span);
      body.appendChild(row);
    });
  
    // Shipments
    if (Array.isArray(distributor.shipments) && distributor.shipments.length > 0) {
      const shipmentRow = document.createElement("div");
      shipmentRow.className = "info-row";
  
      const icon = document.createElement("img");
      icon.loading = "lazy";
      icon.alt = "shipping-icon";
      icon.className = "info-icon";
      icon.src = "https://mganik-assets.pages.dev/assets/pengiriman.svg";
  
      const label = document.createElement("span");
      label.style.fontSize = "14px";
      label.textContent = distributor.shipments.map(s => s.name).join(", ");
  
      shipmentRow.appendChild(icon);
      shipmentRow.appendChild(label);
  
      body.appendChild(shipmentRow);
    }
  
    // Marketplaces
    if (Array.isArray(distributor.marketplaces) && distributor.marketplaces.length > 0) {
      const marketplaceDiv = document.createElement("div");
      marketplaceDiv.className = "marketplace-icons mt-2";
  
      distributor.marketplaces.forEach((mp) => {
        const a = document.createElement("a");
        a.href = mp.pivot && mp.pivot.url ? mp.pivot.url : "#";
        a.target = "_blank";
  
        const icon = document.createElement("img");
        icon.src = "https://agen-doorasi.com/storage/icons/" + mp.icon;
        icon.alt = mp.name;
        icon.title = mp.name;
        icon.style.width = "30px";
        icon.style.marginRight = "5px";
  
        a.appendChild(icon);
        marketplaceDiv.appendChild(a);
      });
  
      body.appendChild(marketplaceDiv);
    }
  
    card.appendChild(body);
  
    // --- Footer ---
    const footer = document.createElement("div");
    footer.className = "card-footer mt-3";
  
    const btn = document.createElement("button");
    btn.className = "btn-wa";
    btn.onclick = function () {
      directToWA(distributor.primary_phone, "Halo, saya tertarik membeli produk Doorasi.");
    };
  
    const waImg = document.createElement("img");
    waImg.src = "https://mganik-assets.pages.dev/assets/whatsapp.png";
    waImg.alt = "WhatsApp";
    waImg.width = 18;
    waImg.style.marginRight = "6px";
  
    btn.appendChild(waImg);
    btn.appendChild(document.createTextNode("BELI DISINI"));
  
    footer.appendChild(btn);
    card.appendChild(footer);
  
    return card;
  }

  directToWA(phone, message) {
    window.open(
      `https://wa.me/${phone}?text=${encodeURIComponent(message)}`,
      "_blank"
    );
  }

  searchDistributors() {
    const query = this.elements.searchInput.value.toLowerCase();
    const distributorCards = document.querySelectorAll(".distributor-card");

    distributorCards.forEach((card) => {
      const name = card
        .querySelector(".distributor-name")
        .textContent.toLowerCase();
      if (name.includes(query)) {
        card.style.display = "";
      } else {
        card.style.display = "none";
      }
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new DistributorSearch();
});
