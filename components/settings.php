<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $full_name = mysqli_real_escape_string($koneksi, $_POST['full_name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, full_name, email, password, role) VALUES ('$username', '$full_name', '$email', '$password', '$role')";
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('User berhasil ditambahkan!'); window.location.href='index.php?page=settings';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan user: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
<div class="ds-content">
    <div class="settings-container">
        <!-- Sidebar Tabs -->
        <div class="settings-sidebar">
            <ul class="settings-nav">
                <li class="settings-nav-item active" data-target="pane-users">
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
            
            <!-- Pane 2: User Management -->
            <div class="settings-pane active" id="pane-users">
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
                    <form method="POST" action="">
                        <div class="settings-form-row">
                            <div class="settings-field">
                                <label>Username</label>
                                <input type="text" name="username" class="settings-input" placeholder="e.g. aria_v" required />
                            </div>
                            <div class="settings-field">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="settings-input" placeholder="e.g. Aria Vanguard" required />
                            </div>
                            <div class="settings-field">
                                <label>Email Address</label>
                                <input type="email" name="email" class="settings-input" placeholder="aria@bantar.com" required />
                            </div> 
                        </div>
                        <div class="settings-form-row">
                            <div class="settings-field">
                                <label>System Role</label>
                                <select name="role" class="settings-input" style="appearance: none; cursor: pointer;" required>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Designer">Designer</option>
                                </select>
                            </div>
                            <div class="settings-field">
                                <label>Initial Password</label>
                                <input type="password" name="password" class="settings-input" placeholder="••••••••" required />
                            </div>
                        </div>
                        <button type="submit" name="create_user" class="settings-btn-primary">CREATE ACCOUNT</button>
                    </form>
                </div>

                <div class="settings-card">
                    <table class="settings-table">
                        <thead>
                            <tr>
                                <th>Identity</th>
                                <th>Email</th>
                                <th>Privilege Role</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $userQuery = "SELECT id, username, full_name, email, role FROM users ORDER BY id DESC";
                            $userResult = mysqli_query($koneksi, $userQuery);
                            if ($userResult && mysqli_num_rows($userResult) > 0) {
                                while ($u = mysqli_fetch_assoc($userResult)) {
                                    $fullName = htmlspecialchars($u['full_name']);
                                    $email = htmlspecialchars($u['email']);
                                    $roleStr = strtoupper($u['role']);
                                    
                                    // Generate Inisial Avatar (maks 2 huruf)
                                    $words = explode(" ", $fullName);
                                    $initials = "";
                                    foreach ($words as $w) {
                                        $w = trim($w);
                                        if (!empty($w)) {
                                            $initials .= strtoupper($w[0]);
                                        }
                                        if (strlen($initials) >= 2) break;
                                    }
                                    if (empty($initials)) $initials = "?";
                                    
                                    $roleClass = ($roleStr === 'ADMINISTRATOR') ? 'role-admin' : 'role-designer';
                                    $avatarStyle = ($roleStr === 'ADMINISTRATOR') ? '' : 'style="color: #fff;"';
                                    
                                    echo '<tr>';
                                    echo '    <td>';
                                    echo '        <div style="display: flex; align-items: center;">';
                                    echo '            <div class="user-avatar" '.$avatarStyle.'>'.$initials.'</div>';
                                    echo '            <strong>'.$fullName.'</strong>';
                                    echo '        </div>';
                                    echo '    </td>';
                                    echo '    <td style="color: var(--text-secondary);">'.$email.'</td>';
                                    echo '    <td><span class="role-badge '.$roleClass.'">'.$roleStr.'</span></td>';
                                    echo '    <td style="text-align: right;">';
                                    echo '        <i class="ph ph-pencil-simple action-icon"></i>';
                                    // Menampilkan tombol delete jika bukan Administrator utama
                                    if ($roleStr !== 'ADMINISTRATOR') {
                                        echo '        <i class="ph ph-trash action-icon danger"></i>';
                                    }
                                    echo '    </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" style="text-align:center;">No users registered yet.</td></tr>';
                            }
                            ?>
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
