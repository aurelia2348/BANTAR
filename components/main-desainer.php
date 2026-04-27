<?php
require_once __DIR__ . '/../koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$designer_id = $_SESSION['user_id'] ?? ($_GET['designer_id'] ?? 3);

// ── 1. Ambil Info Desainer ────────────────────────────────────────────────────
$designer_name = "DESIGNER";
$query_designer = mysqli_query($koneksi, "SELECT username FROM users WHERE id = $designer_id");
if ($query_designer && mysqli_num_rows($query_designer) > 0) {
    $designer_name = strtoupper(mysqli_fetch_assoc($query_designer)['username']);
}

// ── 2. Total Royalty ──────────────────────────────────────────────────────────
$q_royalty = mysqli_query($koneksi, "
    SELECT s.id AS sewa_id, s.tanggal_sewa, s.tanggal_kembali,
           ds.qty, ds.harga, ds.denda_lain,
           p.denda_keterlambatan,
           (SELECT SUM(qty) FROM detail_sewa WHERE sewa_id = s.id) AS total_qty
    FROM detail_sewa ds
    JOIN stok_kostum sk ON sk.id = ds.kostum_id
    JOIN sewa s ON s.id = ds.sewa_id
    LEFT JOIN pengembalian p ON p.sewa_id = s.id
    WHERE sk.id_designer = $designer_id AND s.status = 'selesai'
");

$total_royalty = 0;
while ($r = mysqli_fetch_assoc($q_royalty)) {
    $days = max(1, (strtotime($r['tanggal_kembali']) - strtotime($r['tanggal_sewa'])) / 86400);
    $t_qty = (int)($r['total_qty'] ?? 1);
    $t_qty = $t_qty > 0 ? $t_qty : 1;
    $late_fee_per_item = ((float)($r['denda_keterlambatan'] ?? 0)) / $t_qty;
    $my_late_fee = $late_fee_per_item * (int)$r['qty'];
    $my_other_fee = (float)($r['denda_lain'] ?? 0);
    
    $total_fee = (float)$r['harga'] * (int)$r['qty'] * $days;
    $royalty_item = (0.90 * $total_fee) + $my_late_fee + $my_other_fee;
    $total_royalty += $royalty_item;
}

// ── 3. Active Garments ────────────────────────────────────────────────────────
$q_total_designer = "SELECT COUNT(*) AS c FROM stok_kostum WHERE id_designer = $designer_id";
$total_garments_designer = (int)mysqli_fetch_assoc(mysqli_query($koneksi, $q_total_designer))['c'];

$q_total_system = "SELECT COUNT(*) AS c FROM stok_kostum";
$total_garments_system = (int)mysqli_fetch_assoc(mysqli_query($koneksi, $q_total_system))['c'];

// ── 4. Top Rented Masterpieces ────────────────────────────────────────────────
$q_top = mysqli_query($koneksi, "
    SELECT sk.nama_kostum, sk.gambar, COUNT(ds.id) as rent_count,
           SUM(ds.harga * ds.qty * DATEDIFF(s.tanggal_kembali, s.tanggal_sewa)) as rent_base
    FROM detail_sewa ds
    JOIN stok_kostum sk ON sk.id = ds.kostum_id
    JOIN sewa s ON s.id = ds.sewa_id
    WHERE sk.id_designer = $designer_id AND s.status = 'selesai'
    GROUP BY sk.id
    ORDER BY rent_count DESC
    LIMIT 3
");
$top_rented = [];
if ($q_top) {
    while ($t = mysqli_fetch_assoc($q_top)) {
        $top_rented[] = $t;
    }
}

// ── 5. Currently Rented ───────────────────────────────────────────────────────
$q_rented = mysqli_query($koneksi, "
    SELECT sk.nama_kostum, s.nama_penyewa, s.tanggal_kembali, s.id as sewa_id
    FROM detail_sewa ds
    JOIN stok_kostum sk ON sk.id = ds.kostum_id
    JOIN sewa s ON s.id = ds.sewa_id
    WHERE sk.id_designer = $designer_id AND s.status = 'dipinjam'
    ORDER BY s.tanggal_kembali ASC
");
$currently_rented = [];
if ($q_rented) {
    while ($cr = mysqli_fetch_assoc($q_rented)) {
        $currently_rented[] = $cr;
    }
}

// Helper formatting
if (!function_exists('ds_rp')) {
    function ds_rp($angka) {
        // jika 84.200.000 -> 84,2 Jt format if needed, but standard format is fine
        if ($angka >= 1000000) {
            return 'Rp ' . rtrim(rtrim(number_format($angka / 1000000, 1, ',', '.'), '0'), ',') . ' Jt';
        }
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}
if (!function_exists('ds_rp_full')) {
    function ds_rp_full($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}
?>

<div class="ds-content">
    <div class="ds-top-bar">
        <div class="ds-title">
            <h1>Studio Overview</h1>
            <p><?= htmlspecialchars($designer_name) ?> PORTFOLIO & ROYALTIES</p>
        </div>
        <div class="ds-period">
            <span>CURRENT PERIOD</span>
            <div class="ds-custom-dropdown" id="periodDropdown">
                <div class="ds-dropdown-header">
                    <i class="ph ph-calendar-blank" style="color: var(--accent-gold); font-size: 16px;"></i>
                    <div class="ds-dropdown-selected" id="periodSelectedText">All Time</div>
                </div>
            </div>
        </div>
    </div>

    <div class="ds-grid">

        <!-- Royalty Income Card -->
        <div class="ds-card ds-widget-income" style="grid-column: 1 / 2; grid-row: 1 / 2; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; top: -20px; font-size: 180px; color: rgba(255,255,255,0.02); pointer-events: none;">
                <i class="ph-fill ph-money"></i>
            </div>
            <p style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin: 0; text-transform: uppercase;">
                TOTAL ROYALTY (90% CUT)
            </p>
            <div class="ds-income-value"><?= ds_rp_full($total_royalty) ?></div>
        </div>

        <!-- Active Garments Card -->
        <div class="ds-card ds-widget-income" style="grid-column: 2 / 3; grid-row: 1 / 2; display: flex; flex-direction: column; justify-content: center; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; top: -20px; font-size: 180px; color: rgba(255,255,255,0.02); pointer-events: none;">
                <i class="ph-fill ph-hanger"></i>
            </div>
            <p style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin: 0; text-transform: uppercase;">
                ACTIVE GARMENTS
            </p>
            <div class="ds-income-value" style="font-size: 48px;"><?= $total_garments_designer ?></div>
            <div class="ds-income-change" style="color: var(--text-secondary);">
                Out of <?= $total_garments_system ?> archived masterpieces
            </div>
        </div>

        <!-- Top Rented Masterpieces -->
        <div class="ds-card" style="grid-column: 1 / 2; grid-row: 2 / 4;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;">
                <div class="ds-widget-chart-title">
                    <h3>Top Rented Masterpieces</h3>
                    <p>HIGHEST YIELDING CREATIONS THIS SEASON</p>
                </div>
            </div>

            <?php if (empty($top_rented)): ?>
                <div style="color: var(--text-secondary); font-size: 13px; padding-bottom: 24px;">Belum ada riwayat penyewaan untuk portofolio Anda.</div>
            <?php else: ?>
                <?php foreach ($top_rented as $index => $tr): 
                    $is_last = ($index === count($top_rented) - 1);
                    $border = $is_last ? '' : 'border-bottom: 1px solid rgba(255,255,255,0.05);';
                    $gambar = !empty($tr['gambar']) ? $tr['gambar'] : 'assets/catalog_1.png';
                ?>
                <div style="display: flex; align-items: center; padding-bottom: 24px; <?= $border ?> margin-bottom: <?= $is_last ? '0' : '24px' ?>;">
                    <img src="<?= htmlspecialchars($gambar) ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; margin-right: 24px;">
                    <div style="flex: 1;">
                        <h4 style="font-family: var(--font-heading); margin: 0 0 4px 0; font-size: 18px;"><?= htmlspecialchars($tr['nama_kostum']) ?></h4>
                        <span style="font-size: 10px; color: var(--text-secondary); letter-spacing: 1px;">RENTED <?= $tr['rent_count'] ?> TIMES</span>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 14px; font-weight: 600; color: var(--accent-gold);"><?= ds_rp_full($tr['rent_base'] * 0.90) ?></div>
                        <div style="font-size: 9px; color: var(--text-secondary);">Royalty Generated</div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Currently Rented Alerts -->
        <div class="ds-card ds-widget-regional" style="grid-column: 2 / 3; grid-row: 2 / 3; overflow-y:auto; max-height:450px;">
            <h6 class="ds-subtitle" style="color:var(--text-primary); font-size: 16px; font-weight: 500; font-family: var(--font-primary); text-transform: none; letter-spacing: 0; margin-bottom: 8px;">Currently Rented</h6>
            <p style="font-size: 10px; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 24px;">GARMENTS CURRENTLY WITH TENANTS</p>

            <?php if (empty($currently_rented)): ?>
                <div style="color: var(--text-secondary); font-size: 13px; background: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.1); padding: 16px; border-radius: 6px; text-align: center;">
                    Tidak ada baju yang sedang dirental saat ini.
                </div>
            <?php else: ?>
                <?php foreach ($currently_rented as $cr): 
                    $tgl_balik = date('M d, Y', strtotime($cr['tanggal_kembali']));
                    $is_overdue = strtotime(date('Y-m-d')) > strtotime($cr['tanggal_kembali']);
                    $border_color = $is_overdue ? 'rgba(244, 67, 54, 0.2)' : 'rgba(229, 193, 88, 0.2)';
                    $bg_color = $is_overdue ? 'rgba(244, 67, 54, 0.05)' : 'rgba(229, 193, 88, 0.05)';
                    $icon_color = $is_overdue ? '#F44336' : 'var(--accent-gold)';
                    $icon = $is_overdue ? 'ph-warning-circle' : 'ph-clock';
                    $status_text = $is_overdue ? 'OVERDUE' : 'ON RENT';
                ?>
                <div style="background: <?= $bg_color ?>; border: 1px solid <?= $border_color ?>; padding: 16px; border-radius: 6px; display: flex; align-items: flex-start; gap: 16px; margin-bottom: 16px;">
                    <i class="ph-fill <?= $icon ?>" style="color: <?= $icon_color ?>; font-size: 24px;"></i>
                    <div>
                        <h4 style="margin: 0 0 4px 0; font-size: 13px;"><?= htmlspecialchars($cr['nama_kostum']) ?></h4>
                        <span style="font-size: 10px; color: <?= $icon_color ?>;"><?= $status_text ?></span>
                        <p style="margin: 8px 0 0 0; font-size: 11px; color: var(--text-secondary); line-height: 1.5;">Disewa oleh <strong><?= htmlspecialchars($cr['nama_penyewa']) ?></strong>. Tenggat pengembalian: <?= $tgl_balik ?>.</p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Small Insight / Status -->
        <div class="ds-card ds-widget-insight" style="grid-column: 2 / 3; grid-row: 3 / 4; border-left-color: #4CAF50;">
            <div class="ds-insight-icon" style="background: rgba(76, 175, 80, 0.1); color: #4CAF50;">
                <i class="ph-fill ph-check-circle"></i>
            </div>
            <div class="ds-insight-text">
                <p>All finalized royalties safely tracked.</p>
                <span>DATA UPDATED IN REAL-TIME</span>
            </div>
        </div>

    </div>
</div>