<div class="ds-content">
    
    <!-- Top Header & Search -->
    <div class="rh-top-section">
        <div>
            <div class="rh-pre-title">HISTORICAL ARCHIVE</div>
            <h1 class="rh-title">Rental History Ledger</h1>
        </div>
        <div class="rh-search-container">
            <i class="ph ph-magnifying-glass rh-search-icon"></i>
            <input type="text" class="rh-search-input" placeholder="Search tenant or costume...">
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
            <i class="ph ph-funnel-simple"></i> ADVANCED FILTERS
        </div>
    </div>

    <!-- Table Section -->
    <div class="rh-table-container">
        <table class="rh-table">
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
                <!-- Row 1 -->
                <tr class="rh-row-clickable" onclick="openReceiptModal()">
                    <td>
                        <div class="rh-col-id">TX-<br>9821</div>
                    </td>
                    <td>
                        <div class="rh-col-tenant-name">Elena Vanhoutte</div>
                        <div class="rh-col-tenant-org">VOGUE EDITORIAL</div>
                    </td>
                    <td>
                        <div class="rh-col-costume">
                            <img src="assets/catalog_1.png" alt="Costume" class="rh-col-costume-img">
                            <span class="rh-col-costume-name">Midnight Victorian Bodice</span>
                        </div>
                    </td>
                    <td>
                        <div class="rh-col-date">Oct 12,<br>2023</div>
                    </td>
                    <td>
                        <div class="rh-col-date">Oct 26,<br>2023</div>
                    </td>
                    <td>
                        <div class="rh-status-pill rh-status-active">
                            <span class="rh-status-dot"></span> ACTIVE
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount">$1,240.00</span>
                    </td>
                    <td style="text-align: right; white-space: nowrap; padding-right: 24px;">
                        <button class="rh-btn-action rh-btn-mark" onclick="event.stopPropagation(); simulateReturn(this);"><i class="ph ph-check-circle"></i> RETURN</button>
                    </td>
                </tr>

                <!-- Row 2 -->
                <tr class="rh-row-clickable" onclick="openReceiptModal()">
                    <td>
                        <div class="rh-col-id">TX-<br>8842</div>
                    </td>
                    <td>
                        <div class="rh-col-tenant-name">Julian Thorne</div>
                        <div class="rh-col-tenant-org">MET GALA PREP</div>
                    </td>
                    <td>
                        <div class="rh-col-costume">
                            <img src="assets/catalog_2.png" alt="Costume" class="rh-col-costume-img">
                            <span class="rh-col-costume-name">Archival Silk Dinner Shirt</span>
                        </div>
                    </td>
                    <td>
                        <div class="rh-col-date">Sep 28,<br>2023</div>
                    </td>
                    <td>
                        <div class="rh-col-date">Oct 05,<br>2023</div>
                    </td>
                    <td>
                        <div class="rh-status-pill rh-status-completed">
                            <span class="rh-status-dot"></span> COMPLETED
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount">$850.00</span>
                    </td>
                    <td style="text-align: right; white-space: nowrap; padding-right: 24px;">
                        <button class="rh-btn-action rh-btn-disabled" disabled onclick="event.stopPropagation();"><i class="ph ph-lock-key"></i> CLOSED</button>
                    </td>
                </tr>

                <!-- Row 3 -->
                <tr class="rh-row-clickable" onclick="openReceiptModal()">
                    <td>
                        <div class="rh-col-id" style="color: #F44336; opacity: 0.8;">TX-<br>8711</div>
                    </td>
                    <td>
                        <div class="rh-col-tenant-name">Marcus Sterling</div>
                        <div class="rh-col-tenant-org">FILM PRODUCTION</div>
                    </td>
                    <td>
                        <div class="rh-col-costume">
                            <img src="assets/catalog_3.png" alt="Costume" class="rh-col-costume-img">
                            <span class="rh-col-costume-name">1920s Naval Greatcoat</span>
                        </div>
                    </td>
                    <td>
                        <div class="rh-col-date">Sep 15,<br>2023</div>
                    </td>
                    <td>
                        <div class="rh-col-date">Oct 01,<br>2023</div>
                    </td>
                    <td>
                        <div class="rh-status-pill rh-status-overdue">
                            <span class="rh-status-dot"></span> OVERDUE
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount">$3,400.00</span>
                    </td>
                    <td style="text-align: right; white-space: nowrap; padding-right: 24px;">
                        <button class="rh-btn-action rh-btn-urgent" onclick="event.stopPropagation(); simulateRemind(this);"><i class="ph ph-warning-circle"></i> REMIND</button>
                    </td>
                </tr>

                <!-- Row 4 -->
                <tr class="rh-row-clickable" onclick="openReceiptModal()">
                    <td>
                        <div class="rh-col-id">TX-<br>8650</div>
                    </td>
                    <td>
                        <div class="rh-col-tenant-name">Clara Fontaine</div>
                        <div class="rh-col-tenant-org">PRIVATE GALA</div>
                    </td>
                    <td>
                        <div class="rh-col-costume">
                            <img src="assets/catalog_4.png" alt="Costume" class="rh-col-costume-img">
                            <span class="rh-col-costume-name">Rose Gold Sequin Gown</span>
                        </div>
                    </td>
                    <td>
                        <div class="rh-col-date">Sep 10,<br>2023</div>
                    </td>
                    <td>
                        <div class="rh-col-date">Sep 17,<br>2023</div>
                    </td>
                    <td>
                        <div class="rh-status-pill rh-status-completed">
                            <span class="rh-status-dot"></span> COMPLETED
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount">$2,100.00</span>
                    </td>
                    <td style="text-align: right; white-space: nowrap; padding-right: 24px;">
                        <button class="rh-btn-action rh-btn-disabled" disabled onclick="event.stopPropagation();"><i class="ph ph-lock-key"></i> CLOSED</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="rh-pagination-bar">
        <div class="rh-pag-info">
            SHOWING 1 TO 4 OF 128 RECORDED TRANSACTIONS
        </div>
        <div class="rh-pag-controls">
            <span class="rh-pag-btn">&lt; Previous</span>
            <span class="rh-pag-num active">01</span>
            <span class="rh-pag-num">02</span>
            <span class="rh-pag-num">03</span>
            <span>...</span>
            <span class="rh-pag-num">32</span>
            <span class="rh-pag-btn">Next &gt;</span>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="rh-modal-overlay" id="receiptModal">
        <div class="rh-modal-content">
            <i class="ph ph-x rh-modal-close" onclick="closeReceiptModal()"></i>
            
            <div class="rh-modal-header">
                <div>
                    <h2 class="rh-modal-title">Atelier Receipt</h2>
                    <div class="rh-modal-subtitle">DIGITAL ARCHIVE RECORD</div>
                </div>
                <div class="rh-receipt-meta">
                    <div class="rh-receipt-meta-id">DA-2024-X86D-01</div>
                    <div class="rh-receipt-meta-date">14 OCTOBER 2024</div>
                </div>
            </div>

            <div class="rh-payment-status">
                <div class="rh-payment-label">PAYMENT STATUS</div>
                <div class="rh-payment-val">FULLY PAID</div>
            </div>

            <div class="rh-modal-columns">
                <div class="rh-modal-col">
                    <div class="rh-modal-col-title">BILLED TO</div>
                    <div class="rh-modal-col-val">Aria Kensington</div>
                    <div class="rh-modal-col-desc">
                        aria.k@example.com<br>
                        +62 812 3456 7890<br>
                        Jakarta, Indonesia
                    </div>
                </div>
                <div class="rh-modal-col">
                    <div class="rh-modal-col-title">RENTAL CONTEXT</div>
                    <div class="rh-modal-col-val">Private Gala Fitting</div>
                    <div class="rh-modal-col-desc">
                        Booking Period:<br>
                        Oct 20 - Oct 24 (4 Nights)
                    </div>
                </div>
            </div>

            <div class="rh-modal-items">
                <div class="rh-modal-item-ref">ITEM ARCHIVE REF: ARC-VIC-0042</div>
                <div class="rh-modal-row">
                    <div>
                        <div class="rh-modal-row-name">Victorian Gold-Embroidered Jacket</div>
                    </div>
                    <div class="rh-modal-row-price">Rp 4.200.000</div>
                </div>

                <div class="rh-modal-item-ref" style="margin-top: 24px;">ITEM ARCHIVE REF: JWL-REN-0012</div>
                <div class="rh-modal-row">
                    <div>
                        <div class="rh-modal-row-name">Renaissance Sapphire Pendant</div>
                    </div>
                    <div class="rh-modal-row-price">Rp 850.000</div>
                </div>

                <div class="rh-modal-item-ref" style="margin-top: 24px; color: var(--text-secondary);">SERVICES</div>
                <div class="rh-modal-row">
                    <div>
                        <div class="rh-modal-row-name">Insurance & Cleaning</div>
                    </div>
                    <div class="rh-modal-row-price">Rp 250.000</div>
                </div>
                <div class="rh-modal-row">
                    <div>
                        <div class="rh-modal-row-name">Courier (White-Glove)</div>
                    </div>
                    <div class="rh-modal-row-price">Rp 150.000</div>
                </div>
            </div>

            <div class="rh-modal-total-row">
                <div class="rh-modal-total-label">Total Amount</div>
                <div class="rh-modal-total-val">Rp 5.450.000</div>
            </div>

            <div class="rh-modal-actions">
                <div class="rh-mbtn rh-mbtn-outline" onclick="window.print()">DOWNLOAD PDF</div>
                <div class="rh-mbtn rh-mbtn-solid" onclick="closeReceiptModal()">RESEND TO CLIENT</div>
            </div>

        </div>
    </div>

</div>

<script>
    function openReceiptModal() {
        document.getElementById('receiptModal').style.display = 'flex';
    }

    function closeReceiptModal() {
        document.getElementById('receiptModal').style.display = 'none';
    }

    // Close when clicking outside content
    window.onclick = function(event) {
        var modal = document.getElementById('receiptModal');
        if (event.target == modal) {
            closeReceiptModal();
        }
    }

    // Interactive UI Simulation
    function simulateReturn(btn) {
        const tr = btn.closest('tr');
        const pill = tr.querySelector('.rh-status-pill');
        
        // Add a small fade effect
        pill.style.opacity = '0';
        btn.style.transform = 'scale(0.95)';
        btn.style.opacity = '0.5';

        setTimeout(() => {
            // Change pill to COMPLETED
            pill.classList.remove('rh-status-active');
            pill.classList.add('rh-status-completed');
            pill.innerHTML = '<span class="rh-status-dot"></span> COMPLETED';
            pill.style.opacity = '1';

            // Change button to CLOSED
            const tdAction = btn.parentElement;
            tdAction.innerHTML = '<button class="rh-btn-action rh-btn-disabled" disabled onclick="event.stopPropagation();"><i class="ph ph-lock-key"></i> CLOSED</button>';
        }, 300);
    }

    function simulateRemind(btn) {
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="ph ph-paper-plane-tilt"></i> SENT!';
        btn.style.backgroundColor = '#4CAF50';
        btn.style.borderColor = '#4CAF50';
        btn.style.color = '#fff';
        btn.disabled = true;

        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.backgroundColor = '';
            btn.style.borderColor = '';
            btn.style.color = '';
            btn.disabled = false;
        }, 2000);
    }
</script>
