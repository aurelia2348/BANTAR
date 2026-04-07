<div class="ds-content">
    <div class="ds-top-bar">
        <div class="ds-title">
            <h1>Performance Dashboard</h1>
            <p>GLOBAL RENTAL FORECASTING & METRICS</p>
        </div>
        <div class="ds-period">
            <span>CURRENT PERIOD</span>
            <h3>Oct — Dec 2024</h3>
        </div>
    </div>

    <div class="ds-grid">
        <!-- Chart Widget -->
        <div class="ds-card ds-widget-chart">
            <div class="ds-widget-chart-top">
                <div class="ds-widget-chart-title">
                    <h3>Year-over-Year Rental<br>Comparison</h3>
                    <p>COMPARATIVE VOLUME ANALYSIS: 2023 VS 2024</p>
                </div>
                <div class="ds-chart-legend">
                    <div class="ds-legend-item">
                        <div class="ds-legend-color this-year"></div>
                        THIS<br>YEAR
                    </div>
                    <div class="ds-legend-item">
                        <div class="ds-legend-color last-year"></div>
                        LAST<br>YEAR
                    </div>
                </div>
            </div>
            
            <div id="rentalPerformanceChart" style="min-height: 250px; margin-top: 10px;"></div>
        </div>

        <!-- Monthly Income -->
        <div class="ds-card ds-widget-income">
            <p style="font-size: 10px; color: var(--accent-gold); letter-spacing: 1px; margin: 0; text-transform: uppercase;">
                MONTHLY INCOME PERFORMANCE
            </p>
            <div class="ds-income-value">$142.5K</div>
            <div class="ds-income-change">
                <i class="ph-bold ph-trend-up"></i>
                +18.2% vs last month
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
                    <span class="val">$142,500</span>
                </div>
                <div class="ds-progress-bar">
                    <div class="ds-progress-fill gold" style="width: 85%;"></div>
                </div>
            </div>

            <div class="ds-hist-item">
                <div class="ds-hist-top">
                    <span style="color: var(--text-secondary);">PREVIOUS MONTH</span>
                    <span class="val">$120,540</span>
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
                        <span>RENTAL YIELD</span>
                        <strong>$1,250 / Week</strong>
                    </div>
                    <button class="ds-btn-outline">VIEW ANALYTICS</button>
                </div>
            </div>
        </div>

        <!-- Regional Performance -->
        <div class="ds-card ds-widget-regional">
            <h6 class="ds-subtitle" style="color:var(--text-primary); font-size: 16px; font-weight: 500; font-family: var(--font-primary); text-transform: none; letter-spacing: 0;">Regional Performance</h6>
            
            <div class="ds-regional-item">
                <div class="ds-reg-label">PARIS ATELIER</div>
                <div class="ds-reg-bar"><div class="ds-reg-fill yellow" style="width: 92%;"></div></div>
                <div class="ds-reg-val">92%</div>
            </div>
            <div class="ds-regional-item">
                <div class="ds-reg-label">LONDON ARCHIVE</div>
                <div class="ds-reg-bar"><div class="ds-reg-fill yellow" style="width: 78%;"></div></div>
                <div class="ds-reg-val">78%</div>
            </div>
            <div class="ds-regional-item">
                <div class="ds-reg-label">MILAN SUITE</div>
                <div class="ds-reg-bar"><div class="ds-reg-fill blue" style="width: 84%;"></div></div>
                <div class="ds-reg-val">84%</div>
            </div>
            <div class="ds-regional-item">
                <div class="ds-reg-label">NEW YORK VAULT</div>
                <div class="ds-reg-bar"><div class="ds-reg-fill peach" style="width: 65%;"></div></div>
                <div class="ds-reg-val">65%</div>
            </div>
        </div>

        <!-- Insight Banner -->
        <div class="ds-card ds-widget-insight">
            <div class="ds-insight-icon">
                <i class="ph-fill ph-magic-wand"></i>
            </div>
            <div class="ds-insight-text">
                <p>"The Golden Hour Collection" is gaining viral momentum.</p>
                <span>AI CURATOR INSIGHT — ACTION REQUIRED: INCREASE AVAILABILITY IN PARIS</span>
            </div>
            <i class="ph ph-x ds-insight-close"></i>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var options = {
            series: [{
                name: 'This Year (2024)',
                data: [45, 52, 38, 45, 60, 58, 65, 80, 75, 95, 110, 120]
            }, {
                name: 'Last Year (2023)',
                data: [35, 41, 36, 40, 50, 48, 55, 65, 58, 70, 85, 90]
            }],
            chart: {
                height: 260,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                background: 'transparent'
            },
            colors: ['#E5C158', '#8C92A6'],
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: [3, 2],
                dashArray: [0, 8]
            },
            fill: {
                type: ['gradient', 'solid'],
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                },
                opacity: [0.8, 0.1]
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: { style: { colors: '#8C92A6', fontSize: '10px', cssClass: 'apexcharts-xaxis-label' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { show: false }
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
    });
</script>
