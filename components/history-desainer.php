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
                <!-- Row 1 -->
                <tr class="rh-row-clickable" onclick="openTransactionModal(this)">
                    <td>
                        <div class="rh-col-id">ORD-<br>9821</div>
                    </td>
                    <td>
                        <div class="rh-col-costume">
                            <img src="assets/catalog_1.png" alt="Costume" class="rh-col-costume-img">
                            <span class="rh-col-costume-name">Midnight Structure</span>
                        </div>
                    </td>
                    <td>
                        <div class="rh-col-date">Oct 12, 2024 —<br>Oct 15, 2024</div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount" style="color: var(--text-secondary); font-size: 13px;">Rp 7.500.000</span>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount" style="color: var(--accent-gold); font-weight: 700;">Rp 5.250.000</span>
                    </td>
                    <td>
                        <div class="rh-status-pill rh-status-active">
                            <span class="rh-status-dot"></span> CURRENTLY RENTED
                        </div>
                    </td>
                </tr>

                <!-- Row 2 -->
                <tr class="rh-row-clickable" onclick="openTransactionModal(this)">
                    <td>
                        <div class="rh-col-id">ORD-<br>9780</div>
                    </td>
                    <td>
                        <div class="rh-col-costume">
                            <img src="assets/catalog_2.png" alt="Costume" class="rh-col-costume-img">
                            <span class="rh-col-costume-name">Archival Silk Dinner Shirt</span>
                        </div>
                    </td>
                    <td>
                        <div class="rh-col-date">Oct 01, 2024 —<br>Oct 03, 2024</div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount" style="color: var(--text-secondary); font-size: 13px;">Rp 4.000.000</span>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount" style="color: var(--accent-gold); font-weight: 700;">Rp 2.800.000</span>
                    </td>
                    <td>
                        <div class="rh-status-pill rh-status-completed">
                            <span class="rh-status-dot"></span> COMPLETED & PAID
                        </div>
                    </td>
                </tr>

                <!-- Row 3 -->
                <tr class="rh-row-clickable" onclick="openTransactionModal(this)">
                    <td>
                        <div class="rh-col-id" style="color: #F44336; opacity: 0.8;">ORD-<br>9711</div>
                    </td>
                    <td>
                        <div class="rh-col-costume">
                            <img src="assets/catalog_3.png" alt="Costume" class="rh-col-costume-img">
                            <span class="rh-col-costume-name">Alabaster Fold</span>
                        </div>
                    </td>
                    <td>
                        <div class="rh-col-date">Sep 20, 2024 —<br>Sep 22, 2024</div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount" style="color: var(--text-secondary); font-size: 13px;">Rp 3.600.000</span>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount" style="color: var(--accent-gold); font-weight: 700;">Rp 2.520.000</span>
                    </td>
                    <td>
                        <div class="rh-status-pill rh-status-completed">
                            <span class="rh-status-dot"></span> COMPLETED & PAID
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="rh-pagination-bar">
        <div class="rh-pag-info">
            SHOWING 3 OF 48 STUDIO TRANSACTIONS
        </div>
        <div class="rh-pag-controls">
            <span class="rh-pag-btn">&lt; Previous</span>
            <span class="rh-pag-num active">01</span>
            <span class="rh-pag-num">02</span>
            <span>...</span>
            <span class="rh-pag-num">15</span>
            <span class="rh-pag-btn">Next &gt;</span>
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
        var todayOpts = { year: 'numeric', month: 'long', day: 'numeric' };
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
