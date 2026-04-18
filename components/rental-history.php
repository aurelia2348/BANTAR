<?php
require_once __DIR__ . '/../koneksi.php';

// ── Pagination ──────────────────────────────────────────────────────────────
$per_page  = 10;
$page_num  = max(1, (int)($_GET['rh_page'] ?? 1));
$offset    = ($page_num - 1) * $per_page;

$total_count = (int)mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS c FROM sewa")
)['c'];
$total_pages = max(1, ceil($total_count / $per_page));

// ── Main list: sewa + first costume ─────────────────────────────────────────
$sewa_result = mysqli_query($koneksi, "
    SELECT s.*,
           sk.nama_kostum AS first_kostum,
           sk.gambar      AS first_gambar
    FROM sewa s
    LEFT JOIN detail_sewa ds ON ds.id = (
        SELECT MIN(d2.id) FROM detail_sewa d2 WHERE d2.sewa_id = s.id
    )
    LEFT JOIN stok_kostum sk ON sk.id = ds.kostum_id
    ORDER BY s.created_at DESC
    LIMIT $per_page OFFSET $offset
");

$sewa_rows = [];
while ($r = mysqli_fetch_assoc($sewa_result)) {
    $sewa_rows[] = $r;
}

// ── Detail per sewa (for receipt modal) ─────────────────────────────────────
$details_map = [];
if (!empty($sewa_rows)) {
    $ids = implode(',', array_map(fn($r) => (int)$r['id'], $sewa_rows));
    $det_result = mysqli_query($koneksi, "
        SELECT ds.*, sk.nama_kostum, sk.gambar,
               sk.rental_model_price AS harga_model_db
        FROM detail_sewa ds
        JOIN stok_kostum sk ON sk.id = ds.kostum_id
        WHERE ds.sewa_id IN ($ids)
        ORDER BY ds.sewa_id, ds.id
    ");
    while ($d = mysqli_fetch_assoc($det_result)) {
        $details_map[$d['sewa_id']][] = $d;
    }
}

// ── Build JS data map (safe JSON) ────────────────────────────────────────────
$js_data = [];
foreach ($sewa_rows as $s) {
    $sid   = (int)$s['id'];
    $items = [];
    foreach (($details_map[$sid] ?? []) as $d) {
        $items[] = [
            'nama_kostum'   => $d['nama_kostum'],
            'qty'           => (int)$d['qty'],
            'harga'         => (float)$d['harga'],
            'include_model' => (bool)$d['include_model'],
            'jumlah_model'  => (int)$d['jumlah_model'],
            'hari_model'    => (int)$d['hari_model'],
            'harga_model'   => (float)$d['harga_model_db'],
        ];
    }
    $js_data[$sid] = [
        'id'              => $sid,
        'nama_penyewa'    => $s['nama_penyewa'],
        'no_telp'         => $s['no_telp'],
        'alamat'          => $s['alamat'],
        'tanggal_sewa'    => $s['tanggal_sewa'],
        'tanggal_kembali' => $s['tanggal_kembali'],
        'total_harga'     => (float)$s['total_harga'],
        'status'          => $s['status'],
        'items'           => $items,
    ];
}
?>

<div class="ds-content">
    
    <!-- Top Header & Search -->
    <div class="rh-top-section">
        <div>
            <div class="rh-pre-title">HISTORICAL ARCHIVE</div>
            <h1 class="rh-title">Rental History Ledger</h1>
        </div>
        <div class="rh-search-container">
            <i class="ph ph-magnifying-glass rh-search-icon"></i>
            <input type="text" class="rh-search-input" placeholder="Search tenant or costume..." oninput="filterTable(this.value)">
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="rh-filters-bar">
        <div class="rh-pills-group">
            <div class="rh-pill active">ALL</div>
            <div class="rh-pill outline">BELUM SELESAI</div>
            <div class="rh-pill outline">SELESAI</div>
        </div>
        <div class="rh-adv-filters">
            <i class="ph ph-funnel-simple"></i> ADVANCED FILTERS
        </div>
    </div>

    <!-- Table Section -->
    <div class="rh-table-container">
        <table class="rh-table" id="rhTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TENANT</th>
                    <th>COSTUME ENTITY</th>
                    <th>RENTAL DATE</th>
                    <th>RETURN DATE</th>
                    <th>STATUS</th>
                    <th style="text-align: right;">AMOUNT</th>
                    <th style="text-align: right; padding-right: 24px;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sewa_rows)): ?>
                <tr>
                    <td colspan="8" style="text-align:center; padding: 48px; color: var(--text-secondary); font-size: 13px;">
                        Belum ada data penyewaan.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($sewa_rows as $s):
                    $sid        = (int)$s['id'];
                    $is_active  = ($s['status'] === 'dipinjam');
                    $status_cls = $is_active ? 'rh-status-active' : 'rh-status-completed';
                    $status_txt = $is_active ? 'BELUM SELESAI' : 'SELESAI';
                    $tgl_sewa   = $s['tanggal_sewa']    ? date('M d,<br>Y', strtotime($s['tanggal_sewa']))    : '-';
                    $tgl_balik  = $s['tanggal_kembali'] ? date('M d,<br>Y', strtotime($s['tanggal_kembali'])) : '-';
                    $gambar     = !empty($s['first_gambar']) ? $s['first_gambar'] : 'assets/catalog_1.png';
                    $kostum     = !empty($s['first_kostum']) ? $s['first_kostum'] : '–';
                    $total_fmt  = 'Rp ' . number_format($s['total_harga'], 0, ',', '.');
                ?>
                <tr class="rh-row-clickable" data-sewa-id="<?= $sid ?>" onclick="openReceiptModal(<?= $sid ?>)">
                    <td>
                        <div class="rh-col-id">#<?= $sid ?></div>
                    </td>
                    <td>
                        <div class="rh-col-tenant-name"><?= htmlspecialchars($s['nama_penyewa']) ?></div>
                        <div class="rh-col-tenant-org"><?= htmlspecialchars($s['no_telp']) ?></div>
                    </td>
                    <td>
                        <div class="rh-col-costume">
                            <img src="<?= htmlspecialchars($gambar) ?>" alt="Costume" class="rh-col-costume-img">
                            <span class="rh-col-costume-name"><?= htmlspecialchars($kostum) ?></span>
                        </div>
                    </td>
                    <td><div class="rh-col-date"><?= $tgl_sewa ?></div></td>
                    <td><div class="rh-col-date"><?= $tgl_balik ?></div></td>
                    <td>
                        <div class="rh-status-pill <?= $status_cls ?>">
                            <span class="rh-status-dot"></span> <?= $status_txt ?>
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount"><?= $total_fmt ?></span>
                    </td>
                    <td style="text-align: right; white-space: nowrap; padding-right: 24px;">
                        <?php if ($is_active): ?>
                        <button class="rh-btn-action rh-btn-mark"
                                onclick="event.stopPropagation(); openReturnModal(<?= $sid ?>)">
                            <i class="ph ph-check-circle"></i> TANDAI SELESAI
                        </button>
                        <?php else: ?>
                        <button class="rh-btn-action rh-btn-disabled" disabled onclick="event.stopPropagation();">
                            <i class="ph ph-lock-key"></i> SELESAI
                        </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="rh-pagination-bar">
        <div class="rh-pag-info">
            SHOWING <?= min($offset + 1, $total_count) ?>–<?= min($offset + $per_page, $total_count) ?> OF <?= $total_count ?> RECORDED TRANSACTIONS
        </div>
        <div class="rh-pag-controls">
            <?php if ($page_num > 1): ?>
            <a href="?page=rental-history&rh_page=<?= $page_num - 1 ?>" class="rh-pag-btn">&lt; Previous</a>
            <?php else: ?>
            <span class="rh-pag-btn" style="opacity:0.3;">&#60; Previous</span>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                <?php if ($p === $page_num): ?>
                <span class="rh-pag-num active"><?= str_pad($p, 2, '0', STR_PAD_LEFT) ?></span>
                <?php elseif ($p <= 3 || $p >= $total_pages - 1 || abs($p - $page_num) <= 1): ?>
                <a href="?page=rental-history&rh_page=<?= $p ?>" class="rh-pag-num"><?= str_pad($p, 2, '0', STR_PAD_LEFT) ?></a>
                <?php elseif ($p === 4 && $page_num > 4): ?>
                <span>...</span>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page_num < $total_pages): ?>
            <a href="?page=rental-history&rh_page=<?= $page_num + 1 ?>" class="rh-pag-btn">Next &gt;</a>
            <?php else: ?>
            <span class="rh-pag-btn" style="opacity:0.3;">Next &#62;</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── Kelola Transaksi Modal ─────────────────────────────────────────────── -->
    <div class="rh-modal-overlay" id="returnFormModal">
        <div class="rh-modal-content" style="max-width: 500px; padding: 32px;">
            <i class="ph ph-x rh-modal-close" onclick="closeReturnModal()"></i>

            <h2 class="rh-modal-title" style="margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 16px;">Kelola Transaksi</h2>

            <input type="hidden" id="rf-sewa-id" value="">

            <div style="margin-bottom: 16px;">
                <label style="display:block; font-size:11px; color:var(--text-secondary); margin-bottom:8px; letter-spacing:1px;">NAMA PENYEWA</label>
                <input type="text" id="rf-tenant" readonly style="width:100%; padding:12px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1); border-radius:4px; color:var(--text-secondary); outline:none;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display:block; font-size:11px; color:var(--text-secondary); margin-bottom:8px; letter-spacing:1px;">NAMA BARANG &amp; JUMLAH</label>
                <input type="text" id="rf-item" readonly style="width:100%; padding:12px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1); border-radius:4px; color:var(--text-secondary); outline:none;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display:block; font-size:11px; color:var(--text-secondary); margin-bottom:8px; letter-spacing:1px;">TANGGAL KEMBALI</label>
                <input type="text" id="rf-return-date" readonly style="width:100%; padding:12px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1); border-radius:4px; color:var(--text-secondary); outline:none;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display:block; font-size:11px; color:var(--text-secondary); margin-bottom:8px; letter-spacing:1px;">TANGGAL KEMBALI SEBENARNYA</label>
                <input type="date" id="rf-actual-date" style="width:100%; padding:12px; background:transparent; border:1px solid rgba(255,255,255,0.2); border-radius:4px; color:#fff; outline:none;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display:block; font-size:11px; color:var(--text-secondary); margin-bottom:8px; letter-spacing:1px;">DENDA KETERLAMBATAN (RP)</label>
                <input type="number" id="rf-late-fee" value="0" readonly style="width:100%; padding:12px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1); border-radius:4px; color:var(--text-secondary); outline:none;">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display:block; font-size:11px; color:var(--text-secondary); margin-bottom:8px; letter-spacing:1px;">DENDA LAIN-LAIN (RP)</label>
                <input type="number" id="rf-other-fee" value="0" style="width:100%; padding:12px; background:transparent; border:1px solid rgba(255,255,255,0.2); border-radius:4px; color:#fff; outline:none;">
            </div>

            <div style="display:flex; gap:16px;">
                <button class="rh-btn-action" style="flex:1; justify-content:center; background:var(--accent-gold); color:#000; border:none; padding:12px;" onclick="confirmReturn()">SIMPAN</button>
                <button class="rh-btn-action" style="flex:1; justify-content:center; background:transparent; border:1px solid rgba(255,255,255,0.2); padding:12px;" onclick="closeReturnModal()">TUTUP</button>
            </div>
        </div>
    </div>

    <!-- ── Receipt Modal ──────────────────────────────────────────────────────── -->
    <div class="rh-modal-overlay" id="receiptModal">
        <div class="rh-modal-content">
            <i class="ph ph-x rh-modal-close" onclick="closeReceiptModal()"></i>

            <div class="rh-modal-header">
                <div>
                    <h2 class="rh-modal-title">Atelier Receipt</h2>
                    <div class="rh-modal-subtitle">DIGITAL ARCHIVE RECORD</div>
                </div>
                <div class="rh-receipt-meta">
                    <div class="rh-receipt-meta-id" id="rm-id">TX-0000</div>
                    <div class="rh-receipt-meta-date" id="rm-date">–</div>
                </div>
            </div>

            <div class="rh-payment-status">
                <div class="rh-payment-label">STATUS PENYEWAAN</div>
                <div class="rh-payment-val" id="rm-status">–</div>
            </div>

            <div class="rh-modal-columns">
                <!-- BILLED TO -->
                <div class="rh-modal-col">
                    <div class="rh-modal-col-title">BILLED TO</div>
                    <div class="rh-modal-col-val" id="rm-nama">–</div>
                    <div class="rh-modal-col-desc" id="rm-contact">–</div>
                </div>
                <!-- BOOKING PERIOD -->
                <div class="rh-modal-col">
                    <div class="rh-modal-col-title">BOOKING PERIOD</div>
                    <div class="rh-modal-col-val" id="rm-period-days">–</div>
                    <div class="rh-modal-col-desc" id="rm-period-dates">–</div>
                </div>
            </div>

            <!-- ITEMS -->
            <div class="rh-modal-items">
                <div class="rh-modal-item-ref">ITEMS</div>
                <div id="rm-items-body">
                    <!-- Populated by JS -->
                </div>

                <!-- SERVICES / MODEL -->
                <div id="rm-services-wrap" style="display:none;">
                    <div class="rh-modal-item-ref" style="margin-top:24px; color:var(--text-secondary);">SERVICE · MODEL</div>
                    <div id="rm-services-body"></div>
                </div>
            </div>

            <div class="rh-modal-total-row">
                <div class="rh-modal-total-label">Total Amount</div>
                <div class="rh-modal-total-val" id="rm-total">Rp 0</div>
            </div>

            <div class="rh-modal-actions">
                <div class="rh-mbtn rh-mbtn-outline" onclick="window.print()">DOWNLOAD PDF</div>
                <div class="rh-mbtn rh-mbtn-solid" onclick="closeReceiptModal()">TUTUP</div>
            </div>
        </div>
    </div>

</div>

<!-- JS Data Map from PHP -->
<script>
const SEWA_DATA = <?= json_encode($js_data, JSON_UNESCAPED_UNICODE) ?>;

// ── Helpers ──────────────────────────────────────────────────────────────────
function fmtRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}
function fmtDate(str) {
    if (!str) return '–';
    const d = new Date(str + 'T00:00:00');
    return d.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
}
function daysBetween(a, b) {
    if (!a || !b) return 0;
    return Math.max(0, Math.ceil((new Date(b) - new Date(a)) / 86400000));
}

// ── Receipt Modal ─────────────────────────────────────────────────────────────
function openReceiptModal(sewaId) {
    const d = SEWA_DATA[sewaId];
    if (!d) return;

    // Header
    document.getElementById('rm-id').innerText   = '#' + d.id;
    document.getElementById('rm-date').innerText = fmtDate(d.tanggal_sewa).toUpperCase();

    // Status
    const statusEl = document.getElementById('rm-status');
    statusEl.innerText = d.status === 'dipinjam' ? 'SEDANG DIPINJAM' : 'SELESAI / DIKEMBALIKAN';
    statusEl.style.color = d.status === 'dipinjam' ? 'var(--accent-gold)' : '#4CAF50';

    // Billed To
    document.getElementById('rm-nama').innerText = d.nama_penyewa;
    document.getElementById('rm-contact').innerHTML =
        (d.no_telp  ? d.no_telp  + '<br>' : '') +
        (d.alamat   ? d.alamat             : '–');

    // Booking Period
    const days = daysBetween(d.tanggal_sewa, d.tanggal_kembali);
    document.getElementById('rm-period-days').innerText  = days + ' Hari';
    document.getElementById('rm-period-dates').innerHTML =
        fmtDate(d.tanggal_sewa) + ' – ' + fmtDate(d.tanggal_kembali);

    // Items
    const itemsBody = document.getElementById('rm-items-body');
    itemsBody.innerHTML = '';
    d.items.forEach(item => {
        itemsBody.insertAdjacentHTML('beforeend', `
            <div class="rh-modal-row">
                <div>
                    <div class="rh-modal-row-name">${item.nama_kostum}</div>
                    <div style="font-size:10px; color:var(--text-secondary); margin-top:2px;">
                        Jumlah: ${item.qty} × ${fmtRp(item.harga)}/hari
                    </div>
                </div>
                <div class="rh-modal-row-price">${fmtRp(item.harga * item.qty * days)}</div>
            </div>
        `);
    });

    // Services – model
    const svcWrap = document.getElementById('rm-services-wrap');
    const svcBody = document.getElementById('rm-services-body');
    svcBody.innerHTML = '';
    let hasModel = false;

    d.items.forEach(item => {
        const inclTxt = item.include_model ? 'Ya' : 'Tidak';
        const modelFee = item.include_model
            ? item.harga_model * item.jumlah_model * item.hari_model
            : 0;

        svcBody.insertAdjacentHTML('beforeend', `
            <div class="rh-modal-row" style="margin-bottom:6px;">
                <div>
                    <div class="rh-modal-row-name" style="color:var(--text-secondary);">${item.nama_kostum}</div>
                    <div style="font-size:10px; color:var(--text-secondary); margin-top:2px;">
                        Include Model: <strong style="color:#C5A39B;">${inclTxt}</strong>
                        ${item.include_model ? `&nbsp;·&nbsp; ${item.jumlah_model} model × ${item.hari_model} hari × ${fmtRp(item.harga_model)}` : ''}
                    </div>
                </div>
                <div class="rh-modal-row-price" style="color:#C5A39B;">
                    ${item.include_model ? fmtRp(modelFee) : '–'}
                </div>
            </div>
        `);
        if (item.include_model) hasModel = true;
    });

    svcWrap.style.display = hasModel ? 'block' : 'none';

    // Total
    document.getElementById('rm-total').innerText = fmtRp(d.total_harga);

    document.getElementById('receiptModal').style.display = 'flex';
}

function closeReceiptModal() {
    document.getElementById('receiptModal').style.display = 'none';
}

// ── Return / Kelola Transaksi Modal ───────────────────────────────────────────
function openReturnModal(sewaId) {
    const d = SEWA_DATA[sewaId];
    if (!d) return;

    document.getElementById('rf-sewa-id').value     = sewaId;
    document.getElementById('rf-tenant').value       = d.nama_penyewa;

    // Show all items summary
    const itemsSummary = d.items.map(i => i.nama_kostum + ' x' + i.qty).join(', ');
    document.getElementById('rf-item').value         = itemsSummary;
    document.getElementById('rf-return-date').value  = fmtDate(d.tanggal_kembali);

    // Auto-set today as actual return date
    const today = new Date().toISOString().split('T')[0];
    const actualInput = document.getElementById('rf-actual-date');
    actualInput.value = today;

    document.getElementById('rf-late-fee').value  = 0;
    document.getElementById('rf-other-fee').value = 0;

    window.currentReturnSewaId = sewaId;
    document.getElementById('returnFormModal').style.display = 'flex';

    // Trigger late fee calc
    actualInput.dispatchEvent(new Event('change'));
}

function closeReturnModal() {
    document.getElementById('returnFormModal').style.display = 'none';
    window.currentReturnSewaId = null;
    window.currentReturnBtn    = null;
}

function confirmReturn() {
    const sewaId   = window.currentReturnSewaId;
    const lateFee  = parseInt(document.getElementById('rf-late-fee').value)  || 0;
    const otherFee = parseInt(document.getElementById('rf-other-fee').value) || 0;
    const actual   = document.getElementById('rf-actual-date').value;

    closeReturnModal();

    // Update DB via AJAX
    fetch('script/tandai_selesai.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `sewa_id=${sewaId}&actual_date=${actual}&late_fee=${lateFee}&other_fee=${otherFee}`
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            // Update row UI
            const row = document.querySelector(`tr[data-sewa-id="${sewaId}"]`);
            if (row) {
                const pill = row.querySelector('.rh-status-pill');
                pill.classList.remove('rh-status-active', 'rh-status-overdue');
                pill.classList.add('rh-status-completed');
                pill.innerHTML = '<span class="rh-status-dot"></span> SELESAI';

                const tdAction = row.querySelector('td:last-child');
                tdAction.innerHTML = '<button class="rh-btn-action rh-btn-disabled" disabled onclick="event.stopPropagation();"><i class="ph ph-lock-key"></i> SELESAI</button>';

                // Update local SEWA_DATA so receipt modal reflects new status
                if (SEWA_DATA[sewaId]) SEWA_DATA[sewaId].status = 'selesai';
            }
        } else {
            alert('Gagal memperbarui: ' + (res.message || 'Unknown error'));
        }
    })
    .catch(() => {
        // Graceful fallback: update UI anyway
        const row = document.querySelector(`tr[data-sewa-id="${sewaId}"]`);
        if (row) {
            const pill = row.querySelector('.rh-status-pill');
            if (pill) {
                pill.classList.remove('rh-status-active');
                pill.classList.add('rh-status-completed');
                pill.innerHTML = '<span class="rh-status-dot"></span> SELESAI';
            }
            const tdAction = row.querySelector('td:last-child');
            if (tdAction) tdAction.innerHTML = '<button class="rh-btn-action rh-btn-disabled" disabled><i class="ph ph-lock-key"></i> SELESAI</button>';
        }
    });
}

// ── Late fee auto-calc ────────────────────────────────────────────────────────
document.getElementById('rf-actual-date').addEventListener('change', function() {
    const expectedStr = document.getElementById('rf-return-date').value;
    const expectedDate = new Date(expectedStr);
    const actualDate   = new Date(this.value);
    const lateFeeInput = document.getElementById('rf-late-fee');

    if (!isNaN(expectedDate) && !isNaN(actualDate)) {
        expectedDate.setHours(0,0,0,0);
        actualDate.setHours(0,0,0,0);
        if (actualDate > expectedDate) {
            const diffDays = Math.ceil((actualDate - expectedDate) / 86400000);
            lateFeeInput.value = diffDays * 25000;
        } else {
            lateFeeInput.value = 0;
        }
    } else {
        lateFeeInput.value = 0;
    }
});

// ── Table search filter ───────────────────────────────────────────────────────
function filterTable(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#rhTable tbody tr').forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = (!q || text.includes(q)) ? '' : 'none';
    });
}

// ── Close on outside click ────────────────────────────────────────────────────
window.onclick = function(e) {
    if (e.target === document.getElementById('receiptModal'))   closeReceiptModal();
    if (e.target === document.getElementById('returnFormModal')) closeReturnModal();
};
</script>
