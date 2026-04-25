<?php
require_once __DIR__ . '/../koneksi.php';

// ── Agregat untuk stat cards ─────────────────────────────────────────────────
$agg = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT
        COALESCE(SUM(total_pemasukan), 0) AS gross,
        COALESCE(SUM(bantar_share),    0) AS bantar,
        COALESCE(SUM(designer_share),  0) AS designer,
        COALESCE(SUM(model_share),     0) AS model
    FROM laporan_keuangan
"));

// ── Pagination untuk Ledger ──────────────────────────────────────────────────
$per_page  = 10;
$page_num  = max(1, (int)($_GET['f_page'] ?? 1));
$offset    = ($page_num - 1) * $per_page;

$total_count = (int)mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS c FROM laporan_keuangan")
)['c'];
$total_pages = max(1, ceil($total_count / $per_page));

// ── Fetch ledger rows (join sewa untuk nama penyewa) ─────────────────────────
$ledger = mysqli_query($koneksi, "
    SELECT lk.*,
           s.nama_penyewa,
           s.tanggal_sewa,
           s.tanggal_kembali
    FROM laporan_keuangan lk
    JOIN sewa s ON s.id = lk.sewa_id
    ORDER BY lk.tanggal_transaksi DESC, lk.id DESC
    LIMIT $per_page OFFSET $offset
");

function rpFmt($n)
{
    return 'Rp ' . number_format((float)$n, 0, ',', '.');
}
?>

<div class="ds-content">
    <div class="ds-top-bar" style="align-items: center;">
        <div class="ds-title">
            <h1>Financial Reports</h1>
            <p style="text-transform: none; color: var(--text-secondary); font-size: 13px; max-width: 600px; line-height: 1.6; margin-top: 12px; letter-spacing: 0;">
                A breakdown of revenue streams across BANTAR's dual inventory model:
                <span style="color: var(--accent-gold); font-weight: bold;">Designer Partner Collections</span>
                and <span style="color: var(--accent-gold); font-weight: bold;">Owned Carnival Costumes</span>.
            </p>
        </div>
        <div class="fin-top-actions">
            <button class="fin-btn fin-btn-primary" onclick="exportPDF()"><i class="ph-fill ph-file-pdf"></i> EXPORT TO PDF</button>
        </div>
    </div>

    <!-- Stats Grid (dari DB) -->
    <div class="fin-stats-grid">
        <div class="fin-stat-card">
            <div class="fin-stat-label">TOTAL GROSS REVENUE</div>
            <div class="fin-stat-value"><?= rpFmt($agg['gross']) ?></div>
            <div class="fin-stat-meta" style="color: var(--text-secondary); font-size: 10px;">
                Total seluruh pemasukan termasuk denda
            </div>
        </div>
        <div class="fin-stat-card">
            <div class="fin-stat-label">BANTAR NET EARNINGS</div>
            <div class="fin-stat-value"><?= rpFmt($agg['bantar']) ?></div>
            <div class="fin-stat-meta">
                FROM 10% DESIGNER + CARNIVAL + FINES
            </div>
        </div>
        <div class="fin-stat-card">
            <div class="fin-stat-label">DESIGNER PAYOUTS</div>
            <div class="fin-stat-value"><?= rpFmt($agg['designer']) ?></div>
            <div class="fin-stat-meta">
                90% SHARE + 100% DESIGNER FINES
            </div>
        </div>
        <div class="fin-stat-card">
            <div class="fin-stat-label">MODEL &amp; TALENT FEES</div>
            <div class="fin-stat-value"><?= rpFmt($agg['model']) ?></div>
            <div class="fin-stat-meta" style="color: var(--text-secondary);">
                <div class="fin-stat-meta-icon"><i class="ph-fill ph-users"></i></div> 30% FROM CARNIVAL PACKAGES
            </div>
        </div>
    </div>

    <!-- Ledger Table -->
    <div class="fin-ledger-section">
        <div class="fin-ledger-header">
            <h3 class="fin-ledger-title">TRANSACTION SPLIT LEDGER</h3>
            <div class="fin-ledger-legend">
                <div class="fin-legend-item">
                    <span class="fin-legend-dot fin-dot-gold"></span> BANTAR
                </div>
                <div class="fin-legend-item">
                    <span class="fin-legend-dot fin-dot-blue"></span> DESIGNER
                </div>
                <div class="fin-legend-item">
                    <span class="fin-legend-dot fin-dot-peach"></span> MODEL
                </div>
            </div>
        </div>

        <table class="fin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SEWA ID</th>
                    <th>TANGGAL TRANSAKSI</th>
                    <th>DENDA KETERLAMBATAN</th>
                    <th>DENDA LAIN</th>
                    <th>RENTAL FEE</th>
                    <th>TOTAL PEMASUKAN</th>
                    <th>BANTAR SHARE</th>
                    <th>DESIGNER SHARE</th>
                    <th>MODEL SHARE</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($ledger && mysqli_num_rows($ledger) > 0):
                    while ($row = mysqli_fetch_assoc($ledger)):
                        $tgl = $row['tanggal_transaksi']
                            ? date('d M Y', strtotime($row['tanggal_transaksi']))
                            : '–';

                        $dk = (float)$row['denda_keterlambatan'];
                        $dl = (float)$row['denda_lain'];
                        $rf = (float)$row['rental_fee'];
                        $tp = (float)$row['total_pemasukan'];
                        $bs = (float)$row['bantar_share'];
                        $ds = (float)$row['designer_share'];
                        $ms = (float)$row['model_share'];
                ?>
                        <tr>
                            <!-- ID -->
                            <td>
                                <span class="fin-val-main" style="color: var(--text-secondary); font-size: 11px;">#<?= $row['id'] ?></span>
                            </td>
                            <!-- SEWA ID -->
                            <td>
                                <span class="fin-val-main" style="font-size: 12px;">#<?= $row['sewa_id'] ?></span>
                            </td>
                            <!-- TANGGAL TRANSAKSI -->
                            <td>
                                <span class="fin-val-main"><?= $tgl ?></span>
                            </td>
                            <!-- DENDA KETERLAMBATAN -->
                            <td>
                                <span class="fin-val-main" style="color: <?= $dk > 0 ? '#F44336' : 'var(--text-secondary)' ?>;">
                                    <?= $dk > 0 ? rpFmt($dk) : '—' ?>
                                </span>
                            </td>
                            <!-- DENDA LAIN -->
                            <td>
                                <span class="fin-val-main" style="color: <?= $dl > 0 ? '#F44336' : 'var(--text-secondary)' ?>;">
                                    <?= $dl > 0 ? rpFmt($dl) : '—' ?>
                                </span>
                            </td>
                            <!-- RENTAL FEE -->
                            <td>
                                <span class="fin-val-main"><?= rpFmt($rf) ?></span>
                            </td>
                            <!-- TOTAL PEMASUKAN -->
                            <td>
                                <span class="fin-val-main" style="font-weight: 700;"><?= rpFmt($tp) ?></span>
                            </td>
                            <!-- BANTAR SHARE -->
                            <td>
                                <span class="fin-val-main fin-val-gold"><?= $bs > 0 ? rpFmt($bs) : '—' ?></span>
                            </td>
                            <!-- DESIGNER SHARE -->
                            <td>
                                <span class="fin-val-main" style="color: #8CA3C5;"><?= $ds > 0 ? rpFmt($ds) : '—' ?></span>
                            </td>
                            <!-- MODEL SHARE -->
                            <td>
                                <span class="fin-val-main" style="color: #C5A39B;"><?= $ms > 0 ? rpFmt($ms) : '—' ?></span>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 48px; color: var(--text-secondary); font-size: 13px;">
                            Belum ada data laporan keuangan. Tandai penyewaan sebagai selesai untuk membuat entri.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="rh-pagination-bar" style="margin-top: 16px;">
        <div class="rh-pag-info">
            SHOWING <?= min((($total_count > 0) ? $offset + 1 : 0), $total_count) ?>–<?= min($offset + $per_page, $total_count) ?> OF <?= $total_count ?> TRANSACTIONS
        </div>
        <div class="rh-pag-controls">
            <?php if ($page_num > 1): ?>
                <a href="?page=financial&f_page=<?= $page_num - 1 ?>" class="rh-pag-btn">&lt; Previous</a>
            <?php else: ?>
                <span class="rh-pag-btn" style="opacity:0.3;">&#60; Previous</span>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                <?php if ($p === $page_num): ?>
                    <span class="rh-pag-num active"><?= str_pad($p, 2, '0', STR_PAD_LEFT) ?></span>
                <?php elseif ($p <= 3 || $p >= $total_pages - 1 || abs($p - $page_num) <= 1): ?>
                    <a href="?page=financial&f_page=<?= $p ?>" class="rh-pag-num"><?= str_pad($p, 2, '0', STR_PAD_LEFT) ?></a>
                <?php elseif ($p === 4 && $page_num > 4): ?>
                    <span>...</span>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page_num < $total_pages): ?>
                <a href="?page=financial&f_page=<?= $page_num + 1 ?>" class="rh-pag-btn">Next &gt;</a>
            <?php else: ?>
                <span class="rh-pag-btn" style="opacity:0.3;">Next &#62;</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bottom Panels -->
    <div class="fin-bottom-grid">
        <div class="fin-panel">
            <h3 class="fin-panel-title">BUSINESS LOGIC &amp; SPLIT RULES</h3>

            <div class="fin-rationale-item" style="border-left: 3px solid #8CA3C5; padding-left: 16px;">
                <div class="fin-rat-top">
                    <span style="font-weight: bold; color: #8CA3C5;">BUSANA DESAINER</span>
                </div>
                <p style="font-size: 11px; color: var(--text-secondary); margin-top: 8px;">
                    Sewa Dasar: <strong>10% BANTAR | 90% DESAINER</strong><br>
                    Tagihan Fines (Denda Keterlambatan/Kerusakan) utuh <strong>100% dialokasikan ke Desainer</strong>.
                </p>
            </div>

            <div class="fin-rationale-item" style="border-left: 3px solid #C5A39B; padding-left: 16px; margin-top: 24px;">
                <div class="fin-rat-top">
                    <span style="font-weight: bold; color: #C5A39B;">KOSTUM KARNAVAL (+ MODEL)</span>
                </div>
                <p style="font-size: 11px; color: var(--text-secondary); margin-top: 8px;">
                    Harga paket lebih tinggi. Sewa Dasar: <strong>70% BANTAR | 30% MODEL</strong><br>
                    Tagihan Fines (Denda) dialokasikan <strong>100% ke pihak BANTAR</strong>.
                </p>
            </div>

            <div class="fin-rationale-item" style="border-left: 3px solid var(--accent-gold); padding-left: 16px; margin-top: 24px; margin-bottom: 0;">
                <div class="fin-rat-top">
                    <span style="font-weight: bold; color: var(--accent-gold);">KOSTUM KARNAVAL (TANPA MODEL)</span>
                </div>
                <p style="font-size: 11px; color: var(--text-secondary); margin-top: 8px;">
                    Sewa Dasar: <strong>100% BANTAR</strong><br>
                    Karena properti penuh milik BANTAR, segala Denda juga <strong>100% ditarik ke BANTAR</strong>.
                </p>
            </div>
        </div>

        <div class="fin-panel">
            <h3 class="fin-panel-title white">SETTLEMENT TIMELINE</h3>

            <div class="fin-timeline">
                <div class="fin-tl-item">
                    <div class="fin-tl-dot gold"></div>
                    <div class="fin-tl-content">
                        <h5>Platform Collection</h5>
                        <p>DAY 01 - AUTOMATIC TRANSFER</p>
                    </div>
                </div>
                <div class="fin-tl-item">
                    <div class="fin-tl-dot blue"></div>
                    <div class="fin-tl-content">
                        <h5>Designer Payouts</h5>
                        <p>DAY 15 - BATCH PROCESSING</p>
                    </div>
                </div>
                <div class="fin-tl-item">
                    <div class="fin-tl-dot grey"></div>
                    <div class="fin-tl-content">
                        <h5>External Agency Settlement</h5>
                        <p>DAY 30 - QUARTERLY BALANCE</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function exportPDF() {
    var element = document.querySelector('.ds-content');
    var opt = {
        margin:       [0.5, 0.5],
        filename:     'Financial_Report_BANTAR.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true, logging: false },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
    };
    
    // Hide actions and pagination for clean print
    var actions = document.querySelector('.fin-top-actions');
    var pagination = document.querySelector('.rh-pagination-bar');
    if (actions) actions.style.display = 'none';
    if (pagination) pagination.style.display = 'none';
    
    html2pdf().set(opt).from(element).save().then(() => {
        // Restore layout
        if (actions) actions.style.display = '';
        if (pagination) pagination.style.display = 'flex';
    });
}
</script>