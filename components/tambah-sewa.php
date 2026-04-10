<div class="ds-content">
    <div class="ds-top-bar" style="margin-bottom: 48px; border-bottom: none; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <p style="font-size: 10px; color: var(--accent-gold); letter-spacing: 2px; margin-bottom: 8px; text-transform: uppercase;">NEW RESERVATION</p>
        <h1 style="font-size: 40px; margin-bottom: 16px; font-family: var(--font-heading);">Tambah Sewa</h1>
        <p style="max-width: 400px; color: var(--text-secondary); font-size: 11px; line-height: 1.6; letter-spacing: 0.5px;">
            Documenting a new chapter in the archive. Please provide the artisan details for this rental agreement.
        </p>
    </div>

    <!-- Form Section -->
    <div class="ds-form-container" style="max-width: 600px; margin: 0 auto;">

        <!-- Tenant Details -->
        <div class="ds-form-section">
            <h3 class="ds-form-section-title">Tenant Details</h3>
            <div class="ds-form-row">
                <div class="ds-form-group">
                    <label>NAMA PENYEWA <span style="color:#F44336">*</span></label>
                    <input type="text" id="tenantName" class="ds-input" placeholder="Enter full name" oninput="validateSewaInput(this, 'errName')">
                    <div id="errName" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama wajib diisi!</div>
                </div>
                <div class="ds-form-group">
                    <label>NOMOR TELEFON PENYEWA <span style="color:#F44336">*</span></label>
                    <input type="text" id="tenantPhone" class="ds-input" placeholder="+62 000 0000 0000" oninput="validateSewaInput(this, 'errPhone')">
                    <div id="errPhone" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nomor telepon wajib diisi!</div>
                </div>
            </div>
            <div class="ds-form-row">
                <div class="ds-form-group" style="width: 100%;">
                    <label>ALAMAT SESUAI KTP</label>
                    <input type="text" class="ds-input" placeholder="Legal residential address">
                </div>
            </div>
        </div>

        <!-- Rental Schedule & Config -->
        <div class="ds-form-section mt-48">
            <h3 class="ds-form-section-title">Rental Configuration</h3>
            <div class="ds-form-row">
                <div class="ds-form-group">
                    <label>TANGGAL SEWA</label>
                    <div class="ds-input-icon">
                        <input type="date" id="startDate" class="ds-input" onchange="calculateTotal()" style="color: rgba(255,255,255,0.5);">
                    </div>
                </div>
                <div class="ds-form-group">
                    <label>TANGGAL KEMBALI SEHARUSNYA</label>
                    <div class="ds-input-icon">
                        <input type="date" id="endDate" class="ds-input" onchange="calculateTotal()" style="color: rgba(255,255,255,0.5);">
                    </div>
                </div>
            </div>

            <!-- NEW SETTING FOR CATEGORY & MODEL -->
            <div class="ds-form-row" style="margin-top: 24px;">
                <div class="ds-form-group">
                    <label>KATEGORI PENYEWAAN</label>
                    <select id="catSelect" class="ds-input" onchange="toggleModelOpt(this); calculateTotal();" style="appearance: auto; color: var(--text-primary); cursor: pointer; background-color: rgba(255,255,255,0.03);">
                        <option value="designer" selected>Busana Desainer (Reguler)</option>
                        <option value="carnival">Kostum Karnaval</option>
                    </select>
                </div>
                <div class="ds-form-group" id="modelOptionContainer" style="opacity: 0.3; pointer-events: none;">
                    <label>INCLUDE MODEL?</label>
                    <select id="modelSelect" class="ds-input" onchange="calculateTotal()" style="appearance: auto; color: var(--text-primary); cursor: pointer; background-color: rgba(255,255,255,0.03);">
                        <option value="no">Tidak (Hanya Kostum)</option>
                        <option value="yes">Ya (+Fee Talent Khusus)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Input Baju (Cleaned up) -->
        <div class="ds-form-section mt-48">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
                <h3 class="ds-form-section-title" style="margin-bottom: 0;">Daftar Busana</h3>
                <button type="button" class="ds-btn-text-gold" onclick="openPickModal()">
                    <i class="ph ph-plus-circle"></i> TAMBAH BAJU
                </button>
            </div>

            <div id="itemContainer"></div>

            <div id="catalogPlaceholder" class="ds-catalog-placeholder ds-card" onclick="openPickModal()" style="text-align: center; cursor: pointer; border: 1px dashed rgba(255,255,255,0.1); padding: 40px; border-radius: 8px;">
                <div class="ds-placeholder-icon" style="margin-bottom: 16px;">
                    <i class="ph ph-plus" style="font-size: 24px; color: var(--text-secondary);"></i>
                </div>
                <h3 style="font-size: 14px; margin-bottom: 8px; color: var(--text-secondary);">Belum Ada Busana</h3>
                <p style="font-size: 11px; color: var(--text-secondary); opacity: 0.6;">Klik 'Tambah Baju' untuk memilih kostum dari inventori.</p>
            </div>

        </div>

        <!-- Order Summary Box -->
        <div id="orderSummaryBox" class="ds-card" style="margin-top: 24px; padding: 24px;">
            <h4 style="font-family: var(--font-heading); margin: 0 0 16px 0; font-size: 16px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 16px;">Ringkasan Tagihan</h4>

            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 11px; color: var(--text-secondary);">
                <span>Total Durasi Sewa</span>
                <span id="summaryDays" style="font-weight: 600; color: var(--text-primary);">0 Hari</span>
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 11px; color: var(--text-secondary);">
                <span>Subtotal Busana</span>
                <span id="summarySubtotal" style="font-weight: 600; color: var(--text-primary);">Rp 0</span>
            </div>

            <div id="summaryModelRow" style="display: none; justify-content: space-between; margin-bottom: 12px; font-size: 11px; color: var(--accent-gold);">
                <span>Fee Talent (Model)</span>
                <span id="summaryModelFee" style="font-weight: 600;">Rp 0</span>
            </div>

            <div style="display: flex; justify-content: space-between; margin-top: 16px; padding-top: 16px; border-top: 1px dashed var(--border-subtle); align-items: flex-end;">
                <span style="font-size: 10px; letter-spacing: 1px;">TOTAL DIBAYAR</span>
                <span id="summaryGrandTotal" style="font-family: var(--font-heading); font-size: 28px; font-weight: 600; color: #4CAF50;">Rp 0</span>
            </div>
        </div>

        <div style="text-align: center; margin-top: 48px;">
            <button id="btnSubmit" class="ds-btn-primary-large" onclick="submitForm()">SUBMIT PESANAN</button>
            <p style="font-size: 8px; color: var(--text-secondary); letter-spacing: 1px; margin-top: 16px; text-transform: uppercase;">Sistem otomatis menghitung Split Margin 10/90 atau 70/30 berdasarkan kategori yang dipilih.</p>
        </div>

    </div>
</div>

<!-- Modal Pilih Baju -->
<div id="pickModal" class="ds-modal-overlay">
    <div class="ds-modal-content-lg" style="width: 700px; padding: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-family: var(--font-heading); margin: 0;">Pilih Busana</h2>
            <i class="ph ph-x" onclick="closePickModal()" style="font-size: 20px; cursor: pointer; color: var(--text-secondary);"></i>
        </div>

        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <!-- Modal Card 1 -->
            <div style="flex: 1; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; overflow: hidden; cursor:pointer;" onclick="injectCostume('Midnight Structure', 'assets/catalog_1.png', 'CTLG-MD-8812', 2500000, 5)">
                <img src="assets/catalog_1.png" style="width: 100%; height: 120px; object-fit: cover;">
                <div style="padding: 12px; font-size: 11px;">
                    <div style="color:var(--text-secondary); font-size:8px; letter-spacing:1px; margin-bottom:4px;">BUSANA DESAINER</div>
                    <strong>Midnight Structure</strong>
                    <div style="color:var(--accent-gold); font-size:10px; margin-top:4px;">Rp 2.500.000/hari</div>
                </div>
            </div>
            <!-- Modal Card 2 -->
            <div style="flex: 1; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; overflow: hidden; cursor:pointer;" onclick="injectCostume('Garuda Emas', 'assets/catalog_4.png', 'CTLG-GN-1102', 850000, 2)">
                <img src="assets/catalog_4.png" style="width: 100%; height: 120px; object-fit: cover;">
                <div style="padding: 12px; font-size: 11px;">
                    <div style="color:#C5A39B; font-size:8px; letter-spacing:1px; margin-bottom:4px;">KOSTUM KARNAVAL</div>
                    <strong>Garuda Emas</strong>
                    <div style="color:var(--accent-gold); font-size:10px; margin-top:4px;">Rp 850.000/hari</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleModelOpt(selectElement) {
        const modelOpt = document.getElementById('modelOptionContainer');
        if (selectElement.value === 'carnival') {
            modelOpt.style.opacity = '1';
            modelOpt.style.pointerEvents = 'auto';
        } else {
            modelOpt.style.opacity = '0.3';
            modelOpt.style.pointerEvents = 'none';
            modelOpt.querySelector('select').value = 'no'; // Reset to no
        }
    }

    // Modal Add Costume Logic
    function openPickModal() {
        const m = document.getElementById('pickModal');
        m.style.display = 'flex';
        setTimeout(() => m.classList.add('show'), 10);
    }

    function closePickModal() {
        const m = document.getElementById('pickModal');
        m.classList.remove('show');
        setTimeout(() => m.style.display = 'none', 300);
    }

    function injectCostume(title, img, code, price, stock) {
        // Build card HTML
        const cardHTML = `
            <div class="ds-item-card" data-price="${price}">
                <img src="${img}" class="ds-item-img" alt="${title}">
                <div class="ds-item-details">
                    <div class="ds-item-header">
                        <div>
                            <h4 style="margin:0;">${title}</h4>
                            <span class="ds-badge-gold" style="margin-top:4px; display:inline-block;">${code}</span>
                        </div>
                        <i class="ph ph-x ds-item-close" onclick="this.closest('.ds-item-card').remove(); checkPlaceholder(); calculateTotal();"></i>
                    </div>
                    
                    <div class="ds-item-selectors" style="display: flex; justify-content: space-between; align-items: flex-end; margin-top:16px;">
                        <div class="ds-selector-group">
                            <label>Hrg Sewa/Hari</label>
                            <input type="text" class="ds-input-sm" value="Rp ${price.toLocaleString('id-ID')}" readonly style="color: var(--accent-gold); width:120px;">
                        </div>
                        <div class="ds-selector-group" style="align-items: flex-end;">
                            <label>JUMLAH SEWA</label>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="number" class="ds-input-sm ds-qty-input" value="1" min="1" oninput="validateQty(this, ${stock})" style="width:40px; color: #4CAF50; border-bottom: 1px solid rgba(255,255,255,0.2); text-align: center;">
                                <span style="font-size: 10px; color: var(--text-secondary);">/ ${stock} Tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('itemContainer').insertAdjacentHTML('beforeend', cardHTML);

        // Hide placeholder
        document.getElementById('catalogPlaceholder').style.display = 'none';
        closePickModal();

        // Auto Calculate
        calculateTotal();
    }

    function checkPlaceholder() {
        if (document.getElementById('itemContainer').children.length === 0) {
            document.getElementById('catalogPlaceholder').style.display = 'block';
        }
    }

    function validateSewaInput(inputEl, errId) {
        const errMsg = document.getElementById(errId);
        let errorText = '';
        const val = inputEl.value;

        if (!val.trim()) {
            errorText = 'Wajib diisi!';
        } else if (inputEl.id === 'tenantName' && /\d/.test(val)) {
            errorText = 'Nama tidak boleh mengandung angka!';
        } else if (inputEl.id === 'tenantPhone' && /[a-zA-Z]/.test(val)) {
            errorText = 'Nomor telepon tidak boleh mengandung huruf!';
        }

        if (errorText) {
            inputEl.style.borderBottomColor = '#F44336';
            if (errMsg) {
                errMsg.innerText = errorText;
                errMsg.style.display = 'block';
            }
            inputEl.classList.add('invalid-input');
        } else {
            inputEl.style.borderBottomColor = 'rgba(255,255,255,0.2)';
            if (errMsg) errMsg.style.display = 'none';
            inputEl.classList.remove('invalid-input');
        }
    }

    function validateQty(inputEl, maxStock) {
        const val = parseInt(inputEl.value) || 0;
        if (val > maxStock) {
            inputEl.style.color = '#F44336'; // Red
            inputEl.classList.add('invalid-qty');
        } else {
            inputEl.style.color = '#4CAF50'; // Green
            inputEl.classList.remove('invalid-qty');
        }
        calculateTotal();
    }

    // Calculation Logic
    function calculateTotal() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const catSelect = document.getElementById('catSelect').value;
        const modelSelect = document.getElementById('modelSelect').value;

        // Calculate duration logic
        let days = 1;
        if (startDate && endDate) {
            const d1 = new Date(startDate);
            const d2 = new Date(endDate);
            const diffTime = d2 - d1;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays > 0) days = diffDays;
        }

        document.getElementById('summaryDays').innerText = days + ' Hari';

        // Base price aggregation
        let baseSubtotal = 0;
        let totalItems = 0;
        const cards = document.querySelectorAll('.ds-item-card');
        cards.forEach(card => {
            const p = parseInt(card.getAttribute('data-price')) || 0;
            const qtyInput = card.querySelector('.ds-qty-input');
            const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
            totalItems += qty;
            baseSubtotal += (p * qty);
        });

        const totalCostumePrice = baseSubtotal * days;
        document.getElementById('summarySubtotal').innerText = 'Rp ' + totalCostumePrice.toLocaleString('id-ID');

        // Model Fee Logic (Only applies if Carnival + Use Model)
        let modelFee = 0;
        const modelRow = document.getElementById('summaryModelRow');

        if (catSelect === 'carnival' && modelSelect === 'yes') {
            // Asumsi penambahan Rp 500.000 per busana untuk fee talent model (dikali hari)
            modelFee = 500000 * totalItems * days;
            modelRow.style.display = 'flex';
            document.getElementById('summaryModelFee').innerText = '+ Rp ' + modelFee.toLocaleString('id-ID');
        } else {
            modelRow.style.display = 'none';
        }

        // Grand Total
        const grandTotal = totalCostumePrice + modelFee;
        document.getElementById('summaryGrandTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    // Validation Logic
    function submitForm() {
        const name = document.getElementById('tenantName');
        const phone = document.getElementById('tenantPhone');
        let valid = true;

        validateSewaInput(name, 'errName');
        if (name.classList.contains('invalid-input')) {
            name.classList.add('shake-error');
            setTimeout(() => name.classList.remove('shake-error'), 500);
            valid = false;
        }

        validateSewaInput(phone, 'errPhone');
        if (phone.classList.contains('invalid-input')) {
            phone.classList.add('shake-error');
            setTimeout(() => phone.classList.remove('shake-error'), 500);
            valid = false;
        }

        const invalidQtyInputs = document.querySelectorAll('.invalid-qty');
        if (invalidQtyInputs.length > 0) {
            valid = false;
            invalidQtyInputs.forEach(el => {
                el.classList.add('shake-error');
                setTimeout(() => el.classList.remove('shake-error'), 500);
            });
        }

        if (valid) {
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> PROCESSING...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';

            setTimeout(() => {
                btn.innerHTML = '<i class="ph-fill ph-check-circle"></i> TRANSAKSI SUKSES';
                btn.style.background = '#4CAF50';
                btn.style.color = '#fff';
            }, 1500);
        }
    }
</script>