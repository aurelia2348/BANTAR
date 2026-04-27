<?php
// Fetch all garments from database
require_once __DIR__ . '/../koneksi.php';
$result = mysqli_query($koneksi, "SELECT * FROM stok_kostum ORDER BY id DESC");
?>

<div class="ds-content">
    <div class="ds-top-bar" style="margin-bottom: 24px;">
        <div class="ds-title">
            <p style="font-size: 10px; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 8px;">CURATED COLLECTION</p>
            <h1 style="font-size: 48px; margin-bottom: 16px;">Archive Catalog</h1>
            <p style="max-width: 600px; color: var(--text-secondary); font-size: 13px; line-height: 1.6; letter-spacing: normal; text-transform: none;">
                Exploring the boundaries of theatrical elegance. Our current inventory features bespoke pieces from the Victorian era through modern avant-garde.
            </p>
        </div>
        <div class="ds-actions" style="display: flex; gap: 16px; align-self: center; align-items: center;">
            <div style="position: relative;">
                <i class="ph ph-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"></i>
                <input type="text" id="searchInput" placeholder="Cari nama busana..." onkeyup="searchCatalog()" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; padding: 10px 12px 10px 36px; color: #fff; font-family: inherit; font-size: 13px; outline: none; width: 220px; transition: all 0.3s ease;">
            </div>
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

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($item = mysqli_fetch_assoc($result)): 
            // Determine category slug for filter
            $kategori_raw = strtolower($item['kategori'] ?? '');
            if (strpos($kategori_raw, 'desainer') !== false || strpos($kategori_raw, 'designer') !== false) {
                $cat_slug = 'designer';
                $cat_label = 'BUSANA DESAINER';
                $cat_color = '#8CA3C5';
                $designer_color = 'var(--accent-gold)';
            } else {
                $cat_slug = 'carnival';
                $cat_label = 'KOSTUM KARNAVAL';
                $cat_color = '#C5A39B';
                $designer_color = '#C5A39B';
            }

            // Determine availability
            $jumlah = (int)($item['jumlah'] ?? 0);
            $is_available = $jumlah > 0;
            $badge_class = $is_available ? 'ds-avail-green' : 'ds-avail-red';
            $badge_text  = $is_available ? 'AVAILABLE' : 'RENTED';
            $status_color = $is_available ? 'green' : 'red';

            // Image path
            $gambar = !empty($item['gambar']) ? htmlspecialchars($item['gambar']) : 'assets/catalog_1.png';

            // Prices
            $rental_price = (float)($item['rental_price'] ?? 0);
            $rental_model_price = (float)($item['rental_model_price'] ?? 0);
            $price_fmt = 'Rp ' . number_format($rental_price, 0, ',', '.');
            $fine_fmt  = number_format($rental_model_price, 0, ',', '.');

            // Safe JS strings (escape quotes and newlines for inline JS)
            $js_img   = htmlspecialchars(addslashes($gambar), ENT_QUOTES);
            $js_nama  = htmlspecialchars(addslashes($item['nama_kostum']), ENT_QUOTES);
            $js_cat   = htmlspecialchars(addslashes($cat_label), ENT_QUOTES);
            $js_price = htmlspecialchars(addslashes($price_fmt), ENT_QUOTES);
            $js_status = htmlspecialchars(addslashes($badge_text), ENT_QUOTES);
            $js_color  = htmlspecialchars(addslashes($status_color), ENT_QUOTES);
            $js_desc   = htmlspecialchars(addslashes(str_replace(["\r", "\n"], ["", "\\n"], $item['deskripsi'] ?? '')), ENT_QUOTES);
            $js_fine   = htmlspecialchars(addslashes($fine_fmt), ENT_QUOTES);

            // Format nama kostum for display (split on space for line break effect)
            $nama_parts = explode(' ', $item['nama_kostum'], 2);
            $nama_line1 = htmlspecialchars($nama_parts[0]);
            $nama_line2 = isset($nama_parts[1]) ? htmlspecialchars($nama_parts[1]) : '';

            $id = (int)$item['id'];
        ?>
        <div class="ds-catalog-card" data-cat="<?= $cat_slug ?>" data-id="<?= $id ?>" data-name="<?= htmlspecialchars(strtolower($item['nama_kostum'])) ?>">
            <img src="<?= $gambar ?>" alt="<?= htmlspecialchars($item['nama_kostum']) ?>">
            <div class="ds-avail-badge <?= $badge_class ?>"><?= $badge_text ?></div>
            <div class="ds-catalog-overlay">
                <div class="ds-catalog-top">
                    <span class="ds-cat-label" style="color: <?= $cat_color ?>;"><?= $cat_label ?></span>
                </div>
                <div class="ds-cat-hover-actions">
                    <button class="ds-btn-cat-action" onclick="openQuickView('<?= $js_img ?>', '<?= $js_nama ?>', '<?= $js_cat ?>', '<?= $js_price ?>', '<?= $js_status ?>', '<?= $js_color ?>', '<?= $js_desc ?>', '<?= $js_fine ?>', <?= $jumlah ?>, <?= $jumlah ?>, <?= $id ?>)"><i class="ph ph-eye"></i> QUICK VIEW</button>
                    <?php if ($is_available): ?>
                    <button class="ds-btn-cat-action primary" onclick="window.location.href='index.php?page=tambah-sewa'"><i class="ph ph-shopping-bag"></i> RENT</button>
                    <?php else: ?>
                    <button class="ds-btn-cat-action primary" style="background:#555; pointer-events:none;"><i class="ph ph-lock"></i> UNAVAILABLE</button>
                    <?php endif; ?>
                </div>
                <div style="width: 100%;">
                    <div class="ds-catalog-bottom" style="margin-bottom: 12px;">
                        <div>
                            <div style="font-size: 10px; color: <?= $designer_color ?>; letter-spacing: 1px; margin-bottom: 4px; text-transform: uppercase;">By <?= htmlspecialchars($item['nama_designer']) ?></div>
                            <h3 class="ds-cat-title"><?= $nama_line1 ?><?= $nama_line2 ? '<br>' . $nama_line2 : '' ?></h3>
                        </div>
                        <div class="ds-cat-price">
                            <strong><?= $price_fmt ?></strong><span>/hari</span>
                        </div>
                    </div>
                    <div style="font-size: 11px; color: var(--text-secondary); padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between;">
                        <span>Stok Tersedia:</span>
                        <span><strong style="color: <?= $is_available ? '#fff' : '#F44336' ?>;"><?= $jumlah ?></strong> / <?= $jumlah ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>

        <!-- Item Placeholder / Add -->
        <div class="ds-catalog-placeholder ds-card" onclick="window.location.href='index.php?page=tambah-busana'">
            <div class="ds-placeholder-icon">
                <i class="ph ph-plus"></i>
            </div>
            <h3>Expanding the<br>Bantar</h3>
            <p>NEW ACQUISITIONS<br>ARRIVING WEEKLY</p>
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
                    <p id="qvCode" style="font-size: 11px; color: var(--text-secondary); letter-spacing: 1px;">CODE: CTLG-<span id="qvCodeVal">–</span></p>
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
                
                <div style="margin-top: auto; display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; gap: 12px;">
                        <button class="ds-btn-outline" style="flex: 1; border-color: rgba(255,255,255,0.2);" id="qvEditBtn" onclick="window.location.href='index.php?page=edit-busana'"><i class="ph ph-pencil-simple"></i> EDIT ITEM</button>
                        <button class="ds-btn-outline" style="flex: 1; border-color: #F44336; color: #F44336;" onclick="deleteAdminItem()"><i class="ph ph-trash"></i> DELETE</button>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <button class="ds-btn-outline" style="flex: 1; opacity: 0.6; border: none; background: rgba(255,255,255,0.05);" onclick="closeQuickView()">TUTUP</button>
                        <button id="qvActionBtn" class="ds-btn-primary-large" style="flex: 2; padding: 12px; width: auto;" onclick="window.location.href='index.php?page=tambah-sewa'"><i class="ph ph-shopping-bag"></i> LANJUTKAN KE SEWA</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#searchInput:focus {
    border-color: var(--accent-gold) !important;
    background: rgba(255,255,255,0.1) !important;
}
</style>

<script>
function applyFilters() {
    const cat = window.currentCat || 'all';
    const query = (document.getElementById('searchInput').value || '').toLowerCase();
    
    document.querySelectorAll('.ds-catalog-card').forEach(card => {
        const itemCat = card.getAttribute('data-cat');
        const itemName = card.getAttribute('data-name') || '';
        
        const matchCat = (cat === 'all' || itemCat === cat);
        const matchSearch = itemName.includes(query);
        
        if (matchCat && matchSearch) {
            card.classList.remove('filter-hide');
        } else {
            card.classList.add('filter-hide');
        }
    });
}

function filterCat(elem, cat) {
    document.querySelectorAll('.ds-tab').forEach(t => t.classList.remove('active'));
    elem.classList.add('active');
    
    window.currentCat = cat;
    applyFilters();
}

function searchCatalog() {
    applyFilters();
}

function openQuickView(imgPath, title, cat, price, status, statusColor, desc, fine, stockAvail, stockTotal, itemId) {
    // Capture the event to get the card reference for deletion
    window.currentQuickViewCard = event ? event.currentTarget.closest('.ds-catalog-card') : null;
    window.currentQuickViewId   = itemId || null;
    
    document.getElementById('qvImage').src = imgPath;
    document.getElementById('qvTitle').innerText = title;
    document.getElementById('qvCat').innerText = cat;
    document.getElementById('qvPrice').innerText = price;
    document.getElementById('qvDesc').innerText = desc;
    document.getElementById('qvStockAvail').innerText = stockAvail;
    document.getElementById('qvStockTotal').innerText = stockTotal;
    
    // Code from item id
    document.getElementById('qvCodeVal').innerText = itemId ? String(itemId).padStart(4, '0') : '–';
    
    // Update edit button to carry item id
    if (itemId) {
        document.getElementById('qvEditBtn').setAttribute('onclick', "window.location.href='index.php?page=edit-busana&id=" + itemId + "'");
    }

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
        window.currentQuickViewCard = null;
        window.currentQuickViewId   = null;
    }, 300);
}

function deleteAdminItem() {
    if(confirm("Apakah Anda yakin ingin menghapus item ini dari arsip katalog? Tindakan ini tidak dapat dibatalkan.")) {
        const itemId = window.currentQuickViewId;
        const card   = window.currentQuickViewCard;
        closeQuickView();

        if (itemId) {
            // Send delete request to server
            fetch('script/delete_kostum.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id=' + encodeURIComponent(itemId)
            }).then(res => res.json()).then(data => {
                if (data.success && card) {
                    card.style.transition = 'all 0.4s ease';
                    card.style.transform  = 'scale(0.9)';
                    card.style.opacity    = '0';
                    setTimeout(() => card.remove(), 400);
                } else {
                    alert('Gagal menghapus item: ' + (data.message || 'Unknown error'));
                }
            }).catch(() => {
                // Fallback: remove visually if fetch fails
                if(card) {
                    card.style.transition = 'all 0.4s ease';
                    card.style.transform  = 'scale(0.9)';
                    card.style.opacity    = '0';
                    setTimeout(() => card.remove(), 400);
                }
            });
        } else if(card) {
            card.style.transition = 'all 0.4s ease';
            card.style.transform  = 'scale(0.9)';
            card.style.opacity    = '0';
            setTimeout(() => card.remove(), 400);
        }
    }
}

// Close when clicking outside content
window.onclick = function(event) {
    const modal = document.getElementById('quickViewModal');
    if (event.target == modal) {
        closeQuickView();
    }
}
</script>
