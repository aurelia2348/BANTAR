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

        <!-- Rental Schedule -->
        <div class="ds-form-section mt-48">
            <h3 class="ds-form-section-title">Rental Schedule</h3>
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
        </div>

        <!-- Input Baju -->
        <div class="ds-form-section mt-48">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
                <h3 class="ds-form-section-title" style="margin-bottom: 0;">Input Baju</h3>
                <button type="button" class="ds-btn-text-gold">
                    <i class="ph ph-plus-circle"></i> TAMBAH BAJU
                </button>
            </div>
            
            <!-- Item Card 1 -->
            <div class="ds-item-card">
                <img src="assets/trending_piece.png" class="ds-item-img" alt="The Obsidian Couture">
                <div class="ds-item-details">
                    <div class="ds-item-header">
                        <div>
                            <h4>The Obsidian Couture</h4>
                            <span class="ds-badge-gold">CTLG-CD-#3901</span>
                        </div>
                        <i class="ph ph-x ds-item-close"></i>
                    </div>
                    
                    <div class="ds-item-selectors">
                        <div class="ds-selector-group">
                            <label>SIZE</label>
                            <select class="ds-select">
                                <option>Medium (Standard)</option>
                            </select>
                        </div>
                        <div class="ds-selector-group">
                            <label>CONDITION CKY</label>
                            <input type="text" class="ds-input-sm" value="Excellent" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item Card 2 -->
            <div class="ds-item-card">
                <img src="assets/midnight_silk_tunic.png" class="ds-item-img" alt="Midnight Silk Tunic">
                <div class="ds-item-details">
                    <div class="ds-item-header">
                        <div>
                            <h4>Midnight Silk Tunic</h4>
                            <span class="ds-badge-gold">CTLG-CD-#7506</span>
                        </div>
                        <i class="ph ph-x ds-item-close"></i>
                    </div>
                    
                    <div class="ds-item-selectors">
                        <div class="ds-selector-group">
                            <label>SIZE</label>
                            <select class="ds-select">
                                <option>Universal Size</option>
                            </select>
                        </div>
                        <div class="ds-selector-group">
                            <label>CONDITION CKY</label>
                            <input type="text" class="ds-input-sm ds-input-disabled" value="New Archive" readonly style="color: var(--text-secondary);">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div style="text-align: center; margin-top: 64px;">
            <button class="ds-btn-primary-large">SUBMIT PESANAN</button>
            <p style="font-size: 8px; color: var(--text-secondary); letter-spacing: 1px; margin-top: 16px; text-transform: uppercase;">VERIFICATION PROCESS WILL BEGIN UPON SUBMISSION</p>
        </div>
        
    </div>
</div>
