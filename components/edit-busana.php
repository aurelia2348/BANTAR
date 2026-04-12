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

  <div class="busana-grid">
     <!-- Left: Form Fields -->
     <div class="busana-form">
          <div class="busana-row-2">
              <div class="busana-field">
                  <label>DESIGNER NAME <span style="color:#F44336">*</span></label>
                  <div class="busana-input-wrapper">
                      <input type="text" id="designerName" value="Bara Exclusives" oninput="validateBusanaInput(this, 'errDesigner')" />
                      <i class="ph ph-scribble-loop" style="transform: translateY(-50%) rotate(-15deg);"></i>
                  </div>
                  <div id="errDesigner" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama desainer wajib diisi!</div>
              </div>
              <div class="busana-field">
                  <label>CATEGORY</label>
                  <div class="busana-input-wrapper">
                      <select name="category">
                          <option value="busana_desainer" selected>Busana Desainer</option>
                          <option value="kostum_karnaval">Kostum Karnaval</option>
                      </select>
                      <i class="ph-fill ph-caret-down"></i>
                  </div>
              </div>
          </div>
          
          <div class="busana-field mt-32">
              <label>COSTUME NAME <span style="color:#F44336">*</span></label>
              <input type="text" id="costumeName" class="busana-big-input" value="Midnight Structure" placeholder="e.g. Midnight Onyx Serenade" oninput="validateBusanaInput(this, 'errCostume')" />
              <div id="errCostume" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama kostum wajib diisi!</div>
          </div>

          <div class="busana-row-2 mt-32">
              <div class="busana-field">
                  <label>RENTAL PRICE (RP) <span style="color:#F44336">*</span></label>
                  <input type="text" id="rentalPrice" class="busana-big-input" style="font-size: 16px; padding: 12px;" value="2.500.000" placeholder="e.g. 2500000" />
              </div>
              <div class="busana-field">
                  <label>STOCK COUNT <span style="color:#F44336">*</span></label>
                  <div class="busana-input-wrapper">
                      <input type="number" id="stockCount" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; color: #fff; outline: none; font-size: 16px;" value="5" />
                  </div>
              </div>
          </div>

          <div class="busana-field mt-32">
              <label>COSTUME PHILOSOPHY <span style="color:#F44336">*</span></label>
              <textarea id="costumeDesc" class="busana-textarea" placeholder="The narrative soul of this creation..." oninput="validateBusanaInput(this, 'errDesc')">Sebuah mahakarya Haute Couture dari Bara Exclusives. Menyatukan tekstur velvet kelam dengan kerangka struktur emas yang tersembunyi. Sangat populer untuk sesi pemotretan bertema Gothic dan Met Gala.</textarea>
              <div id="errDesc" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Filosofi/Deskripsi kostum wajib diisi!</div>
          </div>

          <div class="busana-actions mt-48">
              <button id="btnSubmitBusana" class="ds-btn-primary-large" style="width: auto; padding: 14px 32px; font-size: 10px;" onclick="submitBusanaForm()">UPDATE GARMENT DETAILS</button>
              <button class="busana-btn-text" onclick="window.location.href='index.php?page=archive'">CANCEL EDIT</button>
          </div>
     </div>
     
     <!-- Right: Image Upload -->
     <div class="busana-sidebar">
          <label class="busana-label" style="color: var(--text-secondary);">IMAGE ARCHIVE PORTFOLIO</label>
          <div class="busana-upload-box" onclick="document.getElementById('busanaUpload').click()" style="cursor: pointer;">
              <input type="file" id="busanaUpload" multiple accept="image/*" style="display: none;" onchange="handleImageUpload(event)">
              <i class="ph-fill ph-cloud-arrow-up busana-upload-icon"></i>
              <h4>Update Visuals</h4>
              <p>Upload new high-resolution images to replace or append to existing visuals.</p>
              <button type="button" class="busana-btn-outline" onclick="event.stopPropagation(); document.getElementById('busanaUpload').click();">BROWSE FILES</button>
          </div>
          <div class="busana-image-previews" id="imagePreviewContainer">
              <img src="assets/catalog_1.png" alt="Existing Image" style="width: 100%; aspect-ratio: 4/5; object-fit: cover; border-radius: 4px;">
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
    function handleImageUpload(event) {
        const files = event.target.files;
        const container = document.getElementById('imagePreviewContainer');
        const addMoreBtn = container.querySelector('.busana-add-more');
        
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
        
        // Reset the input so the same files can be selected again if needed
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
        const dName = document.getElementById('designerName');
        const cName = document.getElementById('costumeName');
        const cDesc = document.getElementById('costumeDesc');
        let valid = true;

        [ {el: dName, err: 'errDesigner'}, {el: cName, err: 'errCostume'}, {el: cDesc, err: 'errDesc'} ].forEach(item => {
            validateBusanaInput(item.el, item.err);
            if (item.el.classList.contains('invalid-input')) {
                valid = false;
            }
        });

        if (valid) {
            const btn = document.getElementById('btnSubmitBusana');
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> UPDATING...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';

            // Simulate server lag then redirect
            setTimeout(() => {
                window.location.href = 'index.php?page=archive';
            }, 1000);
        }
    }
</script>
