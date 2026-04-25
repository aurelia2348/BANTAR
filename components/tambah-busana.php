<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_busana'])) {
    $id_designer = (int)($_POST['id_designer'] ?? 0);
    
    // Ambil full_name dari tabel users berdasarkan id_designer
    $res_user = mysqli_query($koneksi, "SELECT full_name FROM users WHERE id = $id_designer");
    $user_data = mysqli_fetch_assoc($res_user);
    $nama_designer = mysqli_real_escape_string($koneksi, $user_data['full_name'] ?? '');

    $nama_kostum = mysqli_real_escape_string($koneksi, $_POST['nama_kostum'] ?? '');
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori'] ?? '');
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi'] ?? '');
    $rental_price = preg_replace("/[^0-9]/", "", $_POST['rental_price'] ?? '0');
    $rental_model_price = preg_replace("/[^0-9]/", "", $_POST['rental_model_price'] ?? '0');
    $jumlah = (int)($_POST['jumlah'] ?? 0);

    $gambar_path = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $upload_dir = 'assets/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_name = time() . '-' . basename($_FILES['gambar']['name']);
        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambar_path = $target_file;
        }
    }

    $sql = "INSERT INTO stok_kostum (id_designer, nama_designer, nama_kostum, kategori, deskripsi, rental_price, rental_model_price, jumlah, gambar) 
            VALUES ('$id_designer', '$nama_designer', '$nama_kostum', '$kategori', '$deskripsi', '$rental_price', '$rental_model_price', '$jumlah', '$gambar_path')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Busana berhasil diarsipkan!'); window.location.href='index.php?page=archive';</script>";
    } else {
        echo "<script>alert('Gagal mengarsipkan: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
<div class="ds-content">
  <div class="busana-top-container">
     <div class="busana-title-area">
        <span class="busana-label">ARCHIVE SUBMISSION</span>
        <h1 class="busana-main-title">Master <span class="busana-gold-italic">Curation</span></h1>
     </div>
     <div class="busana-quote-area">
        "Every garment is a story whispered in silk and structure. Documenting the atelier's legacy with surgical precision."
     </div>
  </div>

  <form id="formTambahBusana" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="submit_busana" value="1">
  <div class="busana-grid">
     <!-- Left: Form Fields -->
     <div class="busana-form">
          <div class="busana-row-2">
              <div class="busana-field">
                  <label>DESIGNER NAME <span style="color:#F44336">*</span></label>
                  <div class="busana-input-wrapper">
                      <select name="id_designer" id="designerId" onchange="validateBusanaInput(this, 'errDesigner')">
                          <option value="">Select Designer</option>
                          <?php
                          $query_users = mysqli_query($koneksi, "SELECT id, full_name FROM users ORDER BY full_name ASC");
                          while ($user = mysqli_fetch_assoc($query_users)) {
                              echo "<option value='{$user['id']}'>{$user['full_name']}</option>";
                          }
                          ?>
                      </select>
                      <i class="ph-fill ph-caret-down"></i>
                  </div>
                  <div id="errDesigner" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama desainer wajib diisi!</div>
              </div>
              <div class="busana-field">
                  <label>CATEGORY</label>
                  <div class="busana-input-wrapper">
                      <select name="kategori" id="kategoriSelect" onchange="toggleModelPrice(this.value)">
                          <option value="busana_desainer">Busana Desainer</option>
                          <option value="kostum_karnaval">Kostum Karnaval</option>
                      </select>
                      <i class="ph-fill ph-caret-down"></i>
                  </div>
              </div>
          </div>
          
          <div class="busana-field mt-32">
              <label>COSTUME NAME <span style="color:#F44336">*</span></label>
              <input type="text" name="nama_kostum" id="costumeName" class="busana-big-input" placeholder="e.g. Midnight Onyx Serenade" oninput="validateBusanaInput(this, 'errCostume')" />
              <div id="errCostume" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama kostum wajib diisi!</div>
          </div>

          <div class="mt-32" id="priceGrid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px;">
              <div class="busana-field">
                  <label>RENTAL PRICE (RP) <span style="color:#F44336">*</span></label>
                  <input type="text" name="rental_price" id="rentalPrice" class="busana-big-input" style="font-size: 16px; padding: 12px;" placeholder="e.g. 2500000" />
              </div>
              <div class="busana-field" id="wrapModelPrice">
                  <label>RENTAL MODEL PRICE (RP) <span style="color:#F44336">*</span></label>
                  <input type="text" name="rental_model_price" id="rentalModelPrice" class="busana-big-input" style="font-size: 16px; padding: 12px;" placeholder="e.g. 3500000" />
              </div>
              <div class="busana-field">
                  <label>STOCK COUNT <span style="color:#F44336">*</span></label>
                  <div class="busana-input-wrapper">
                      <input type="number" name="jumlah" id="stockCount" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; color: #fff; outline: none; font-size: 16px;" placeholder="e.g. 5" />
                  </div>
              </div>
          </div>

          <div class="busana-field mt-32">
              <label style="display: flex; justify-content: space-between; align-items: center;">
                  <span>COSTUME PHILOSOPHY <span style="color:#F44336">*</span></span>
                  <span id="charCount" style="font-weight: normal; color: var(--text-secondary); text-transform: none; letter-spacing: 0.5px;">0/1000 characters</span>
              </label>
              <textarea name="deskripsi" id="costumeDesc" class="busana-textarea" maxlength="1000" placeholder="The narrative soul of this creation..." oninput="validateBusanaInput(this, 'errDesc')"></textarea>
              <div id="errDesc" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Filosofi/Deskripsi kostum wajib diisi!</div>
          </div>

          <div class="busana-actions mt-48">
              <button type="button" id="btnSubmitBusana" class="ds-btn-primary-large" style="width: auto; padding: 14px 32px; font-size: 10px;" onclick="submitBusanaForm()">ARCHIVE GARMENT</button>
              <button type="button" class="busana-btn-text" onclick="window.location.href='index.php?page=archive'">DISCARD DRAFT</button>
          </div>
     </div>
     
     <!-- Right: Image Upload -->
     <div class="busana-sidebar">
          <label class="busana-label" style="color: var(--text-secondary);">IMAGE ARCHIVE PORTFOLIO</label>
          <div class="busana-upload-box" onclick="document.getElementById('busanaUpload').click()" style="cursor: pointer;">
              <input type="file" name="gambar" id="busanaUpload" accept="image/*" style="display: none;" onchange="handleImageUpload(event)">
              <i class="ph-fill ph-cloud-arrow-up busana-upload-icon"></i>
              <h4>Visual Captures</h4>
              <p>Upload high-resolution editorial photography of the garment.</p>
              <button type="button" class="busana-btn-outline" onclick="event.stopPropagation(); document.getElementById('busanaUpload').click();">BROWSE FILES</button>
          </div>
          <div class="busana-image-previews" id="imagePreviewContainer">
              <div class="busana-add-more" onclick="document.getElementById('busanaUpload').click()">
                   <i class="ph ph-plus"></i>
              </div>
          </div>
          <div class="busana-tip-box">
              <i class="ph-fill ph-info"></i>
              <div>
                  <h5>CURATION TIP</h5>
                  <p>Archive images should be at least 3000px on the longest side for high-fidelity zoom in the master catalog.</p>
              </div>
          </div>
     </div>
  </div>
  </form>

</div>

<script>
    function toggleModelPrice(kategori) {
        const wrap = document.getElementById('wrapModelPrice');
        const grid = document.getElementById('priceGrid');
        const inp  = document.getElementById('rentalModelPrice');
        if (kategori === 'kostum_karnaval') {
            wrap.style.display = '';
            grid.style.gridTemplateColumns = '1fr 1fr 1fr';
            inp.name = 'rental_model_price';
        } else {
            wrap.style.display = 'none';
            grid.style.gridTemplateColumns = '1fr 1fr';
            inp.value = '0';
            inp.name  = 'rental_model_price'; // still submitted as 0
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const textareas = document.querySelectorAll('.busana-textarea');
        textareas.forEach(textarea => {
            textarea.style.overflow = 'hidden'; 
            const resize = () => {
                textarea.style.height = '60px'; // Reset to base height to allow shrinking
                textarea.style.height = textarea.scrollHeight + 'px';
            };
            textarea.addEventListener('input', resize);
            resize(); // Run once on load
        });

        // Initialize Character Counter
        const descArea = document.getElementById('costumeDesc');
        const charCount = document.getElementById('charCount');
        if (descArea && charCount) {
            const updateCount = () => {
                charCount.innerText = descArea.value.length + '/1000 characters';
            };
            descArea.addEventListener('input', updateCount);
            updateCount(); // Run once on load
        }

        // Run toggle on load to match default selected category
        const sel = document.getElementById('kategoriSelect');
        if (sel) toggleModelPrice(sel.value);
    });

    function handleImageUpload(event) {
        const files = event.target.files;
        const container = document.getElementById('imagePreviewContainer');
        const addMoreBtn = container.querySelector('.busana-add-more');
        
        // Bersihkan preview sebelumnya agar sinkron dengan input file 
        const existingImgs = container.querySelectorAll('img');
        existingImgs.forEach(img => img.remove());
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!file.type.match('image.*')) continue;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Uploaded Image';
                
                // Insert before the generic add (+) button
                container.insertBefore(img, addMoreBtn);
            };
            reader.readAsDataURL(file);
        }
    }

    function validateBusanaInput(inputEl, errId) {
        const errMsg = document.getElementById(errId);
        let errorText = '';
        const val = inputEl.value;

        if (!val.trim()) {
            errorText = 'Wajib diisi!';
        }

        if (errorText) {
            inputEl.style.borderBottomColor = '#F44336';
            if (errMsg) {
                errMsg.innerText = errorText;
                errMsg.style.display = 'block';
            }
            inputEl.classList.add('invalid-input');
        } else {
            inputEl.style.borderBottomColor = ''; // Reset CSS to generic
            if (errMsg) errMsg.style.display = 'none';
            inputEl.classList.remove('invalid-input');
        }
    }

    function submitBusanaForm() {
        const dId = document.getElementById('designerId');
        const cName = document.getElementById('costumeName');
        const cDesc = document.getElementById('costumeDesc');
        let valid = true;

        [ {el: dId, err: 'errDesigner'}, {el: cName, err: 'errCostume'}, {el: cDesc, err: 'errDesc'} ].forEach(item => {
            validateBusanaInput(item.el, item.err);
            if (item.el.classList.contains('invalid-input')) {
                valid = false;
            }
        });

        if (valid) {
            const btn = document.getElementById('btnSubmitBusana');
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> ARCHIVING...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';

            // Submit form
            setTimeout(() => {
                document.getElementById('formTambahBusana').submit();
            }, 500);
        }
    }
</script>
