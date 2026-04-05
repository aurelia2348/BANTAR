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
            
            <!-- Simple SVG mockup for the chart lines -->
            <svg class="ds-chart-svg" viewBox="0 0 1000 200" preserveAspectRatio="none">
                <!-- Last Year Line (Dashed) -->
                <path d="M0,150 C100,120 200,180 300,100 C400,20 500,160 600,80 C700,0 800,140 900,40 C950,0 1000,50 1000,50" 
                      fill="none" stroke="var(--text-secondary)" stroke-width="2" stroke-dasharray="8,8" />
                
                <!-- This Year Line (Gold) -->
                <path d="M0,130 C150,130 250,50 350,80 C450,110 500,40 650,90 C800,140 850,20 1000,30" 
                      fill="none" stroke="var(--accent-gold)" stroke-width="3" />
                      
                <circle cx="850" cy="20" r="4" fill="var(--accent-gold)" />
            </svg>
            <div class="ds-chart-x-axis">
                <span>JAN</span>
                <span>FEB</span>
                <span>MAR</span>
                <span>APR</span>
                <span>MAY</span>
                <span>JUN</span>
                <span>JUL</span>
                <span>AUG</span>
                <span>SEP</span>
                <span>OCT</span>
                <span>NOV</span>
                <span>DEC</span>
            </div>
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
