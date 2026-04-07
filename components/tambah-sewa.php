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
                    <label>NAMA PENYEWA</label>
                    <input type="text" class="ds-input" placeholder="Enter full name">
                </div>
                <div class="ds-form-group">
                    <label>NOMOR TELEFON PENYEWA</label>
                    <input type="text" class="ds-input" placeholder="+62 000 0000 0000">
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
                        <input type="date" class="ds-input" value="dd/mm/yyyy" style="color: rgba(255,255,255,0.5);">
                    </div>
                </div>
                <div class="ds-form-group">
                    <label>TANGGAL KEMBALI SEHARUSNYA</label>
                    <div class="ds-input-icon">
                        <input type="date" class="ds-input" value="dd/mm/yyyy" style="color: rgba(255,255,255,0.5);">
                    </div>
                </div>
            </div>
            
            <!-- NEW SETTING FOR CATEGORY & MODEL -->
            <div class="ds-form-row" style="margin-top: 24px;">
                <div class="ds-form-group">
                    <label>KATEGORI PENYEWAAN</label>
                    <select class="ds-input" onchange="toggleModelOpt(this)" style="appearance: auto; color: var(--text-primary); cursor: pointer; background-color: rgba(255,255,255,0.03);">
                        <option value="designer" selected>Busana Desainer (Reguler)</option>
                        <option value="carnival">Kostum Karnaval</option>
                    </select>
                </div>
                <div class="ds-form-group" id="modelOptionContainer" style="opacity: 0.3; pointer-events: none;">
                    <label>INCLUDE MODEL?</label>
                    <select class="ds-input" style="appearance: auto; color: var(--text-primary); cursor: pointer; background-color: rgba(255,255,255,0.03);">
                        <option value="no">Tidak (Hanya Kostum)</option>
                        <option value="yes">Ya (+Fee Talent 30%)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Input Baju (Cleaned up) -->
        <div class="ds-form-section mt-48">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
                <h3 class="ds-form-section-title" style="margin-bottom: 0;">Daftar Busana</h3>
                <button type="button" class="ds-btn-text-gold">
                    <i class="ph ph-plus-circle"></i> TAMBAH BAJU
                </button>
            </div>
            
            <div class="ds-catalog-placeholder ds-card" style="text-align: center; cursor: pointer; border: 1px dashed rgba(255,255,255,0.1); padding: 40px; border-radius: 8px;">
                <div class="ds-placeholder-icon" style="margin-bottom: 16px;">
                    <i class="ph ph-plus" style="font-size: 24px; color: var(--text-secondary);"></i>
                </div>
                <h3 style="font-size: 14px; margin-bottom: 8px; color: var(--text-secondary);">Belum Ada Busana</h3>
                <p style="font-size: 11px; color: var(--text-secondary); opacity: 0.6;">Klik 'Tambah Baju' untuk memilih kostum dari inventori.</p>
            </div>

        </div>

        <div style="text-align: center; margin-top: 64px;">
            <button class="ds-btn-primary-large">SUBMIT PESANAN</button>
            <p style="font-size: 8px; color: var(--text-secondary); letter-spacing: 1px; margin-top: 16px; text-transform: uppercase;">Sistem otomatis menghitung Split Margin 10/90 atau 70/30 berdasarkan kategori yang dipilih.</p>
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
</script>
