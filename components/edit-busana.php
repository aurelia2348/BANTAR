<?php
require_once __DIR__ . '/../koneksi.php';

// Fetch item by ID from URL
$edit_id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$item      = null;

if ($edit_id > 0) {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM stok_kostum WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $edit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $item   = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Fallback values (empty) if no item found
$v_designer  = htmlspecialchars($item['nama_designer']    ?? '');
$v_nama      = htmlspecialchars($item['nama_kostum']      ?? '');
$v_kategori  = $item['kategori'] ?? 'Busana Desainer';
$v_desc      = htmlspecialchars($item['deskripsi']        ?? '');
$v_price     = $item ? number_format((float)$item['rental_price'],       0, ',', '.') : '';
$v_modprice  = $item ? number_format((float)$item['rental_model_price'], 0, ',', '.') : '';
$v_jumlah    = $item['jumlah'] ?? 0;
$v_gambar    = !empty($item['gambar']) ? htmlspecialchars($item['gambar']) : 'assets/catalog_1.png';

// Determine selected option
$opt_desainer = ($v_kategori === 'Busana Desainer') ? 'selected' : '';
$opt_karnaval = ($v_kategori === 'Kostum Karnaval') ? 'selected' : '';
?>
<div class="ds-content">
  <div class="busana-top-container">
     <div class="busana-title-area">
        <span class="busana-label">ARCHIVE MODIFICATION</span>
        <h1 class="busana-main-title">Edit <span class="busana-gold-italic">Garment</span></h1>
     </div>
     <div class="busana-quote-area">
        "Refining the details of our legacy. Ensure all modifications reflect the true nature of the current garment state."
     </div>
  </div>

  <?php if (!$item && $edit_id > 0): ?>
  <div style="color:#F44336; margin-bottom: 24px; font-size: 13px;">
      ⚠ Item dengan ID <?= $edit_id ?> tidak ditemukan dalam database.
  </div>
  <?php endif; ?>

  <div class="busana-grid">
     <!-- Left: Form Fields -->
     <div class="busana-form">
          <div class="busana-row-2">
              <div class="busana-field">
                  <label>DESIGNER NAME <span style="color:#F44336">*</span></label>
                  <div class="busana-input-wrapper">
                      <input type="text" id="designerName" value="<?= $v_designer ?>" oninput="validateBusanaInput(this, 'errDesigner')" />
                      <i class="ph ph-scribble-loop" style="transform: translateY(-50%) rotate(-15deg);"></i>
                  </div>
                  <div id="errDesigner" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama desainer wajib diisi!</div>
              </div>
              <div class="busana-field">
                  <label>CATEGORY</label>
                  <div class="busana-input-wrapper">
                      <select id="categorySelect" name="category" onchange="toggleModelPrice(this.value)">
                          <option value="Busana Desainer" <?= $opt_desainer ?>>Busana Desainer</option>
                          <option value="Kostum Karnaval" <?= $opt_karnaval ?>>Kostum Karnaval</option>
                      </select>
                      <i class="ph-fill ph-caret-down"></i>
                  </div>
              </div>
          </div>
          
          <div class="busana-field mt-32">
              <label>COSTUME NAME <span style="color:#F44336">*</span></label>
              <input type="text" id="costumeName" class="busana-big-input" value="<?= $v_nama ?>" placeholder="e.g. Midnight Onyx Serenade" oninput="validateBusanaInput(this, 'errCostume')" />
              <div id="errCostume" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama kostum wajib diisi!</div>
          </div>

          <div class="mt-32" id="priceGrid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px;">
              <div class="busana-field">
                  <label>RENTAL PRICE (RP) <span style="color:#F44336">*</span></label>
                  <input type="text" id="rentalPrice" class="busana-big-input" style="font-size: 16px; padding: 12px;" value="<?= $v_price ?>" placeholder="e.g. 2.500.000" />
              </div>
              <div class="busana-field" id="wrapModelPrice">
                  <label>RENTAL MODEL PRICE (RP) <span style="color:#F44336">*</span></label>
                  <input type="text" id="rentalModelPrice" class="busana-big-input" style="font-size: 16px; padding: 12px;" value="<?= $v_modprice ?>" placeholder="e.g. 3.500.000" />
              </div>
              <div class="busana-field">
                  <label>STOCK COUNT <span style="color:#F44336">*</span></label>
                  <div class="busana-input-wrapper">
                      <input type="number" id="stockCount" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; color: #fff; outline: none; font-size: 16px;" value="<?= $v_jumlah ?>" />
                  </div>
              </div>
          </div>

          <div class="busana-field mt-32">
              <label style="display: flex; justify-content: space-between; align-items: center;">
                  <span>COSTUME PHILOSOPHY <span style="color:#F44336">*</span></span>
                  <span id="charCount" style="font-weight: normal; color: var(--text-secondary); text-transform: none; letter-spacing: 0.5px;">0/1000 characters</span>
              </label>
              <textarea id="costumeDesc" class="busana-textarea" maxlength="1000" placeholder="The narrative soul of this creation..." oninput="validateBusanaInput(this, 'errDesc')"><?= $v_desc ?></textarea>
              <div id="errDesc" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Filosofi/Deskripsi kostum wajib diisi!</div>
          </div>

          <div class="busana-actions mt-48">
              <button id="btnSubmitBusana" class="ds-btn-primary-large" style="width: auto; padding: 14px 32px; font-size: 10px;" onclick="submitEditForm()">UPDATE GARMENT DETAILS</button>
              <button class="busana-btn-text" onclick="window.location.href='index.php?page=archive'">CANCEL EDIT</button>
          </div>
     </div>
     
     <!-- Right: Image Upload -->
     <div class="busana-sidebar">
          <label class="busana-label" style="color: var(--text-secondary);">IMAGE ARCHIVE PORTFOLIO</label>
          <div class="busana-upload-box" onclick="document.getElementById('busanaUpload').click()" style="cursor: pointer;">
              <input type="file" id="busanaUpload" accept="image/*" style="display: none;" onchange="handleImageUpload(event)">
              <i class="ph-fill ph-cloud-arrow-up busana-upload-icon"></i>
              <h4>Update Visuals</h4>
              <p>Upload new high-resolution images to replace or append to existing visuals.</p>
              <button type="button" class="busana-btn-outline" onclick="event.stopPropagation(); document.getElementById('busanaUpload').click();">BROWSE FILES</button>
          </div>
          <div class="busana-image-previews" id="imagePreviewContainer">
              <img id="existingPreview" src="<?= $v_gambar ?>" alt="Existing Image" style="width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 4px;">
              <div class="busana-add-more" onclick="document.getElementById('busanaUpload').click()">
                   <i class="ph ph-plus"></i>
              </div>
          </div>
          <div class="busana-tip-box">
              <i class="ph-fill ph-info"></i>
              <div>
                  <h5>CURATION TIP</h5>
                  <p>Keeping catalog images updated ensures that clients see the actual condition of the rented garments.</p>
              </div>
          </div>
     </div>
  </div>

</div>

<script>
const EDIT_ID = <?= $edit_id ?: 'null' ?>;

document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('.busana-textarea');
    textareas.forEach(textarea => {
        textarea.style.overflow = 'hidden'; 
        const resize = () => {
            textarea.style.height = '60px';
            textarea.style.height = textarea.scrollHeight + 'px';
        };
        textarea.addEventListener('input', resize);
        resize();
    });

    // Initialize Character Counter
    const descArea  = document.getElementById('costumeDesc');
    const charCount = document.getElementById('charCount');
    if (descArea && charCount) {
        const updateCount = () => charCount.innerText = descArea.value.length + '/1000 characters';
        descArea.addEventListener('input', updateCount);
        updateCount();
    }

    // Apply visibility toggle on load based on saved category
    const sel = document.getElementById('categorySelect');
    if (sel) toggleModelPrice(sel.value);
});

function toggleModelPrice(kategori) {
    const wrap = document.getElementById('wrapModelPrice');
    const grid = document.getElementById('priceGrid');
    const inp  = document.getElementById('rentalModelPrice');
    const isKarnaval = (kategori === 'Kostum Karnaval');
    wrap.style.display             = isKarnaval ? '' : 'none';
    grid.style.gridTemplateColumns = isKarnaval ? '1fr 1fr 1fr' : '1fr 1fr';
    if (!isKarnaval) inp.value = '0';
}

let newImageFile = null;

function handleImageUpload(event) {
    const file = event.target.files[0];
    if (!file || !file.type.match('image.*')) return;

    newImageFile = file;

    const reader = new FileReader();
    reader.onload = function(e) {
        // Update the existing preview in-place
        const preview = document.getElementById('existingPreview');
        if (preview) preview.src = e.target.result;
    };
    reader.readAsDataURL(file);
    event.target.value = '';
}

function validateBusanaInput(inputEl, errId) {
    const errMsg = document.getElementById(errId);
    let errorText = '';
    const val = inputEl.value;

    if (!val.trim()) {
        errorText = 'Wajib diisi!';
    } else if (inputEl.id === 'designerName' && /\d/.test(val)) {
        errorText = 'Nama desainer tidak boleh mengandung angka!';
    }

    if (errorText) {
        inputEl.style.borderBottomColor = '#F44336';
        if (errMsg) { errMsg.innerText = errorText; errMsg.style.display = 'block'; }
        inputEl.classList.add('invalid-input');
    } else {
        inputEl.style.borderBottomColor = '';
        if (errMsg) errMsg.style.display = 'none';
        inputEl.classList.remove('invalid-input');
    }
}

function submitEditForm() {
    if (!EDIT_ID) {
        alert('ID item tidak ditemukan. Kembali ke archive dan buka edit dari sana.');
        return;
    }

    const dName = document.getElementById('designerName');
    const cName = document.getElementById('costumeName');
    const cDesc = document.getElementById('costumeDesc');
    let valid = true;

    [{el: dName, err: 'errDesigner'}, {el: cName, err: 'errCostume'}, {el: cDesc, err: 'errDesc'}].forEach(item => {
        validateBusanaInput(item.el, item.err);
        if (item.el.classList.contains('invalid-input')) valid = false;
    });

    if (!valid) return;

    const btn = document.getElementById('btnSubmitBusana');
    btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> UPDATING...';
    btn.style.opacity      = '0.8';
    btn.style.pointerEvents = 'none';

    // Strip dots/commas from price (formatting) then send raw number
    const stripNum = v => v.replace(/\./g, '').replace(/,/g, '');

    const formData = new FormData();
    formData.append('_method',            'PUT');
    formData.append('id',                 EDIT_ID);
    formData.append('nama_designer',      dName.value.trim());
    formData.append('nama_kostum',        cName.value.trim());
    formData.append('kategori',           document.getElementById('categorySelect').value);
    formData.append('deskripsi',          cDesc.value.trim());
    formData.append('rental_price',       stripNum(document.getElementById('rentalPrice').value));
    formData.append('rental_model_price', stripNum(document.getElementById('rentalModelPrice').value));
    formData.append('jumlah',             document.getElementById('stockCount').value);
    if (newImageFile) formData.append('gambar', newImageFile);

    fetch('script/update_kostum.php', {
        method: 'POST',   // POST + _method=PUT override (multipart can't do real PUT)
        body:   formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'index.php?page=archive';
        } else {
            alert('Update gagal: ' + (data.message || 'Unknown error'));
            btn.innerHTML       = 'UPDATE GARMENT DETAILS';
            btn.style.opacity   = '1';
            btn.style.pointerEvents = 'auto';
        }
    })
    .catch(err => {
        alert('Terjadi kesalahan jaringan. Coba lagi.');
        btn.innerHTML       = 'UPDATE GARMENT DETAILS';
        btn.style.opacity   = '1';
        btn.style.pointerEvents = 'auto';
    });
}
</script>
