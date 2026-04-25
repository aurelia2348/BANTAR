<?php
// Mock Data Generation
$dummy_transactions = [];
$total_dummy = 48;
$statuses = [
    ['status' => 'CURRENTLY RENTED', 'class' => 'rh-status-active'],
    ['status' => 'COMPLETED & PAID', 'class' => 'rh-status-completed'],
    ['status' => 'COMPLETED & PENDING', 'class' => 'rh-status-completed'],
];
$costumes = [
    ['name' => 'Midnight Structure', 'img' => 'assets/catalog_1.png', 'fee' => 7500000],
    ['name' => 'Archival Silk Dinner Shirt', 'img' => 'assets/catalog_2.png', 'fee' => 4000000],
    ['name' => 'Alabaster Fold', 'img' => 'assets/catalog_3.png', 'fee' => 3600000],
    ['name' => 'Crimson Cascade', 'img' => 'assets/catalog_1.png', 'fee' => 5000000],
    ['name' => 'Velvet Silhouette', 'img' => 'assets/catalog_2.png', 'fee' => 6200000],
];

for ($i = 0; $i < $total_dummy; $i++) {
    $c = $costumes[$i % count($costumes)];
    $s = $statuses[$i % count($statuses)];
    $ord = 9821 - $i * 11;

    $dummy_transactions[] = [
        'id' => "ORD-<br>$ord",
        'costume' => $c['name'],
        'img' => $c['img'],
        'date' => "Oct " . str_pad(12 - ($i % 10), 2, '0', STR_PAD_LEFT) . ", 2024 —<br>Oct " . str_pad(15 - ($i % 10), 2, '0', STR_PAD_LEFT) . ", 2024",
        'fee' => $c['fee'],
        'royalty' => $c['fee'] * 0.7,
        'status_text' => $s['status'],
        'status_class' => $s['class']
    ];
}

$per_page = 10;
$page_num = max(1, (int)($_GET['hd_page'] ?? 1));
$total_pages = ceil($total_dummy / $per_page);
$offset = ($page_num - 1) * $per_page;

$current_items = array_slice($dummy_transactions, $offset, $per_page);

function fmtRpHd($n)
{
    return 'Rp ' . number_format((float)$n, 0, ',', '.');
}
?>

<div class="ds-content">

    <!-- Top Header & Search -->
    <div class="rh-top-section">
        <div>
            <div class="rh-pre-title">ELENA VANHOUTTE STUDIO</div>
            <h1 class="rh-title">Royalty Ledger</h1>
        </div>
        <div class="rh-search-container">
            <i class="ph ph-magnifying-glass rh-search-icon"></i>
            <input type="text" class="rh-search-input" placeholder="Search by costume name or ID...">
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="rh-filters-bar">
        <div class="rh-pills-group">
            <div class="rh-pill active">CURRENT MONTH</div>
            <div class="rh-pill outline">LAST 3 MONTHS</div>
            <div class="rh-pill outline">YEAR TO DATE</div>
        </div>
        <div class="rh-adv-filters">
            <i class="ph ph-download-simple"></i> EXPORT CSV
        </div>
    </div>

    <!-- Summary Banner -->
    <div style="background: rgba(229, 193, 88, 0.05); border: 1px solid rgba(229, 193, 88, 0.2); padding: 16px; border-radius: 6px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="ph-fill ph-info" style="color: var(--accent-gold); font-size: 20px;"></i>
            <p style="margin: 0; font-size: 11px; color: var(--text-secondary); letter-spacing: 0.5px;">All transactions shown here are exclusively generated from your portfolio. Your royalty is automatically calculated at 70% of the base rental fee.</p>
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
                    <th style="text-align: right;">MY ROYALTY (70%)</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($current_items as $item): ?>
                    <tr class="rh-row-clickable" onclick="openTransactionModal(this)">
                        <td>
                            <div class="rh-col-id"><?= $item['id'] ?></div>
                        </td>
                        <td>
                            <div class="rh-col-costume">
                                <img src="<?= $item['img'] ?>" alt="Costume" class="rh-col-costume-img">
                                <span class="rh-col-costume-name"><?= $item['costume'] ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="rh-col-date"><?= $item['date'] ?></div>
                        </td>
                        <td style="text-align: right;">
                            <span class="rh-col-amount" style="color: var(--text-secondary); font-size: 13px;"><?= fmtRpHd($item['fee']) ?></span>
                        </td>
                        <td style="text-align: right;">
                            <span class="rh-col-amount" style="color: var(--accent-gold); font-weight: 700;"><?= fmtRpHd($item['royalty']) ?></span>
                        </td>
                        <td>
                            <div class="rh-status-pill <?= $item['status_class'] ?>">
                                <span class="rh-status-dot"></span> <?= $item['status_text'] ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="rh-pagination-bar">
        <div class="rh-pag-info">
            SHOWING <?= min((($total_dummy > 0) ? $offset + 1 : 0), $total_dummy) ?>–<?= min($offset + $per_page, $total_dummy) ?> OF <?= $total_dummy ?> STUDIO TRANSACTIONS
        </div>
        <div class="rh-pag-controls">
            <?php if ($page_num > 1): ?>
                <a href="?page=history-desainer&hd_page=<?= $page_num - 1 ?>" class="rh-pag-btn">&lt; Previous</a>
            <?php else: ?>
                <span class="rh-pag-btn" style="opacity:0.3;">&#60; Previous</span>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                <?php if ($p === $page_num): ?>
                    <span class="rh-pag-num active"><?= str_pad($p, 2, '0', STR_PAD_LEFT) ?></span>
                <?php elseif ($p <= 3 || $p >= $total_pages - 1 || abs($p - $page_num) <= 1): ?>
                    <a href="?page=history-desainer&hd_page=<?= $p ?>" class="rh-pag-num"><?= str_pad($p, 2, '0', STR_PAD_LEFT) ?></a>
                <?php elseif ($p === 4 && $page_num > 4): ?>
                    <span>...</span>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page_num < $total_pages): ?>
                <a href="?page=history-desainer&hd_page=<?= $page_num + 1 ?>" class="rh-pag-btn">Next &gt;</a>
            <?php else: ?>
                <span class="rh-pag-btn" style="opacity:0.3;">Next &#62;</span>
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
                    <div class="rh-receipt-meta-id" id="modal-order-id">ORD-0000</div>
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
                        <div class="rh-modal-row-name" style="color: var(--accent-gold);">Platform Fee (30%)</div>
                    </div>
                    <div class="rh-modal-row-price" style="color: var(--accent-gold);" id="modal-platform-fee">- Rp 0</div>
                </div>
            </div>

            <div class="rh-modal-total-row">
                <div class="rh-modal-total-label">My Royalty (70%)</div>
                <div class="rh-modal-total-val" style="color: var(--accent-gold);" id="modal-royalty">Rp 0</div>
            </div>

            <div class="rh-modal-actions">
                <div class="rh-mbtn rh-mbtn-solid" onclick="closeTransactionModal()">CLOSE</div>
            </div>
        </div>
    </div>
</div>

<script>
    function openTransactionModal(row) {
        // Extract data from the clicked row
        var orderId = row.querySelector('.rh-col-id').innerText.replace('\n', '');
        var costumeName = row.querySelector('.rh-col-costume-name').innerText;
        var rentalPeriod = row.querySelector('.rh-col-date').innerText.replace('\n', ' ');
        var amounts = row.querySelectorAll('.rh-col-amount');
        var totalFeeTxt = amounts[0].innerText;
        var royaltyTxt = amounts[1].innerText;
        var statusTxt = row.querySelector('.rh-status-pill').innerText.trim();

        // Calculate generic platform fee for visual
        var totalFeeNum = parseInt(totalFeeTxt.replace(/[^0-9]/g, ''));
        var platformFeeNum = totalFeeNum * 0.3;
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