<div class="ds-content">
    <div class="settings-container">
        <!-- Sidebar Tabs -->
        <div class="settings-sidebar">
            <ul class="settings-nav">
                <li class="settings-nav-item active" data-target="pane-rules">
                    <i class="ph ph-sliders"></i>
                    Rental Rules
                </li>
                <li class="settings-nav-item" data-target="pane-users">
                    <i class="ph ph-users"></i>
                    User Management
                </li>
                <li class="settings-nav-item" data-target="pane-taxonomies">
                    <i class="ph ph-list-dashes"></i>
                    Categories Archive
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="settings-content">
            
            <!-- Pane 1: Rental Rules -->
            <div class="settings-pane active" id="pane-rules">
                <div class="settings-header">
                    <h2>Master Configurations</h2>
                    <p>Setup system-wide default parameters for rentals and violations.</p>
                </div>
                
                <div class="settings-card">
                    <div class="settings-card-title">Default Governance</div>
                    <div class="settings-form-row" style="grid-template-columns: 1fr;">
                        <div class="settings-field">
                            <label>Default Rental Duration (Days)</label>
                            <input type="number" class="settings-input" value="3" />
                        </div>
                    </div>
                </div>

                <div class="settings-card">
                    <div class="settings-card-title">Penalty & Violations</div>
                    <div class="settings-form-row"> 
                        <div class="settings-field">
                            <label>Late Return Fee / Day (Rp)</label>
                            <input type="number" class="settings-input" value="100000" />
                        </div>
                        <div class="settings-field">
                            <label>Severe Damage Retain Limit (%)</label>
                            <input type="number" class="settings-input" value="100" />
                        </div>
                    </div>
                </div>

                <button class="settings-btn-primary">SAVE CONFIGURATIONS</button>
            </div>

            <!-- Pane 2: User Management -->
            <div class="settings-pane" id="pane-users">
                <div class="settings-header" style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <h2>Access & Privileges</h2>
                        <p>Manage system access for curators, administrators, and designers.</p>
                    </div>
                    <button class="settings-btn-primary" style="background: transparent; border: 1px solid var(--accent-gold); color: var(--accent-gold);" onclick="document.getElementById('newUserForm').style.display = 'block';">+ NEW ACCESSS</button>
                </div>

                <!-- Hidden form for new user -->
                <div id="newUserForm" class="settings-card" style="display: none; border-color: var(--accent-gold);">
                    <div class="settings-card-title" style="display: flex; justify-content: space-between;">
                        <span>Grant New Access</span>
                        <i class="ph ph-x action-icon" onclick="document.getElementById('newUserForm').style.display = 'none';"></i>
                    </div>
                    <div class="settings-form-row">
                        <div class="settings-field">
                            <label>Full Name</label>
                            <input type="text" class="settings-input" placeholder="e.g. Aria Vanguard" />
                        </div>
                        <div class="settings-field">
                            <label>Email Address</label>
                            <input type="email" class="settings-input" placeholder="aria@bantar.com" />
                        </div>
                    </div>
                    <div class="settings-form-row">
                        <div class="settings-field">
                            <label>System Role</label>
                            <select class="settings-input" style="appearance: none; cursor: pointer;">
                                <option>Administrator</option>
                                <option>Designer</option>
                            </select>
                        </div>
                        <div class="settings-field">
                            <label>Initial Password</label>
                            <input type="password" class="settings-input" placeholder="••••••••" />
                        </div>
                    </div>
                    <button class="settings-btn-primary">CREATE ACCOUNT</button>
                </div>

                <div class="settings-card">
                    <table class="settings-table">
                        <thead>
                            <tr>
                                <th>Identity</th>
                                <th>Email</th>
                                <th>Privilege Role</th>
                                <th>Last Active</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="user-avatar">B</div>
                                        <strong>Bara Exclusives</strong>
                                    </div>
                                </td>
                                <td style="color: var(--text-secondary);">bara@bantar.id</td>
                                <td><span class="role-badge role-admin">ADMINISTRATOR</span></td>
                                <td style="color: var(--text-secondary);">Online now</td>
                                <td style="text-align: right;">
                                    <i class="ph ph-pencil-simple action-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="user-avatar" style="color: #fff;">EV</div>
                                        <strong>Elena Vanhoutte</strong>
                                    </div>
                                </td>
                                <td style="color: var(--text-secondary);">elena@studio.com</td>
                                <td><span class="role-badge role-designer">DESIGNER</span></td>
                                <td style="color: var(--text-secondary);">2 days ago</td>
                                <td style="text-align: right;">
                                    <i class="ph ph-pencil-simple action-icon"></i>
                                    <i class="ph ph-trash action-icon danger"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center;">
                                        <div class="user-avatar" style="color: #fff;">NV</div>
                                        <strong>Nova Veil</strong>
                                    </div>
                                </td>
                                <td style="color: var(--text-secondary);">hello@novaveil.co</td>
                                <td><span class="role-badge role-designer">DESIGNER</span></td>
                                <td style="color: var(--text-secondary);">1 week ago</td>
                                <td style="text-align: right;">
                                    <i class="ph ph-pencil-simple action-icon"></i>
                                    <i class="ph ph-trash action-icon danger"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pane 3: Categories -->
            <div class="settings-pane" id="pane-taxonomies">
                <div class="settings-header">
                    <h2>Taxonomies & Categories</h2>
                    <p>Define the classification structures for the garment archive.</p>
                </div>

                <div class="settings-form-row">
                    <!-- Add Category Form -->
                    <div class="settings-card" style="align-self: start;">
                        <div class="settings-card-title">Register Category</div>
                        <div class="settings-field" style="margin-bottom: 24px;">
                            <label>Category Identifier</label>
                            <input type="text" class="settings-input" placeholder="e.g. Bridal Wear" />
                        </div>
                        <div class="settings-field" style="margin-bottom: 24px;">
                            <label>Short Description</label>
                            <input type="text" class="settings-input" placeholder="Optional brief..." />
                        </div>
                        <button class="settings-btn-primary" style="width: 100%;">ADD TO TAXONOMY</button>
                    </div>

                    <!-- Listed Categories -->
                    <div class="settings-card">
                        <div class="settings-card-title">Active Index</div>
                        <table class="settings-table">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Items</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Busana Desainer</strong></td>
                                    <td style="color: var(--text-secondary);">42 items</td>
                                    <td style="text-align: right;">
                                        <i class="ph ph-trash action-icon danger"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Kostum Karnaval</strong></td>
                                    <td style="color: var(--text-secondary);">18 items</td>
                                    <td style="text-align: right;">
                                        <i class="ph ph-trash action-icon danger"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Gowns & Evening</strong></td>
                                    <td style="color: var(--text-secondary);">0 items</td>
                                    <td style="text-align: right;">
                                        <i class="ph ph-trash action-icon danger"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.settings-nav-item');
        const panes = document.querySelectorAll('.settings-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                // Add active class to clicked tab
                tab.classList.add('active');

                // Hide all panes
                panes.forEach(p => p.classList.remove('active'));
                
                // Show matching pane
                const targetId = tab.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');
            });
        });
    });
</script>
