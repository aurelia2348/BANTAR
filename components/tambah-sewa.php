<?php
require_once __DIR__ . '/../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_sewa'])) {
    $nama_penyewa = mysqli_real_escape_string($koneksi, $_POST['nama_penyewa'] ?? '');
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp'] ?? '');
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat'] ?? '');
    $tanggal_sewa = mysqli_real_escape_string($koneksi, $_POST['tanggal_sewa'] ?? '');
    $tanggal_kembali = mysqli_real_escape_string($koneksi, $_POST['tanggal_kembali'] ?? '');
    
    // Calculate total price accurately based on the same rules as frontend
    $days = 1;
    if ($tanggal_sewa && $tanggal_kembali) {
        $d1 = new DateTime($tanggal_sewa);
        $d2 = new DateTime($tanggal_kembali);
        if ($d2 > $d1) {
            $days = $d1->diff($d2)->days;
        }
    }
    
    $kostum_ids = $_POST['kostum_id'] ?? [];
    $qtys = $_POST['qty'] ?? [];
    $hargas = $_POST['harga_sewa'] ?? [];
    $model_prices = $_POST['harga_model'] ?? [];
    $is_karnavals = $_POST['is_karnaval'] ?? [];
    $jumlah_models = $_POST['jumlah_model'] ?? [];
    $hari_models = $_POST['hari_model'] ?? [];
    
    $total_harga = 0;
    
    for ($i = 0; $i < count($kostum_ids); $i++) {
        $q = (int)$qtys[$i];
        $h = (float)$hargas[$i];
        
        $total_harga += ($h * $q * $days);
        
        if ((int)$is_karnavals[$i] === 1) {
            $m_q = (int)$jumlah_models[$i];
            $m_d = (int)$hari_models[$i];
            $m_p = (float)$model_prices[$i];
            $total_harga += ($m_p * $m_q * $m_d);
        }
    }
    
    mysqli_begin_transaction($koneksi);
    
    try {
        $stmt_sewa = mysqli_prepare($koneksi, "INSERT INTO sewa (nama_penyewa, no_telp, alamat, tanggal_sewa, tanggal_kembali, total_harga, status) VALUES (?, ?, ?, ?, ?, ?, 'dipinjam')");
        mysqli_stmt_bind_param($stmt_sewa, "sssssd", $nama_penyewa, $no_telp, $alamat, $tanggal_sewa, $tanggal_kembali, $total_harga);
        mysqli_stmt_execute($stmt_sewa);
        $sewa_id = mysqli_insert_id($koneksi);
        
        $stmt_detail = mysqli_prepare($koneksi, "INSERT INTO detail_sewa (sewa_id, kostum_id, qty, harga, include_model, jumlah_model, hari_model) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_stok = mysqli_prepare($koneksi, "UPDATE stok_kostum SET jumlah = jumlah - ? WHERE id = ?");
        
        for ($i = 0; $i < count($kostum_ids); $i++) {
            $k_id = (int)$kostum_ids[$i];
            $q = (int)$qtys[$i];
            $h = (float)$hargas[$i];
            $incl = ((int)$is_karnavals[$i] === 1 && (int)$jumlah_models[$i] > 0) ? 1 : 0;
            $m_q = (int)$jumlah_models[$i];
            $m_d = (int)$hari_models[$i];
            
            mysqli_stmt_bind_param($stmt_detail, "iiidiii", $sewa_id, $k_id, $q, $h, $incl, $m_q, $m_d);
            mysqli_stmt_execute($stmt_detail);
            
            mysqli_stmt_bind_param($stmt_stok, "ii", $q, $k_id);
            mysqli_stmt_execute($stmt_stok);
        }
        
        mysqli_commit($koneksi);
        echo "<script>alert('Transaksi penyewaan berhasil dicatat!'); window.location.href='index.php?page=tambah-sewa';</script>";
        exit;
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
    }
}

$kostum_list = mysqli_query($koneksi, "SELECT * FROM stok_kostum ORDER BY id ASC");
?>
<div class="ds-content">
    <div class="ds-top-bar" style="margin-bottom: 48px; border-bottom: none; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <p style="font-size: 10px; color: var(--accent-gold); letter-spacing: 2px; margin-bottom: 8px; text-transform: uppercase;">NEW RESERVATION</p>
        <h1 style="font-size: 40px; margin-bottom: 16px; font-family: var(--font-heading);">Tambah Sewa</h1>
        <p style="max-width: 400px; color: var(--text-secondary); font-size: 11px; line-height: 1.6; letter-spacing: 0.5px;">
            Documenting a new chapter in the archive. Please provide the artisan details for this rental agreement.
        </p>
    </div>

    <!-- Form Section -->
    <form id="formSewa" method="POST" class="ds-form-container" style="max-width: 600px; margin: 0 auto;">

        <!-- Tenant Details -->
        <div class="ds-form-section">
            <h3 class="ds-form-section-title">Tenant Details</h3>
            <div class="ds-form-row">
                <div class="ds-form-group">
                    <label>NAMA PENYEWA <span style="color:#F44336">*</span></label>
                    <input type="text" id="tenantName" name="nama_penyewa" class="ds-input" placeholder="Enter full name" oninput="validateSewaInput(this, 'errName')">
                    <div id="errName" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama wajib diisi!</div>
                </div>
                <div class="ds-form-group">
                    <label>NOMOR TELEFON PENYEWA <span style="color:#F44336">*</span></label>
                    <input type="text" id="tenantPhone" name="no_telp" class="ds-input" placeholder="+62 000 0000 0000" oninput="validateSewaInput(this, 'errPhone')">
                    <div id="errPhone" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nomor telepon wajib diisi!</div>
                </div>
            </div>
            <div class="ds-form-row">
                <div class="ds-form-group" style="width: 100%;">
                    <label>ALAMAT SESUAI KTP</label>
                    <input type="text" name="alamat" class="ds-input" placeholder="Legal residential address">
                </div>
            </div>
        </div>

        <!-- Rental Schedule -->
        <div class="ds-form-section mt-48">
            <h3 class="ds-form-section-title">Rental Configuration</h3>
            <div class="ds-form-row">
                <div class="ds-form-group">
                    <label>TANGGAL SEWA <span style="color:#F44336">*</span></label>
                    <div class="ds-input-icon">
                        <input type="date" id="startDate" name="tanggal_sewa" class="ds-input" onchange="validateSewaInput(this, 'errStart'); calculateTotal()" style="color: rgba(255,255,255,0.5);">
                    </div>
                    <div id="errStart" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Tanggal Sewa wajib diisi!</div>
                </div>
                <div class="ds-form-group">
                    <label>TANGGAL KEMBALI SEHARUSNYA <span style="color:#F44336">*</span></label>
                    <div class="ds-input-icon">
                        <input type="date" id="endDate" name="tanggal_kembali" class="ds-input" onchange="validateSewaInput(this, 'errEnd'); calculateTotal()" style="color: rgba(255,255,255,0.5);">
                    </div>
                    <div id="errEnd" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Tanggal Kembali wajib diisi!</div>
                </div>
            </div>
        </div>

        <!-- Daftar Busana -->
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

            <!-- Model fee rows, injected dynamically per carnival item -->
            <div id="summaryModelSection"></div>

            <div style="display: flex; justify-content: space-between; margin-top: 16px; padding-top: 16px; border-top: 1px dashed var(--border-subtle); align-items: flex-end;">
                <span style="font-size: 10px; letter-spacing: 1px;">TOTAL DIBAYAR</span>
                <span id="summaryGrandTotal" style="font-family: var(--font-heading); font-size: 28px; font-weight: 600; color: #4CAF50;">Rp 0</span>
            </div>
        </div>

        <div style="text-align: center; margin-top: 48px;">
            <button id="btnSubmit" type="button" class="ds-btn-primary-large" onclick="submitForm()">SUBMIT PESANAN</button>
            <p style="font-size: 8px; color: var(--text-secondary); letter-spacing: 1px; margin-top: 16px; text-transform: uppercase;">Sistem otomatis menghitung split margin berdasarkan kategori kostum.</p>
        </div>

    </form>
</div>

<!-- Modal Pilih Baju -->
<div id="pickModal" class="ds-modal-overlay">
    <div class="ds-modal-content-lg" style="width: 700px; padding: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-family: var(--font-heading); margin: 0;">Pilih Busana</h2>
            <i class="ph ph-x" onclick="closePickModal()" style="font-size: 20px; cursor: pointer; color: var(--text-secondary);"></i>
        </div>

        <!-- Search bar -->
        <div style="margin-bottom: 16px;">
            <input type="text" id="modalSearch" class="ds-input" placeholder="Cari nama kostum..." oninput="filterModal(this.value)" style="width: 100%;">
        </div>

        <div id="modalCardGrid" style="display: flex; gap: 16px; flex-wrap: wrap; max-height: 420px; overflow-y: auto; padding-right: 4px;">
            <?php
            if ($kostum_list && mysqli_num_rows($kostum_list) > 0):
                mysqli_data_seek($kostum_list, 0);
                while ($k = mysqli_fetch_assoc($kostum_list)):
                    $k_id        = (int)$k['id'];
                    $k_nama      = htmlspecialchars($k['nama_kostum']);
                    $k_designer  = htmlspecialchars($k['nama_designer']);
                    $k_gambar    = !empty($k['gambar']) ? htmlspecialchars($k['gambar']) : 'assets/catalog_1.png';
                    $k_jumlah    = (int)$k['jumlah'];
                    $k_price     = (float)$k['rental_price'];
                    $k_modprice  = (float)$k['rental_model_price'];
                    $k_price_fmt = number_format($k_price, 0, ',', '.');
                    $k_code      = 'CTLG-' . str_pad($k_id, 4, '0', STR_PAD_LEFT);

                    $is_karnaval = (stripos($k['kategori'], 'karnaval') !== false);
                    $cat_label   = $is_karnaval ? 'KOSTUM KARNAVAL' : 'BUSANA DESAINER';
                    $cat_color   = $is_karnaval ? '#C5A39B' : 'var(--text-secondary)';

                    $disabled_style = $k_jumlah <= 0 ? 'opacity:0.4; cursor:not-allowed;' : 'cursor:pointer;';
                    $onclick = $k_jumlah > 0
                        ? "injectCostume(" .
                            $k_id . "," . // Provide ID
                            "'" . addslashes($k_nama) . "'," .
                            "'" . addslashes($k_gambar) . "'," .
                            "'" . addslashes($k_code) . "'," .
                            (int)$k_price . "," .
                            $k_jumlah . "," .
                            ($is_karnaval ? 'true' : 'false') . "," .
                            (int)$k_modprice .
                          ")"
                        : "";
            ?>
            <div class="modal-costume-card"
                 data-search="<?= strtolower($k_nama . ' ' . $k_designer . ' ' . $cat_label) ?>"
                 style="flex: 0 0 calc(33.333% - 12px); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; overflow: hidden; <?= $disabled_style ?>"
                 <?= $onclick ? 'onclick="' . $onclick . '"' : '' ?>>
                <div style="position: relative;">
                    <img src="<?= $k_gambar ?>" style="width: 100%; height: 120px; object-fit: cover;">
                    <?php if ($k_jumlah <= 0): ?>
                    <div style="position:absolute; inset:0; background:rgba(0,0,0,0.6); display:flex; align-items:center; justify-content:center; font-size:9px; letter-spacing:1px; color:#F44336;">STOK HABIS</div>
                    <?php endif; ?>
                </div>
                <div style="padding: 12px; font-size: 11px;">
                    <div style="color:<?= $cat_color ?>; font-size:8px; letter-spacing:1px; margin-bottom:4px;"><?= $cat_label ?></div>
                    <strong><?= $k_nama ?></strong>
                    <div style="color:var(--accent-gold); font-size:10px; margin-top:4px;">Rp <?= $k_price_fmt ?>/hari</div>
                    <div style="color:var(--text-secondary); font-size:9px; margin-top:2px;">Stok: <?= $k_jumlah ?></div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <div style="width:100%; text-align:center; color:var(--text-secondary); font-size:12px; padding: 32px 0;">
                Belum ada kostum yang tersimpan di database.
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // ─── Modal ────────────────────────────────────────────────────────────────
    function openPickModal() {
        const m = document.getElementById('pickModal');
        m.style.display = 'flex';
        setTimeout(() => m.classList.add('show'), 10);
    }

    function closePickModal() {
        const m = document.getElementById('pickModal');
        m.classList.remove('show');
        setTimeout(() => {
            m.style.display = 'none';
            const s = document.getElementById('modalSearch');
            if (s) { s.value = ''; filterModal(''); }
        }, 300);
    }

    function filterModal(query) {
        const q = query.toLowerCase().trim();
        document.querySelectorAll('.modal-costume-card').forEach(card => {
            const text = card.getAttribute('data-search') || '';
            card.style.display = (!q || text.includes(q)) ? '' : 'none';
        });
    }

    window.onclick = function(e) {
        const m = document.getElementById('pickModal');
        if (e.target === m) closePickModal();
    };

    // ─── Inject Costume Card ──────────────────────────────────────────────────
    // isKarnaval: true/false — apakah kostum ini kategori karnaval
    // modelPrice: harga model/hari dari DB (rental_model_price)
    function injectCostume(id, title, img, code, price, stock, isKarnaval, modelPrice) {

        // Validasi Duplikat (Opsional tapi menghindari error aneh)
        const existingInput = document.querySelector(`input[name="kostum_id[]"][value="${id}"]`);
        if (existingInput) {
            alert('Busana ini sudah ditambahkan.');
            return;
        }

        // Hidden input struct that maps strictly to arrays in PHP
        const hiddenFields = `
            <input type="hidden" name="kostum_id[]" value="${id}">
            <input type="hidden" name="harga_sewa[]" value="${price}">
            <input type="hidden" name="harga_model[]" value="${modelPrice}">
            <input type="hidden" name="is_karnaval[]" value="${isKarnaval ? 1 : 0}">
        `;

        // Section include model hanya muncul jika karnaval
        const modelSection = isKarnaval ? `
            <div class="ds-model-section" style="margin-top: 16px; padding-top: 14px; border-top: 1px solid rgba(255,255,255,0.07);">
                <div style="font-size: 9px; color: #C5A39B; letter-spacing: 1px; margin-bottom: 10px; text-transform: uppercase;">Include Model</div>
                <div style="display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap;">

                    <!-- Jumlah Model (max = jumlah sewa) -->
                    <div class="ds-selector-group">
                        <label>JUMLAH MODEL</label>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="number"
                                   class="ds-input-sm ds-model-qty"
                                   name="jumlah_model[]"
                                   value="0" min="0"
                                   style="width:40px; text-align:center; color:#C5A39B; border-bottom:1px solid rgba(255,255,255,0.2);"
                                   oninput="syncModelQtyMax(this); calculateTotal();">
                            <span style="font-size:10px; color:var(--text-secondary);">/ <span class="model-qty-max">1</span> max</span>
                        </div>
                    </div>

                    <!-- Hari Model (maks = hari sewa, dihitung saat calculate) -->
                    <div class="ds-selector-group">
                        <label>HARI MODEL</label>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <input type="number"
                                   class="ds-input-sm ds-model-days"
                                   name="hari_model[]"
                                   value="0" min="0"
                                   style="width:40px; text-align:center; color:#C5A39B; border-bottom:1px solid rgba(255,255,255,0.2);"
                                   oninput="clampModelDays(this); calculateTotal();">
                            <span style="font-size:10px; color:var(--text-secondary);">hari</span>
                        </div>
                    </div>

                    <!-- Harga model/hari dari DB -->
                    <div class="ds-selector-group">
                        <label>HRG MODEL/HARI</label>
                        <input type="text" class="ds-input-sm" value="Rp ${modelPrice.toLocaleString('id-ID')}" readonly
                               style="color:#C5A39B; width:110px;">
                    </div>

                </div>
            </div>` : `
            <input type="hidden" name="jumlah_model[]" value="0">
            <input type="hidden" name="hari_model[]" value="0">
            `;

        const cardHTML = `
            <div class="ds-item-card" data-price="${price}" data-is-karnaval="${isKarnaval}" data-model-price="${modelPrice}">
                ${hiddenFields}
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
                            <label>HRG SEWA/HARI</label>
                            <input type="text" class="ds-input-sm" value="Rp ${price.toLocaleString('id-ID')}" readonly style="color: var(--accent-gold); width:120px;">
                        </div>
                        <div class="ds-selector-group" style="align-items: flex-end;">
                            <label>JUMLAH SEWA</label>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="number" class="ds-input-sm ds-qty-input" name="qty[]" value="1" min="1"
                                       oninput="validateQty(this, ${stock}); syncModelQtyMax(this.closest('.ds-item-card').querySelector('.ds-model-qty'));"
                                       style="width:40px; color: #4CAF50; border-bottom: 1px solid rgba(255,255,255,0.2); text-align: center;">
                                <span style="font-size: 10px; color: var(--text-secondary);">/ ${stock} Tersedia</span>
                            </div>
                        </div>
                    </div>

                    ${modelSection}
                </div>
            </div>
        `;

        document.getElementById('itemContainer').insertAdjacentHTML('beforeend', cardHTML);
        document.getElementById('catalogPlaceholder').style.display = 'none';
        closePickModal();
        calculateTotal();
    }

    // Sync max value jumlah model = jumlah sewa dari card yang sama
    function syncModelQtyMax(modelQtyInput) {
        if (!modelQtyInput) return;
        const card    = modelQtyInput.closest('.ds-item-card');
        if (!card) return;
        const sewaQty = parseInt(card.querySelector('.ds-qty-input')?.value) || 1;
        const maxSpan = card.querySelector('.model-qty-max');
        if (maxSpan) maxSpan.innerText = sewaQty;

        // Clamp jika sudah melebihi
        if (parseInt(modelQtyInput.value) > sewaQty) {
            modelQtyInput.value = sewaQty;
        }
        modelQtyInput.setAttribute('max', sewaQty);
    }

    // Clamp hari model agar tidak melebihi total hari sewa
    function clampModelDays(modelDaysInput) {
        const maxDays = getRentDays();
        if (parseInt(modelDaysInput.value) > maxDays) {
            modelDaysInput.value = maxDays;
        }
        if (parseInt(modelDaysInput.value) < 0) {
            modelDaysInput.value = 0;
        }
    }

    function getRentDays() {
        const s = document.getElementById('startDate').value;
        const e = document.getElementById('endDate').value;
        if (!s || !e) return 1;
        const diff = Math.ceil((new Date(e) - new Date(s)) / 86400000);
        return diff > 0 ? diff : 1;
    }

    // ─── Placeholder check ────────────────────────────────────────────────────
    function checkPlaceholder() {
        if (document.getElementById('itemContainer').children.length === 0) {
            document.getElementById('catalogPlaceholder').style.display = 'block';
        }
    }

    // ─── Validation ───────────────────────────────────────────────────────────
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
            if (errMsg) { errMsg.innerText = errorText; errMsg.style.display = 'block'; }
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
            inputEl.style.color = '#F44336';
            inputEl.classList.add('invalid-qty');
        } else {
            inputEl.style.color = '#4CAF50';
            inputEl.classList.remove('invalid-qty');
        }
        calculateTotal();
    }

    // ─── Calculation ──────────────────────────────────────────────────────────
    function calculateTotal() {
        const days = getRentDays();
        document.getElementById('summaryDays').innerText = days + ' Hari';

        // Clamp all model-days inputs whenever dates change
        document.querySelectorAll('.ds-model-days').forEach(inp => clampModelDays(inp));

        // ── Subtotal Busana ──
        let subtotalBusana = 0;
        document.querySelectorAll('.ds-item-card').forEach(card => {
            const price = parseInt(card.getAttribute('data-price')) || 0;
            const qty   = parseInt(card.querySelector('.ds-qty-input')?.value) || 1;
            subtotalBusana += price * qty * days;
        });
        document.getElementById('summarySubtotal').innerText = 'Rp ' + subtotalBusana.toLocaleString('id-ID');

        // ── Subtotal Model (per karnaval card) ──
        let subtotalModel = 0;
        const modelSection = document.getElementById('summaryModelSection');
        modelSection.innerHTML = ''; // reset

        document.querySelectorAll('.ds-item-card').forEach(card => {
            const isKarnaval   = card.getAttribute('data-is-karnaval') === 'true';
            if (!isKarnaval) return;

            const modelPrice   = parseInt(card.getAttribute('data-model-price')) || 0;
            const modelQty     = parseInt(card.querySelector('.ds-model-qty')?.value) || 0;
            const modelDays    = parseInt(card.querySelector('.ds-model-days')?.value) || 0;
            const title        = card.querySelector('h4')?.innerText || 'Kostum';

            if (modelQty <= 0 || modelDays <= 0 || modelPrice <= 0) return;

            const fee = modelPrice * modelQty * modelDays;
            subtotalModel += fee;

            modelSection.insertAdjacentHTML('beforeend', `
                <div style="display:flex; justify-content:space-between; margin-bottom:10px; font-size:11px; color:var(--accent-gold);">
                    <span style="color:#C5A39B;">
                        Model · <em style="font-style:normal; color:var(--text-secondary);">${title}</em>
                        <span style="font-size:9px; color:var(--text-secondary); margin-left:6px;">${modelQty} model × ${modelDays} hari × Rp ${modelPrice.toLocaleString('id-ID')}</span>
                    </span>
                    <span style="font-weight:600; white-space:nowrap;">Rp ${fee.toLocaleString('id-ID')}</span>
                </div>
            `);
        });

        // ── Grand Total ──
        const grand = subtotalBusana + subtotalModel;
        document.getElementById('summaryGrandTotal').innerText = 'Rp ' + grand.toLocaleString('id-ID');
    }

    // ─── Submit ───────────────────────────────────────────────────────────────
    function submitForm() {
        const name  = document.getElementById('tenantName');
        const phone = document.getElementById('tenantPhone');
        const start = document.getElementById('startDate');
        const end   = document.getElementById('endDate');
        let valid   = true;

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
        
        validateSewaInput(start, 'errStart');
        if (start.classList.contains('invalid-input')) {
            start.classList.add('shake-error');
            setTimeout(() => start.classList.remove('shake-error'), 500);
            valid = false;
        }
        
        validateSewaInput(end, 'errEnd');
        if (end.classList.contains('invalid-input')) {
            end.classList.add('shake-error');
            setTimeout(() => end.classList.remove('shake-error'), 500);
            valid = false;
        }

        document.querySelectorAll('.invalid-qty').forEach(el => {
            el.classList.add('shake-error');
            setTimeout(() => el.classList.remove('shake-error'), 500);
            valid = false;
        });
        
        if (document.querySelectorAll('.ds-item-card').length === 0) {
            alert('Pilih minimal 1 busana terlebih dahulu.');
            valid = false;
        }

        if (valid) {
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> PROCESSING...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';

            const hiddenSubmit = document.createElement('input');
            hiddenSubmit.type = 'hidden';
            hiddenSubmit.name = 'submit_sewa';
            hiddenSubmit.value = '1';
            document.getElementById('formSewa').appendChild(hiddenSubmit);
            
            document.getElementById('formSewa').submit();
        }
    }
</script>