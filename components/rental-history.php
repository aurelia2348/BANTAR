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
                            <span class="rh-status-dot"></span> BELUM SELESAI
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount">Rp 1.240.000</span>
                    </td>
                    <td style="text-align: right; white-space: nowrap; padding-right: 24px;">
                        <button class="rh-btn-action rh-btn-mark" onclick="event.stopPropagation(); simulateReturn(this);"><i class="ph ph-check-circle"></i> TANDAI SELESAI</button>
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
                            <span class="rh-status-dot"></span> SELESAI
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount">Rp 850.000</span>
                    </td>
                    <td style="text-align: right; white-space: nowrap; padding-right: 24px;">
                        <button class="rh-btn-action rh-btn-disabled" disabled onclick="event.stopPropagation();"><i class="ph ph-lock-key"></i> SELESAI</button>
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
                        <div class="rh-status-pill rh-status-active">
                            <span class="rh-status-dot"></span> BELUM SELESAI
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount">Rp 3.400.000</span>
                    </td>
                    <td style="text-align: right; white-space: nowrap; padding-right: 24px;">
                        <button class="rh-btn-action rh-btn-mark" onclick="event.stopPropagation(); simulateReturn(this);"><i class="ph ph-check-circle"></i> TANDAI SELESAI</button>
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
                            <span class="rh-status-dot"></span> SELESAI
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <span class="rh-col-amount">Rp 2.100.000</span>
                    </td>
                    <td style="text-align: right; white-space: nowrap; padding-right: 24px;">
                        <button class="rh-btn-action rh-btn-disabled" disabled onclick="event.stopPropagation();"><i class="ph ph-lock-key"></i> SELESAI</button>
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

    <!-- Return Form Modal -->
    <div class="rh-modal-overlay" id="returnFormModal">
        <div class="rh-modal-content" style="max-width: 500px; padding: 32px;">
            <i class="ph ph-x rh-modal-close" onclick="closeReturnModal()"></i>
            
            <h2 class="rh-modal-title" style="margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 16px;">Kelola Transaksi</h2>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-secondary); margin-bottom: 8px; letter-spacing: 1px;">NAMA PENYEWA</label>
                <input type="text" id="rf-tenant" readonly style="width: 100%; padding: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; color: var(--text-secondary); outline: none;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-secondary); margin-bottom: 8px; letter-spacing: 1px;">NAMA BARANG &amp; JUMLAH</label>
                <input type="text" id="rf-item" readonly style="width: 100%; padding: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; color: var(--text-secondary); outline: none;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-secondary); margin-bottom: 8px; letter-spacing: 1px;">TANGGAL KEMBALI</label>
                <input type="text" id="rf-return-date" readonly style="width: 100%; padding: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; color: var(--text-secondary); outline: none;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-secondary); margin-bottom: 8px; letter-spacing: 1px;">TANGGAL KEMBALI SEBENARNYA</label>
                <input type="date" id="rf-actual-date" style="width: 100%; padding: 12px; background: transparent; border: 1px solid rgba(255,255,255,0.2); border-radius: 4px; color: #fff; outline: none;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-secondary); margin-bottom: 8px; letter-spacing: 1px;">DENDA KETERLAMBATAN (RP)</label>
                <input type="number" id="rf-late-fee" value="0" readonly style="width: 100%; padding: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; color: var(--text-secondary); outline: none;">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 11px; color: var(--text-secondary); margin-bottom: 8px; letter-spacing: 1px;">DENDA LAIN-LAIN (RP)</label>
                <input type="number" id="rf-other-fee" value="0" style="width: 100%; padding: 12px; background: transparent; border: 1px solid rgba(255,255,255,0.2); border-radius: 4px; color: #fff; outline: none;">
            </div>

            <div style="display: flex; gap: 16px;">
                <button class="rh-btn-action" style="flex: 1; justify-content: center; background: var(--accent-gold); color: #000; border: none; padding: 12px;" onclick="confirmReturn()">SIMPAN</button>
                <button class="rh-btn-action" style="flex: 1; justify-content: center; background: transparent; border: 1px solid rgba(255,255,255,0.2); padding: 12px;" onclick="closeReturnModal()">TUTUP</button>
            </div>
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
        var receiptModal = document.getElementById('receiptModal');
        var returnModal = document.getElementById('returnFormModal');
        if (event.target == receiptModal) {
            closeReceiptModal();
        }
        if (event.target == returnModal) {
            closeReturnModal();
        }
    }

    // Interactive UI Simulation
    function simulateReturn(btn) {
        const tr = btn.closest('tr');
        const tenantName = tr.querySelector('.rh-col-tenant-name').innerText;
        const costumeName = tr.querySelector('.rh-col-costume-name').innerText;
        
        // Get date and format string "Oct 26, 2023"
        let returnDateTxt = tr.querySelectorAll('td')[4].querySelector('.rh-col-date').innerText.trim().replace(/\n/g, ' ');
        
        document.getElementById('rf-tenant').value = tenantName;
        document.getElementById('rf-item').value = costumeName + " x1";
        document.getElementById('rf-return-date').value = returnDateTxt;
        
        // Auto set actual date to today
        const today = new Date().toISOString().split('T')[0];
        const actualDateInput = document.getElementById('rf-actual-date');
        actualDateInput.value = today;

        window.currentReturnBtn = btn;
        document.getElementById('returnFormModal').style.display = 'flex';
        
        // Trigger event to calculate potential late fees
        actualDateInput.dispatchEvent(new Event('change'));
    }

    function closeReturnModal() {
        document.getElementById('returnFormModal').style.display = 'none';
        window.currentReturnBtn = null;
    }

    function confirmReturn() {
        const btn = window.currentReturnBtn;
        closeReturnModal();
        if (btn) {
            const tr = btn.closest('tr');
            const pill = tr.querySelector('.rh-status-pill');
            
            // Add a small fade effect
            pill.style.opacity = '0';
            btn.style.transform = 'scale(0.95)';
            btn.style.opacity = '0.5';

            setTimeout(() => {
                // Change pill to COMPLETED
                pill.classList.remove('rh-status-active');
                pill.classList.remove('rh-status-overdue');
                pill.classList.add('rh-status-completed');
                pill.innerHTML = '<span class="rh-status-dot"></span> SELESAI';
                pill.style.opacity = '1';

                // Change button to CLOSED
                const tdAction = btn.parentElement;
                tdAction.innerHTML = '<button class="rh-btn-action rh-btn-disabled" disabled onclick="event.stopPropagation();"><i class="ph ph-lock-key"></i> SELESAI</button>';
            }, 300);
        }
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
    document.getElementById('rf-actual-date').addEventListener('change', function() {
        const expectedStr = document.getElementById('rf-return-date').value;
        const expectedDate = new Date(expectedStr);
        const actualDate = new Date(this.value);
        const lateFeeInput = document.getElementById('rf-late-fee');
        
        if (!isNaN(expectedDate.getTime()) && !isNaN(actualDate.getTime())) {
            expectedDate.setHours(0,0,0,0);
            actualDate.setHours(0,0,0,0);
            
            if (actualDate > expectedDate) {
                const diffTime = actualDate.getTime() - expectedDate.getTime();
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                lateFeeInput.value = diffDays * 25000;
            } else {
                lateFeeInput.value = 0;
            }
        } else {
            lateFeeInput.value = 0;
        }
    });
</script>
