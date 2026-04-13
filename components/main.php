<div class="ds-content">
    <div class="ds-top-bar">
        <div class="ds-title">
            <h1>Performance Dashboard</h1>
            <p>GLOBAL RENTAL FORECASTING & METRICS</p>
        </div>
        <div class="ds-period">
            <span>CURRENT PERIOD</span>
            <div class="ds-custom-dropdown" id="periodDropdown">
                <div class="ds-dropdown-header">
                    <i class="ph ph-calendar-blank" style="color: var(--accent-gold); font-size: 16px;"></i>
                    <div class="ds-dropdown-selected" id="periodSelectedText">Oct — Dec 2024</div>
                    <i class="ph ph-caret-down ds-caret" style="color: var(--text-secondary); font-size: 12px;"></i>
                </div>
                <div class="ds-dropdown-list">
                    <div class="ds-dropdown-item" data-value="today">Today</div>
                    <div class="ds-dropdown-item" data-value="this-week">This Week</div>
                    <div class="ds-dropdown-item" data-value="this-month">This Month</div>
                    <div class="ds-dropdown-item active" data-value="q4-2024">Oct — Dec 2024</div>
                    <div class="ds-dropdown-item" data-value="year-to-date">Year to Date (YTD)</div>
                </div>
            </div>
        </div>
    </div>

    <div class="ds-grid">
        <!-- Chart Widget -->
        <div class="ds-card ds-widget-chart">
            <div class="ds-widget-chart-top">
                <div class="ds-widget-chart-title">
                    <h3>Rental Performance<br>& Forecast</h3>
                    <p>YOY COMPARISON & 2024 PROJECTION</p>
                </div>
                <div class="ds-chart-legend">
                    <div class="ds-legend-item">
                        <div class="ds-legend-color last-year" style="background: #8C92A6;"></div>
                        LAST<br>YEAR
                    </div>
                    <div class="ds-legend-item">
                        <div class="ds-legend-color this-year" style="background: #E5C158;"></div>
                        THIS<br>YEAR
                    </div>
                    <div class="ds-legend-item">
                        <div class="ds-legend-color forecast" style="background: transparent; border: 2px dashed #4CAF50; width: 12px; height: 12px; border-radius: 3px; display: inline-block;"></div>
                        FORECAST
                    </div>
                </div>
            </div>
            
            <div id="rentalPerformanceChart" style="min-height: 250px; margin-top: 10px;"></div>
        </div>

        <!-- Monthly Stats -->
        <div class="ds-card ds-widget-income">
            <p style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin: 0; text-transform: uppercase;">
                MONTHLY INCOME PERFORMANCE
            </p>
            <div class="ds-income-value">Rp 142,5 Jt</div>
            <div class="ds-income-change" style="margin-bottom: 20px;">
                <i class="ph-bold ph-trend-up"></i>
                +18.2% vs last month
            </div>
            
            <p style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin: 0; text-transform: uppercase; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px;">
                TOTAL RENTED ITEMS
            </p>
            <div style="font-family: var(--font-heading); font-size: 32px; font-weight: 600; color: #fff; margin: 8px 0;">345 <span style="font-size: 12px; font-weight: normal; color: var(--text-secondary); font-family: var(--font-primary);">Pieces</span></div>
            <div class="ds-income-change" style="color: #4CAF50;">
                <i class="ph-bold ph-trend-up"></i>
                +24 items vs last month
            </div>
        </div>

        <!-- Historical Context -->
        <div class="ds-card ds-widget-historical">
            <p style="font-size: 10px; color: var(--text-secondary); letter-spacing: 1px; margin: 0; text-transform: uppercase;">
                HISTORICAL INCOME CONTEXT
            </p>
            
            <div class="ds-hist-item">
                <div class="ds-hist-top">
                    <span style="color: var(--text-secondary);">CURRENT MONTH</span>
                    <span class="val">Rp 142,5 Jt</span>
                </div>
                <div class="ds-progress-bar">
                    <div class="ds-progress-fill gold" style="width: 85%;"></div>
                </div>
            </div>

            <div class="ds-hist-item">
                <div class="ds-hist-top">
                    <span style="color: var(--text-secondary);">PREVIOUS MONTH</span>
                    <span class="val">Rp 120,5 Jt</span>
                </div>
                <div class="ds-progress-bar">
                    <div class="ds-progress-fill gray" style="width: 70%;"></div>
                </div>
            </div>
        </div>

        <!-- Trending Piece Image Card -->
        <div class="ds-card ds-widget-trending">
            <img src="assets/trending_piece.png" class="ds-trending-img" alt="Trending Dress">
            <div class="ds-trending-overlay">
                <span class="ds-badge">TRENDING PIECE</span>
                <h2>The Obsidian<br>Couture</h2>
                <p>Curated from the 2023 Noir Collection.<br>Exceptional demand predicted for Winter 2024.</p>
                <div class="ds-trending-bottom">
                    <div class="ds-trending-stat">
                        <span>RENTAL YIELD (ESTIMASI)</span>
                        <strong>Rp 18,5 Jt / Bulan</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Forecast Section Holt Winters -->
    <div class="fin-ledger-section" style="margin-top: 32px; border: 1px solid rgba(212, 175, 55, 0.2); border-radius: 8px; background: rgba(0,0,0,0.4); padding-bottom: 8px;">
        <div class="fin-ledger-header" style="border-bottom: 1px solid rgba(212, 175, 55, 0.1); padding: 20px;">
            <div>
                <h3 class="fin-ledger-title" style="color: var(--accent-gold); display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600;">
                    <i class="ph-fill ph-magic-wand"></i> HOLT-WINTERS FORECAST: 30-DAY OUTLOOK
                </h3>
                <p style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; letter-spacing: 1px; text-transform: uppercase;">Predictive Modeling Based on T-3 Months Trajectory</p>
            </div>
            <div style="padding: 4px 12px; font-size: 10px; letter-spacing: 1px; font-weight: 600; border-radius: 4px; background: rgba(212, 175, 55, 0.1); color: var(--accent-gold); border: 1px solid rgba(212, 175, 55, 0.3);">ACTIVE MODEL</div>
        </div>
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; padding: 24px;">
            <!-- Projected Revenue Stats -->
            <div style="background: rgba(0,0,0,0.2); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; justify-content: center;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                    <div>
                        <div style="font-size: 10px; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 4px;">EST. REVENUE TRAJECTORY (END OF YEAR)</div>
                        <div style="font-size: 24px; font-weight: 500; font-family: var(--font-heading); color: #fff; margin-top: 12px;">Rp 98.400.000 <span style="font-size: 12px; color: #4CAF50; font-weight: normal; font-family: 'Inter', sans-serif;"><i class="ph ph-trend-up"></i> +16.4%</span></div>
                    </div>
                    <div style="padding: 4px 8px; border-radius: 4px; background: rgba(76, 175, 80, 0.1); color: #4CAF50; font-size: 9px; font-weight: bold; letter-spacing: 1px;">
                        HIGH CONFIDENCE
                    </div>
                </div>
                <p style="font-size: 12px; color: var(--text-secondary); margin-top: 16px; line-height: 1.6;">Model preskriptif menunjukkan trajektori positif untuk Q3 & Q4 berdasarkan data historis. Grafik prediksi Holt-Winters terintegrasi pada chart performa utama di atas.</p>
            </div>

            <!-- Demand Shift -->
            <div style="background: rgba(0,0,0,0.2); padding: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                <div style="font-size: 10px; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 24px;">CATEGORY DEMAND SHIFT</div>
                <div style="margin-top: 12px; display: flex; flex-direction: column; gap: 24px;">
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 8px;">
                            <span style="color: #8CA3C5; font-weight: 500; font-size: 13px;">Busana Desainer</span> <span style="color: #fff; font-size: 13px;">65%</span>
                        </div>
                        <div style="height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden;">
                            <div style="height: 100%; width: 65%; background: #8CA3C5; border-radius: 3px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 8px;">
                            <span style="color: #C5A39B; font-weight: 500; font-size: 13px;">Kostum Karnaval</span> <span style="color: #fff; font-size: 13px;">35%</span>
                        </div>
                        <div style="height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden;">
                            <div style="height: 100%; width: 35%; background: #C5A39B; border-radius: 3px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var options = {
            series: [{
                name: 'Last Year (2023)',
                data: [35, 41, 36, 40, 50, 48, 55, 65, 58, 70, 85, 90]
            }, {
                name: 'This Year (2024)',
                data: [45, 52, 38, 45, null, null, null, null, null, null, null, null]
            }, {
                name: 'Forecast (Predicted)',
                data: [42, 55, 36, 48, 60, 58, 65, 80, 75, 95, 110, 120]
            }],
            chart: {
                height: 260,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                background: 'transparent'
            },
            colors: ['#8C92A6', '#E5C158', '#4CAF50'],
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: [2, 3, 3],
                dashArray: [0, 0, 8]
            },
            fill: {
                type: ['solid', 'gradient', 'gradient'],
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                },
                opacity: [0.1, 0.8, 0.4]
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: { style: { colors: '#8C92A6', fontSize: '10px', cssClass: 'apexcharts-xaxis-label' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { 
                    show: true,
                    style: { colors: '#8C92A6', fontSize: '10px' }
                }
            },
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.05)',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } },
                xaxis: { lines: { show: false } },
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            legend: { show: false },
            theme: { mode: 'dark' },
            tooltip: {
                theme: 'dark',
                y: { formatter: function (val) { return val + " rentals" } }
            }
        };

        var chart = new ApexCharts(document.querySelector("#rentalPerformanceChart"), options);
        chart.render();

        // Custom Dropdown Logic
        const dropdown = document.getElementById("periodDropdown");
        const header = dropdown.querySelector(".ds-dropdown-header");
        const list = dropdown.querySelector(".ds-dropdown-list");
        const selectedText = document.getElementById("periodSelectedText");
        const items = dropdown.querySelectorAll(".ds-dropdown-item");

        header.addEventListener("click", function(e) {
            e.stopPropagation();
            list.classList.toggle("show");
            header.classList.toggle("active");
        });

        items.forEach(item => {
            item.addEventListener("click", function(e) {
                e.stopPropagation();
                items.forEach(i => i.classList.remove("active"));
                this.classList.add("active");
                selectedText.innerText = this.innerText;
                list.classList.remove("show");
                header.classList.remove("active");
            });
        });

        document.addEventListener("click", function(e) {
            if (!dropdown.contains(e.target)) {
                list.classList.remove("show");
                header.classList.remove("active");
            }
        });
    });
</script>
