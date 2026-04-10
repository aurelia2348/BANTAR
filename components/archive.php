<div class="ds-content">
    <div class="ds-top-bar" style="margin-bottom: 24px;">
        <div class="ds-title">
            <p style="font-size: 10px; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 8px;">CURATED COLLECTION</p>
            <h1 style="font-size: 48px; margin-bottom: 16px;">Archive Catalog</h1>
            <p style="max-width: 600px; color: var(--text-secondary); font-size: 13px; line-height: 1.6; letter-spacing: normal; text-transform: none;">
                Exploring the boundaries of theatrical elegance. Our current inventory features 1,402 bespoke pieces from the Victorian era through modern avant-garde.
            </p>
        </div>
        <div class="ds-actions" style="display: flex; gap: 16px; align-self: center;">
            <button class="ds-btn-outline">FILTER</button>
            <button class="ds-btn-outline">SORT: RECENT</button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="ds-tabs">
        <div class="ds-tab active" onclick="filterCat(this, 'all')">SEMUA KOLEKSI</div>
        <div class="ds-tab" onclick="filterCat(this, 'designer')">BUSANA DESAINER</div>
        <div class="ds-tab" onclick="filterCat(this, 'carnival')">KOSTUM KARNAVAL</div>
    </div>

    <!-- Grid -->
    <div class="ds-catalog-grid">
        
        <!-- Item 1 -->
        <div class="ds-catalog-card" data-cat="designer">
            <img src="assets/catalog_1.png" alt="Midnight Structure">
            <div class="ds-avail-badge ds-avail-green">AVAILABLE</div>
            <div class="ds-catalog-overlay">
                <div class="ds-catalog-top">
                    <span class="ds-cat-label" style="color: #8CA3C5;">BUSANA DESAINER</span>
                </div>
                <div class="ds-cat-hover-actions">
                    <button class="ds-btn-cat-action" onclick="openQuickView('assets/catalog_1.png', 'Midnight Structure', 'BUSANA DESAINER', 'Rp 2,5 Jt', 'AVAILABLE', 'green', 'Sebuah mahakarya Haute Couture dari Bara Exclusives. Menyatukan tekstur velvet kelam dengan kerangka struktur emas yang tersembunyi. Sangat populer untuk sesi pemotretan bertema Gothic dan Met Gala.', '500.000', 1, 5)"><i class="ph ph-eye"></i> QUICK VIEW</button>
                    <button class="ds-btn-cat-action primary" onclick="window.location.href='index.php?page=tambah-sewa'"><i class="ph ph-shopping-bag"></i> RENT</button>
                </div>
                <div style="width: 100%;">
                    <div class="ds-catalog-bottom" style="margin-bottom: 12px;">
                        <div>
                            <div style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin-bottom: 4px; text-transform: uppercase;">By Bara Exclusives</div>
                            <h3 class="ds-cat-title">Midnight<br>Structure</h3>
                        </div>
                        <div class="ds-cat-price">
                            <strong>Rp 2,5 Jt</strong><span>/hari</span>
                        </div>
                    </div>
                    <div style="font-size: 11px; color: var(--text-secondary); padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between;">
                        <span>Stok Tersedia:</span>
                        <span><strong style="color: #fff;">1</strong> / 5</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="ds-catalog-card" data-cat="designer">
            <img src="assets/catalog_2.png" alt="Crimson Sovereign">
            <div class="ds-avail-badge ds-avail-red">RENTED</div>
            <div class="ds-catalog-overlay">
                <div class="ds-catalog-top">
                    <span class="ds-cat-label" style="color: #8CA3C5;">BUSANA DESAINER</span>
                </div>
                <div class="ds-cat-hover-actions">
                    <button class="ds-btn-cat-action" onclick="openQuickView('assets/catalog_2.png', 'Crimson Sovereign', 'BUSANA DESAINER', 'Rp 4,2 Jt', 'RENTED', 'red', 'Busana megah berwarna crimson dengan teknik draping khusus dari Alexander McQueen. Bagian bahu diperkuat dengan chainmail ringan untuk memberikan kesan royal dan superior.', '1.200.000', 0, 2)"><i class="ph ph-eye"></i> QUICK VIEW</button>
                    <button class="ds-btn-cat-action primary" style="background:#555; pointer-events:none;"><i class="ph ph-lock"></i> UNAVAILABLE</button>
                </div>
                <div style="width: 100%;">
                    <div class="ds-catalog-bottom" style="margin-bottom: 12px;">
                        <div>
                            <div style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin-bottom: 4px; text-transform: uppercase;">By Alexander McQueen</div>
                            <h3 class="ds-cat-title">Crimson<br>Sovereign</h3>
                        </div>
                        <div class="ds-cat-price">
                            <strong>Rp 4,2 Jt</strong><span>/hari</span>
                        </div>
                    </div>
                    <div style="font-size: 11px; color: var(--text-secondary); padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between;">
                        <span>Stok Tersedia:</span>
                        <span><strong style="color: #F44336;">0</strong> / 2</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item 3 -->
        <div class="ds-catalog-card" data-cat="designer">
            <img src="assets/catalog_3.png" alt="Alabaster Fold">
            <div class="ds-avail-badge ds-avail-green">AVAILABLE</div>
            <div class="ds-catalog-overlay">
                <div class="ds-catalog-top">
                    <span class="ds-cat-label" style="color: #8CA3C5;">BUSANA DESAINER</span>
                </div>
                <div class="ds-cat-hover-actions">
                    <button class="ds-btn-cat-action" onclick="openQuickView('assets/catalog_3.png', 'Alabaster Fold', 'BUSANA DESAINER', 'Rp 1,8 Jt', 'AVAILABLE', 'green', 'Potongan artistik bernuansa futuristik dengan tekstur berlipat khas 3D printing.', '750.000', 3, 3)"><i class="ph ph-eye"></i> QUICK VIEW</button>
                    <button class="ds-btn-cat-action primary" onclick="window.location.href='index.php?page=tambah-sewa'"><i class="ph ph-shopping-bag"></i> RENT</button>
                </div>
                <div style="width: 100%;">
                    <div class="ds-catalog-bottom" style="margin-bottom: 12px;">
                        <div>
                            <div style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin-bottom: 4px; text-transform: uppercase;">By Iris Van Herpen</div>
                            <h3 class="ds-cat-title">Alabaster<br>Fold</h3>
                        </div>
                        <div class="ds-cat-price">
                            <strong>Rp 1,8 Jt</strong><span>/hari</span>
                        </div>
                    </div>
                    <div style="font-size: 11px; color: var(--text-secondary); padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between;">
                        <span>Stok Tersedia:</span>
                        <span><strong style="color: #fff;">3</strong> / 3</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item 4 -->
        <div class="ds-catalog-card" data-cat="carnival">
            <img src="assets/catalog_4.png" alt="Garuda Emas">
            <div class="ds-avail-badge ds-avail-green">AVAILABLE</div>
            <div class="ds-catalog-overlay">
                <div class="ds-catalog-top">
                    <span class="ds-cat-label" style="color: #C5A39B;">KOSTUM KARNAVAL</span>
                </div>
                <div class="ds-cat-hover-actions">
                    <button class="ds-btn-cat-action" onclick="openQuickView('assets/catalog_4.png', 'Garuda Emas', 'KOSTUM KARNAVAL', 'Rp 850 Rb', 'AVAILABLE', 'green', 'Sayap replika besar dengan ornamen batik emas untuk parade dan hari jadi.', '300.000', 2, 4)"><i class="ph ph-eye"></i> QUICK VIEW</button>
                    <button class="ds-btn-cat-action primary" onclick="window.location.href='index.php?page=tambah-sewa'"><i class="ph ph-shopping-bag"></i> RENT</button>
                </div>
                <div style="width: 100%;">
                    <div class="ds-catalog-bottom" style="margin-bottom: 12px;">
                        <div>
                            <div style="font-size: 10px; color: #C5A39B; letter-spacing: 1px; margin-bottom: 4px; text-transform: uppercase;">Komunitas BANTAR</div>
                            <h3 class="ds-cat-title">Garuda<br>Emas</h3>
                        </div>
                        <div class="ds-cat-price">
                            <strong>Rp 850 Rb</strong><span>/hari</span>
                        </div>
                    </div>
                    <div style="font-size: 11px; color: var(--text-secondary); padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between;">
                        <span>Stok Tersedia:</span>
                        <span><strong style="color: #fff;">2</strong> / 4</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item Placeholder / Add -->
        <div class="ds-catalog-placeholder ds-card" onclick="window.location.href='index.php?page=tambah-busana'">
            <div class="ds-placeholder-icon">
                <i class="ph ph-plus"></i>
            </div>
            <h3>Expanding the<br>Bantar</h3>
            <p>NEW ACQUISITIONS<br>ARRIVING WEEKLY</p>
        </div>

        <!-- Item 5 -->
        <div class="ds-catalog-card" data-cat="designer">
            <img src="assets/catalog_5.png" alt="Canary Volume">
            <div class="ds-avail-badge ds-avail-green">AVAILABLE</div>
            <div class="ds-catalog-overlay">
                <div class="ds-catalog-top">
                    <span class="ds-cat-label" style="color: #8CA3C5;">BUSANA DESAINER</span>
                </div>
                <div class="ds-cat-hover-actions">
                    <button class="ds-btn-cat-action" onclick="openQuickView('assets/catalog_5.png', 'Canary Volume', 'BUSANA DESAINER', 'Rp 3,1 Jt', 'AVAILABLE', 'green', 'Koleksi Canary Volume memiliki arsitektur lengan balon yang asimetris. Dominasi warna emas yang mencolok sempurna untuk sesi foto editorial bertema High-Fashion.', '500.000', 1, 2)"><i class="ph ph-eye"></i> QUICK VIEW</button>
                    <button class="ds-btn-cat-action primary" onclick="window.location.href='index.php?page=tambah-sewa'"><i class="ph ph-shopping-bag"></i> RENT</button>
                </div>
                <div style="width: 100%;">
                    <div class="ds-catalog-bottom" style="margin-bottom: 12px;">
                        <div>
                            <div style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin-bottom: 4px; text-transform: uppercase;">By Bara Exclusives</div>
                            <h3 class="ds-cat-title">Canary<br>Volume</h3>
                        </div>
                        <div class="ds-cat-price">
                            <strong>Rp 3,1 Jt</strong><span>/hari</span>
                        </div>
                    </div>
                    <div style="font-size: 11px; color: var(--text-secondary); padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between;">
                        <span>Stok Tersedia:</span>
                        <span><strong style="color: #fff;">1</strong> / 2</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick View Modal -->
    <div id="quickViewModal" class="ds-modal-overlay">
        <div class="ds-modal-content-lg" style="display: flex; padding: 0;">
            <!-- Left Image -->
            <div style="width: 45%; position: relative;">
                <img id="qvImage" src="assets/catalog_1.png" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px 0 0 8px;">
                <div id="qvBadge" class="ds-avail-badge ds-avail-green" style="top: 24px; left: 24px; right: auto;">AVAILABLE</div>
            </div>
            <!-- Right Details -->
            <div style="width: 55%; padding: 40px; display: flex; flex-direction: column;">
                <i class="ph ph-x ds-modal-close" onclick="closeQuickView()" style="align-self: flex-end; font-size: 24px; cursor: pointer; color: var(--text-secondary);"></i>
                
                <div style="margin-top: -10px;">
                    <span id="qvCat" class="ds-cat-label" style="color: #8CA3C5;">BUSANA DESAINER</span>
                    <h2 id="qvTitle" style="font-family: var(--font-heading); font-size: 32px; margin: 8px 0;">Midnight Structure</h2>
                    <p id="qvCode" style="font-size: 11px; color: var(--text-secondary); letter-spacing: 1px;">CODE: CTLG-<span id="qvCodeVal">MD-8812</span></p>
                </div>
                
                <p id="qvDesc" style="color: var(--text-secondary); font-size: 13px; line-height: 1.6; margin: 24px 0; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 24px;">
                    Sebuah mahakarya Haute Couture. Menyatukan tekstur velvet kelam dengan kerangka struktur emas yang tersembunyi.
                </p>
                
                <div style="display: flex; gap: 40px; margin-bottom: 32px;">
                    <div>
                        <span style="font-size: 9px; color: var(--text-secondary); letter-spacing: 1px;">HARGA SEWA</span>
                        <div style="font-size: 20px; font-weight: 600; color: var(--accent-gold); margin-top: 4px;"><span id="qvPrice">Rp 2,5 Jt</span> <span style="font-size: 11px; color: var(--text-secondary); font-weight: normal;">/ hari</span></div>
                    </div>

                    <div>
                        <span style="font-size: 9px; color: var(--text-secondary); letter-spacing: 1px;">KETERSEDIAAN</span>
                        <div style="font-size: 20px; font-weight: 600; color: #fff; margin-top: 4px;"><span id="qvStockAvail">1</span> <span style="font-size: 11px; color: var(--text-secondary); font-weight: normal;">/ <span id="qvStockTotal">5</span></span></div>
                    </div>
                </div>
                
                <div style="margin-top: auto; display: flex; gap: 16px;">
                    <button class="ds-btn-outline" style="flex: 1;" onclick="closeQuickView()">TUTUP</button>
                    <button id="qvActionBtn" class="ds-btn-primary-large" style="flex: 2; padding: 12px; width: auto;" onclick="window.location.href='index.php?page=tambah-sewa'"><i class="ph ph-shopping-bag"></i> LANJUTKAN KE SEWA</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterCat(elem, cat) {
    document.querySelectorAll('.ds-tab').forEach(t => t.classList.remove('active'));
    elem.classList.add('active');
    
    document.querySelectorAll('.ds-catalog-card').forEach(card => {
        if(cat === 'all' || card.getAttribute('data-cat') === cat) {
            card.classList.remove('filter-hide');
        } else {
            card.classList.add('filter-hide');
        }
    });
}

function openQuickView(imgPath, title, cat, price, status, statusColor, desc, fine, stockAvail, stockTotal) {
    document.getElementById('qvImage').src = imgPath;
    document.getElementById('qvTitle').innerText = title;
    document.getElementById('qvCat').innerText = cat;
    document.getElementById('qvPrice').innerText = price;
    document.getElementById('qvDesc').innerText = desc;
    document.getElementById('qvStockAvail').innerText = stockAvail;
    document.getElementById('qvStockTotal').innerText = stockTotal;
    
    // Generate random code for mockup
    document.getElementById('qvCodeVal').innerText = Math.floor(1000 + Math.random() * 9000);
    
    const badge = document.getElementById('qvBadge');
    badge.innerText = status;
    badge.className = 'ds-avail-badge ds-avail-' + statusColor;
    
    const actionBtn = document.getElementById('qvActionBtn');
    if(status === 'RENTED') {
        actionBtn.style.background = '#555';
        actionBtn.style.color = '#fff';
        actionBtn.style.pointerEvents = 'none';
        actionBtn.innerHTML = '<i class="ph ph-lock"></i> ITEM UNAVAILABLE';
    } else {
        actionBtn.style.background = 'var(--accent-gold)';
        actionBtn.style.color = '#000';
        actionBtn.style.pointerEvents = 'auto';
        actionBtn.innerHTML = '<i class="ph ph-shopping-bag"></i> LANJUTKAN KE SEWA';
    }

    const modal = document.getElementById('quickViewModal');
    modal.style.display = 'flex';
    // tiny delay for transition
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

// Close when clicking outside content
window.onclick = function(event) {
    const modal = document.getElementById('quickViewModal');
    if (event.target == modal) {
        closeQuickView();
    }
}
</script>
