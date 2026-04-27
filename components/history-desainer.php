<?php
require_once __DIR__ . '/../koneksi.php';

$designer_id = $_SESSION['user_id'] ?? ($_GET['designer_id'] ?? 3);

// Ambil nama desainer
$designer_name = "DESIGNER STUDIO";
$query_designer = mysqli_query($koneksi, "SELECT username FROM users WHERE id = $designer_id");
if ($query_designer && mysqli_num_rows($query_designer) > 0) {
    $designer_name = strtoupper(mysqli_fetch_assoc($query_designer)['username']) . " STUDIO";
}

// ── Filter Logic ────────────────────────────────────────────────────────────
if (!function_exists('buildUrl')) {
    function buildUrl($updates) {
        $params = $_GET;
        $params['page'] = 'history-desainer';
        foreach ($updates as $k => $v) {
            if ($v === null || $v === '') {
                unset($params[$k]);
            } else {
                $params[$k] = $v;
            }
        }
        return 'index.php?' . http_build_query($params);
    }
}

$where_clauses = ["sk.id_designer = $designer_id"];

if (!empty($_GET['rh_status']) && $_GET['rh_status'] !== 'all') {
    $st = mysqli_real_escape_string($koneksi, $_GET['rh_status']);
    $where_clauses[] = "s.status = '$st'";
}
if (!empty($_GET['rh_id'])) {
    $id = (int)$_GET['rh_id'];
    $where_clauses[] = "s.id = $id";
}
if (!empty($_GET['rh_month'])) {
    $m = mysqli_real_escape_string($koneksi, $_GET['rh_month']);
    $where_clauses[] = "MONTH(s.tanggal_sewa) = '$m'";
}
if (!empty($_GET['rh_year'])) {
    $y = mysqli_real_escape_string($koneksi, $_GET['rh_year']);
    $where_clauses[] = "YEAR(s.tanggal_sewa) = '$y'";
}
if (!empty($_GET['rh_search'])) {
    $sch = mysqli_real_escape_string($koneksi, $_GET['rh_search']);
    $where_clauses[] = "(sk.nama_kostum LIKE '%$sch%' OR sk.id LIKE '%$sch%')"; 
}

$where_sql = "WHERE " . implode(" AND ", $where_clauses);

// Pagination
$per_page = 10;
$page_num = max(1, (int)($_GET['rh_page'] ?? 1));
$offset   = ($page_num - 1) * $per_page;

// Hitung total transaksi (detail sewa) untuk desainer ini
$count_query = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total
    FROM detail_sewa ds
    JOIN stok_kostum sk ON sk.id = ds.kostum_id
    JOIN sewa s ON s.id = ds.sewa_id
    $where_sql
");
$total_count = (int)mysqli_fetch_assoc($count_query)['total'];
$total_pages = max(1, ceil($total_count / $per_page));

// Ambil data transaksi list
$query_transaksi = mysqli_query($koneksi, "
    SELECT s.id AS sewa_id, s.tanggal_sewa, s.tanggal_kembali, s.status,
           ds.qty, ds.harga,
           sk.nama_kostum, sk.gambar,
           p.denda_keterlambatan, ds.denda_lain,
           (SELECT SUM(qty) FROM detail_sewa WHERE sewa_id = s.id) AS total_qty
    FROM detail_sewa ds
    JOIN stok_kostum sk ON sk.id = ds.kostum_id
    JOIN sewa s ON s.id = ds.sewa_id
    LEFT JOIN pengembalian p ON p.sewa_id = s.id
    $where_sql
    ORDER BY s.tanggal_sewa DESC, s.id DESC
    LIMIT $per_page OFFSET $offset
");

$transaksi_list = [];
if ($query_transaksi) {
    while ($row = mysqli_fetch_assoc($query_transaksi)) {
        $transaksi_list[] = $row;
    }
}

// Hitung Summary Cards (Total dari semua data yang ter-filter, bukan cuma halaman ini)
$query_summary = mysqli_query($koneksi, "
    SELECT s.tanggal_sewa, s.tanggal_kembali,
           ds.qty, ds.harga, ds.denda_lain,
           p.denda_keterlambatan,
           (SELECT SUM(qty) FROM detail_sewa WHERE sewa_id = s.id) AS total_qty
    FROM detail_sewa ds
    JOIN stok_kostum sk ON sk.id = ds.kostum_id
    JOIN sewa s ON s.id = ds.sewa_id
    LEFT JOIN pengembalian p ON p.sewa_id = s.id
    $where_sql
");

$sum_rental_revenue = 0;
$sum_fines = 0;
$sum_my_royalty = 0;

if ($query_summary) {
    while ($r = mysqli_fetch_assoc($query_summary)) {
        $d1 = new DateTime($r['tanggal_sewa']);
        $d2 = new DateTime($r['tanggal_kembali']);
        $days = max(1, (int)$d1->diff($d2)->days);
        
        $t_qty = (int)($r['total_qty'] ?? 1);
        $t_qty = $t_qty > 0 ? $t_qty : 1;
        $late_fee_per_item = ((float)($r['denda_keterlambatan'] ?? 0)) / $t_qty;
        $my_late_fee = $late_fee_per_item * (int)$r['qty'];
        $my_other_fee = (float)($r['denda_lain'] ?? 0);
        
        $total_fee = (float)$r['harga'] * (int)$r['qty'] * $days;
        $royalty = (0.90 * $total_fee) + $my_late_fee + $my_other_fee;
        
        $sum_rental_revenue += $total_fee;
        $sum_fines += ($my_late_fee + $my_other_fee);
        $sum_my_royalty += $royalty;
    }
}

if (!function_exists('rpFmt')) {
    function rpFmt($n) {
        return 'Rp ' . number_format((float)$n, 0, ',', '.');
    }
}
?>

<div class="ds-content">

    <!-- Top Header & Search -->
    <div class="rh-top-section" style="margin-bottom: 24px;">
        <div>
            <div class="rh-pre-title"><?= htmlspecialchars($designer_name) ?></div>
            <h1 class="rh-title">Royalty Ledger</h1>
        </div>
        <div class="rh-search-container">
            <i class="ph ph-magnifying-glass rh-search-icon"></i>
            <form method="GET" action="index.php" style="display:inline;" id="searchForm">
                <input type="hidden" name="page" value="history-desainer">
                <input type="hidden" name="rh_status" value="<?= htmlspecialchars($_GET['rh_status'] ?? 'all') ?>">
                <input type="hidden" name="rh_id" value="<?= htmlspecialchars($_GET['rh_id'] ?? '') ?>">
                <input type="hidden" name="rh_month" value="<?= htmlspecialchars($_GET['rh_month'] ?? '') ?>">
                <input type="hidden" name="rh_year" value="<?= htmlspecialchars($_GET['rh_year'] ?? '') ?>">
                <input type="text" name="rh_search" class="rh-search-input" placeholder="Search by costume name..." value="<?= htmlspecialchars($_GET['rh_search'] ?? '') ?>">
                <button type="submit" style="display:none;"></button>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px;">
        <!-- Card 1 -->
        <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 24px; border-radius: 8px;">
            <p style="font-size: 10px; color: var(--text-secondary); letter-spacing: 1px; margin: 0 0 16px 0; text-transform: uppercase;">
                TOTAL RENTAL REVENUE
            </p>
            <div style="font-size: 32px; font-weight: 300; font-family: var(--font-heading); color: #fff; margin-bottom: 8px;">
                <?= rpFmt($sum_rental_revenue) ?>
            </div>
            <p style="font-size: 11px; color: var(--text-secondary); margin: 0;">
                Pendapatan kotor dari biaya sewa
            </p>
        </div>

        <!-- Card 2 -->
        <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 24px; border-radius: 8px;">
            <p style="font-size: 10px; color: var(--text-secondary); letter-spacing: 1px; margin: 0 0 16px 0; text-transform: uppercase;">
                FINES & PENALTIES
            </p>
            <div style="font-size: 32px; font-weight: 300; font-family: var(--font-heading); color: #fff; margin-bottom: 8px;">
                <?= rpFmt($sum_fines) ?>
            </div>
            <p style="font-size: 11px; color: var(--text-secondary); margin: 0;">
                100% dari denda dialokasikan ke pemilik
            </p>
        </div>

        <!-- Card 3 -->
        <div style="background: rgba(229, 193, 88, 0.05); border: 1px solid rgba(229, 193, 88, 0.2); padding: 24px; border-radius: 8px;">
            <p style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin: 0 0 16px 0; text-transform: uppercase;">
                MY TOTAL ROYALTY
            </p>
            <div style="font-size: 32px; font-weight: 300; font-family: var(--font-heading); color: var(--accent-gold); margin-bottom: 8px;">
                <?= rpFmt($sum_my_royalty) ?>
            </div>
            <p style="font-size: 11px; color: var(--text-secondary); margin: 0;">
                <span style="display:inline-block; width:6px; height:6px; background:#4CAF50; border-radius:50%; margin-right:6px;"></span>
                90% Rental Revenue + 100% Fines
            </p>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="rh-filters-bar">
        <div class="rh-pills-group">
            <a href="<?= buildUrl(['rh_status' => 'all', 'rh_page' => 1]) ?>" class="rh-pill <?= (($_GET['rh_status'] ?? 'all') === 'all') ? 'active' : 'outline' ?>" style="text-decoration:none; color:inherit;">ALL</a>
            <a href="<?= buildUrl(['rh_status' => 'dipinjam', 'rh_page' => 1]) ?>" class="rh-pill <?= (($_GET['rh_status'] ?? '') === 'dipinjam') ? 'active' : 'outline' ?>" style="text-decoration:none; color:inherit;">BELUM SELESAI</a>
            <a href="<?= buildUrl(['rh_status' => 'selesai', 'rh_page' => 1]) ?>" class="rh-pill <?= (($_GET['rh_status'] ?? '') === 'selesai') ? 'active' : 'outline' ?>" style="text-decoration:none; color:inherit;">SELESAI</a>
        </div>
        <div class="rh-adv-filters" style="display: flex; gap: 16px;">
            <div onclick="toggleAdvFilters()" style="cursor:pointer; display:flex; align-items:center; gap:8px;">
                <i class="ph ph-funnel-simple"></i> ADVANCED FILTERS
            </div>
            <div style="cursor:pointer; display:flex; align-items:center; gap:8px; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 16px;">
                <i class="ph ph-download-simple"></i> EXPORT CSV
            </div>
        </div>
    </div>

    <!-- Advanced Filters Panel -->
    <div id="advFiltersPanel" style="display: <?= !empty($_GET['rh_id']) || !empty($_GET['rh_month']) || !empty($_GET['rh_year']) ? 'flex' : 'none' ?>; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 16px; border-radius: 8px; margin-bottom: 24px;">
        <form method="GET" action="index.php" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap:wrap; width:100%;">
            <input type="hidden" name="page" value="history-desainer">
            <input type="hidden" name="rh_status" value="<?= htmlspecialchars($_GET['rh_status'] ?? 'all') ?>">
            <input type="hidden" name="rh_search" value="<?= htmlspecialchars($_GET['rh_search'] ?? '') ?>">
            
            <div style="flex:1; min-width: 150px;">
                <label style="display:block; font-size:11px; color:var(--text-secondary); margin-bottom:8px;">ORDER ID</label>
                <input type="number" name="rh_id" value="<?= htmlspecialchars($_GET['rh_id'] ?? '') ?>" placeholder="e.g. 114" style="width:100%; padding:10px; background:rgba(0,0,0,0.2); border:1px solid rgba(255,255,255,0.1); border-radius:4px; color:#fff; outline:none;">
            </div>
            
            <div style="flex:1; min-width: 150px;">
                <label style="display:block; font-size:11px; color:var(--text-secondary); margin-bottom:8px;">BULAN</label>
                <select name="rh_month" style="width:100%; padding:10px; background:var(--bg-dark); border:1px solid rgba(255,255,255,0.1); border-radius:4px; color:#fff; outline:none;">
                    <option value="">Semua Bulan</option>
                    <?php for($i=1; $i<=12; $i++): $m = str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                    <option value="<?= $m ?>" <?= ($_GET['rh_month'] ?? '') === $m ? 'selected' : '' ?>><?= date('F', mktime(0,0,0,$i,10)) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div style="flex:1; min-width: 150px;">
                <label style="display:block; font-size:11px; color:var(--text-secondary); margin-bottom:8px;">TAHUN</label>
                <select name="rh_year" style="width:100%; padding:10px; background:var(--bg-dark); border:1px solid rgba(255,255,255,0.1); border-radius:4px; color:#fff; outline:none;">
                    <option value="">Semua Tahun</option>
                    <?php $cur_yr = date('Y'); for($y=$cur_yr+1; $y>=$cur_yr-5; $y--): ?>
                    <option value="<?= $y ?>" <?= ($_GET['rh_year'] ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div style="margin-top: 16px; display:flex; align-items:flex-end;">
                <button type="submit" style="padding:10px 24px; background:var(--accent-gold); color:#000; border:none; border-radius:4px; cursor:pointer; font-weight:600; height:41px;">TERAPKAN</button>
                <a href="index.php?page=history-desainer" style="display:inline-flex; align-items:center; height:41px; padding:0 24px; background:transparent; color:#fff; border:1px solid rgba(255,255,255,0.2); border-radius:4px; text-decoration:none; margin-left:8px;">RESET</a>
            </div>
        </form>
    </div>

    <!-- Summary Banner -->
    <div style="background: rgba(229, 193, 88, 0.05); border: 1px solid rgba(229, 193, 88, 0.2); padding: 16px; border-radius: 6px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="ph-fill ph-info" style="color: var(--accent-gold); font-size: 20px;"></i>
            <p style="margin: 0; font-size: 11px; color: var(--text-secondary); letter-spacing: 0.5px;">All transactions shown here are exclusively generated from your portfolio. Your royalty is automatically calculated at 90% of the base rental fee plus 100% of applicable fines.</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="rh-table-container">
        <table class="rh-table">
            <thead>
                <tr>
                    <th>ORDER ID</th>
                    <th>COSTUME ENTITY</th>
                    <th>RENTAL PERIOD</th>
                    <th style="text-align: right;">TOTAL FEE</th>
                    <th style="text-align: right;">DENDA KETERLAMBATAN</th>
                    <th style="text-align: right;">DENDA LAIN-LAIN</th>
                    <th style="text-align: right;">MY ROYALTY (90%)</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transaksi_list)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 48px; color: var(--text-secondary); font-size: 13px;">
                        Belum ada data royalti yang sesuai dengan pencarian Anda.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($transaksi_list as $t): 
                    // Hitung durasi sewa
                    $d1 = new DateTime($t['tanggal_sewa']);
                    $d2 = new DateTime($t['tanggal_kembali']);
                    $days = max(1, (int)$d1->diff($d2)->days);
                    
                    // Hitung biaya
                    $t_qty = (int)($t['total_qty'] ?? 1);
                    $t_qty = $t_qty > 0 ? $t_qty : 1; // avoid division by zero
                    $late_fee_per_item = ((float)($t['denda_keterlambatan'] ?? 0)) / $t_qty;
                    $my_late_fee = $late_fee_per_item * (int)$t['qty'];
                    $my_other_fee = (float)($t['denda_lain'] ?? 0);
                    
                    $total_fee = (float)$t['harga'] * (int)$t['qty'] * $days;
                    $royalty = (0.90 * $total_fee) + $my_late_fee + $my_other_fee;
                    
                    // Format tanggal
                    $tgl_sewa = date('M d, Y', strtotime($t['tanggal_sewa']));
                    $tgl_kembali = date('M d, Y', strtotime($t['tanggal_kembali']));
                    
                    // Status
                    $is_active = ($t['status'] === 'dipinjam');
                    $status_cls = $is_active ? 'rh-status-active' : 'rh-status-completed';
                    $status_txt = $is_active ? 'CURRENTLY RENTED' : 'COMPLETED & PAID';
                    
                    $gambar = !empty($t['gambar']) ? htmlspecialchars($t['gambar']) : 'assets/catalog_1.png';
                ?>
                <tr class="rh-row-clickable" onclick="openTransactionModal(this)">
                    <td>
                        <div class="rh-col-id">#<?= $t['sewa_id'] ?></div>
                    </td>
                    <td>
                        <div class="rh-col-costume">
                            <img src="<?= $gambar ?>" alt="Costume" class="rh-col-costume-img">
                            <span class="rh-col-costume-name"><?= htmlspecialchars($t['nama_kostum']) ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="rh-col-date"><?= $tgl_sewa ?> —<br><?= $tgl_kembali ?></div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount" style="color: var(--text-secondary); font-size: 13px;"><?= rpFmt($total_fee) ?></span>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-fines" style="color: <?= $my_late_fee > 0 ? '#F44336' : 'var(--text-secondary)' ?>; font-size: 13px;" data-late="<?= $my_late_fee ?>"><?= $my_late_fee > 0 ? rpFmt($my_late_fee) : '-' ?></span>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-other-fines" style="color: <?= $my_other_fee > 0 ? '#F44336' : 'var(--text-secondary)' ?>; font-size: 13px;" data-other="<?= $my_other_fee ?>"><?= $my_other_fee > 0 ? rpFmt($my_other_fee) : '-' ?></span>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-royalty" style="color: var(--accent-gold); font-weight: 700;"><?= rpFmt($royalty) ?></span>
                    </td>
                    <td>
                        <div class="rh-status-pill <?= $status_cls ?>">
                            <span class="rh-status-dot"></span> <?= $status_txt ?>
                        </div>
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
            <?php if ($total_count > 0): ?>
            SHOWING <?= min($offset + 1, $total_count) ?>–<?= min($offset + $per_page, $total_count) ?> OF <?= $total_count ?> STUDIO TRANSACTIONS
            <?php else: ?>
            SHOWING 0 TRANSACTIONS
            <?php endif; ?>
        </div>
        <div class="rh-pag-controls">
            <?php if ($page_num > 1): ?>
            <a href="<?= buildUrl(['rh_page' => $page_num - 1]) ?>" class="rh-pag-btn" style="color: var(--text-secondary); text-decoration: none;">&lt; Previous</a>
            <?php else: ?>
            <span class="rh-pag-btn" style="opacity:0.3;">&lt; Previous</span>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                <?php if ($p === $page_num): ?>
                <span class="rh-pag-num active"><?= str_pad($p, 2, '0', STR_PAD_LEFT) ?></span>
                <?php elseif ($p <= 3 || $p >= $total_pages - 1 || abs($p - $page_num) <= 1): ?>
                <a href="<?= buildUrl(['rh_page' => $p]) ?>" class="rh-pag-num" style="color: var(--text-secondary); text-decoration: none;"><?= str_pad($p, 2, '0', STR_PAD_LEFT) ?></a>
                <?php elseif ($p === 4 && $page_num > 4): ?>
                <span>...</span>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page_num < $total_pages): ?>
            <a href="<?= buildUrl(['rh_page' => $page_num + 1]) ?>" class="rh-pag-btn" style="color: var(--text-secondary); text-decoration: none;">Next &gt;</a>
            <?php else: ?>
            <span class="rh-pag-btn" style="opacity:0.3;">Next &gt;</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div class="rh-modal-overlay" id="transactionModal">
        <div class="rh-modal-content">
            <i class="ph ph-x rh-modal-close" onclick="closeTransactionModal()"></i>

            <div class="rh-modal-header">
                <div>
                    <h2 class="rh-modal-title">Royalty Detail</h2>
                    <div class="rh-modal-subtitle">TRANSACTION BREAKDOWN</div>
                </div>
                <div class="rh-receipt-meta">
                    <div class="rh-receipt-meta-id" id="modal-order-id">#0000</div>
                    <div class="rh-receipt-meta-date" id="modal-curr-date">TODAY</div>
                </div>
            </div>

            <div class="rh-payment-status">
                <div class="rh-payment-label">STATUS</div>
                <div class="rh-payment-val" id="modal-status">...</div>
            </div>

            <div class="rh-modal-columns">
                <div class="rh-modal-col">
                    <div class="rh-modal-col-title">COSTUME ENTITY</div>
                    <div class="rh-modal-col-val" id="modal-costume-name">...</div>
                </div>
                <div class="rh-modal-col">
                    <div class="rh-modal-col-title">RENTAL PERIOD</div>
                    <div class="rh-modal-col-val" id="modal-rental-period">...</div>
                </div>
            </div>

            <div class="rh-modal-items">
                <div class="rh-modal-item-ref">FINANCIAL BREAKDOWN</div>
                <div class="rh-modal-row">
                    <div>
                        <div class="rh-modal-row-name">Base Rental Fee</div>
                    </div>
                    <div class="rh-modal-row-price" id="modal-total-fee">Rp 0</div>
                </div>
                <div class="rh-modal-row">
                    <div>
                        <div class="rh-modal-row-name" style="color: var(--accent-gold);">Platform Fee (10%)</div>
                    </div>
                    <div class="rh-modal-row-price" style="color: var(--accent-gold);" id="modal-platform-fee">- Rp 0</div>
                </div>
                <div class="rh-modal-row">
                    <div>
                        <div class="rh-modal-row-name">Late Fee (100%)</div>
                    </div>
                    <div class="rh-modal-row-price" id="modal-late-fee">Rp 0</div>
                </div>
                <div class="rh-modal-row">
                    <div>
                        <div class="rh-modal-row-name">Other Fines (100%)</div>
                    </div>
                    <div class="rh-modal-row-price" id="modal-other-fee">Rp 0</div>
                </div>
            </div>

            <div class="rh-modal-total-row">
                <div class="rh-modal-total-label">My Royalty (90%)</div>
                <div class="rh-modal-total-val" style="color: var(--accent-gold);" id="modal-royalty">Rp 0</div>
            </div>

            <div class="rh-modal-actions">
                <div class="rh-mbtn rh-mbtn-solid" onclick="closeTransactionModal()">CLOSE</div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAdvFilters() {
        var panel = document.getElementById('advFiltersPanel');
        if (panel.style.display === 'none' || panel.style.display === '') {
            panel.style.display = 'flex';
        } else {
            panel.style.display = 'none';
        }
    }

    function openTransactionModal(row) {
        // Extract data from the clicked row
        var orderId = row.querySelector('.rh-col-id').innerText.replace('\n', '');
        var costumeName = row.querySelector('.rh-col-costume-name').innerText;
        var rentalPeriod = row.querySelector('.rh-col-date').innerText.replace('\n', ' ');
        var amounts = row.querySelectorAll('.rh-col-amount, .rh-col-fines, .rh-col-other-fines, .rh-col-royalty');
        var totalFeeTxt = amounts[0].innerText;
        var lateFeeNum = parseFloat(amounts[1].getAttribute('data-late')) || 0;
        var otherFeeNum = parseFloat(amounts[2].getAttribute('data-other')) || 0;
        var royaltyTxt = amounts[3].innerText;
        var statusTxt = row.querySelector('.rh-status-pill').innerText.trim();

        // Calculate generic platform fee for visual
        var totalFeeNum = parseInt(totalFeeTxt.replace(/[^0-9]/g, ''));
        var platformFeeNum = totalFeeNum * 0.1;
        var platformFeeTxt = 'Rp ' + platformFeeNum.toLocaleString('id-ID');

        // Setup current date
        var todayOpts = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        var today = new Date().toLocaleDateString('en-GB', todayOpts).toUpperCase();

        document.getElementById('modal-order-id').innerText = orderId;
        document.getElementById('modal-curr-date').innerText = today;
        document.getElementById('modal-status').innerText = statusTxt.toUpperCase();
        document.getElementById('modal-costume-name').innerText = costumeName;
        document.getElementById('modal-rental-period').innerText = rentalPeriod;
        document.getElementById('modal-total-fee').innerText = totalFeeTxt;
        document.getElementById('modal-platform-fee').innerText = '- ' + platformFeeTxt;
        document.getElementById('modal-late-fee').innerText = 'Rp ' + lateFeeNum.toLocaleString('id-ID');
        document.getElementById('modal-other-fee').innerText = 'Rp ' + otherFeeNum.toLocaleString('id-ID');
        document.getElementById('modal-royalty').innerText = royaltyTxt;

        document.getElementById('transactionModal').style.display = 'flex';
    }

    function closeTransactionModal() {
        document.getElementById('transactionModal').style.display = 'none';
    }

    // Close when clicking outside content
    window.onclick = function(event) {
        var transactionModal = document.getElementById('transactionModal');
        if (event.target == transactionModal) {
            closeTransactionModal();
        }
    }
</script>