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

  <div class="busana-grid">
     <!-- Left: Form Fields -->
     <div class="busana-form">
          <div class="busana-row-2">
              <div class="busana-field">
                  <label>DESIGNER NAME <span style="color:#F44336">*</span></label>
                  <div class="busana-input-wrapper">
                      <input type="text" id="designerName" value="Elena Vanhoutte" oninput="validateBusanaInput(this, 'errDesigner')" />
                      <i class="ph ph-scribble-loop" style="transform: translateY(-50%) rotate(-15deg);"></i>
                  </div>
                  <div id="errDesigner" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama desainer wajib diisi!</div>
              </div>
              <div class="busana-field">
                  <label>CATEGORY</label>
                  <div class="busana-input-wrapper">
                      <select name="category">
                          <option value="busana_desainer">Busana Desainer</option>
                          <option value="kostum_karnaval">Kostum Karnaval</option>
                      </select>
                      <i class="ph-fill ph-caret-down"></i>
                  </div>
              </div>
          </div>
          
          <div class="busana-field mt-32">
              <label>COSTUME NAME <span style="color:#F44336">*</span></label>
              <input type="text" id="costumeName" class="busana-big-input" placeholder="e.g. Midnight Onyx Serenade" oninput="validateBusanaInput(this, 'errCostume')" />
              <div id="errCostume" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Nama kostum wajib diisi!</div>
          </div>

          <div class="busana-field mt-32">
              <label style="display: flex; justify-content: space-between; align-items: center;">
                  <span>COSTUME PHILOSOPHY <span style="color:#F44336">*</span></span>
                  <span id="charCount" style="font-weight: normal; color: var(--text-secondary); text-transform: none; letter-spacing: 0.5px;">0/1000 characters</span>
              </label>
              <textarea id="costumeDesc" class="busana-textarea" maxlength="1000" placeholder="The narrative soul of this creation..." oninput="validateBusanaInput(this, 'errDesc')"></textarea>
              <div id="errDesc" class="ds-error-msg" style="display:none; color:#F44336; font-size:9px; margin-top:4px;">Filosofi/Deskripsi kostum wajib diisi!</div>
          </div>

          <div class="busana-actions mt-48">
              <button id="btnSubmitBusana" class="ds-btn-primary-large" style="width: auto; padding: 14px 32px; font-size: 10px;" onclick="submitBusanaForm()">ARCHIVE GARMENT</button>
              <button class="busana-btn-text" onclick="window.location.href='index.php?page=archive'">DISCARD DRAFT</button>
          </div>
     </div>
     
     <!-- Right: Image Upload -->
     <div class="busana-sidebar">
          <label class="busana-label" style="color: var(--text-secondary);">IMAGE ARCHIVE PORTFOLIO</label>
          <div class="busana-upload-box" onclick="document.getElementById('busanaUpload').click()" style="cursor: pointer;">
              <input type="file" id="busanaUpload" multiple accept="image/*" style="display: none;" onchange="handleImageUpload(event)">
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

</div>

<script>
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
    });

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
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> ARCHIVING...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';

            // Simulate server lag then redirect
            setTimeout(() => {
                window.location.href = 'index.php?page=archive';
            }, 1000);
        }
    }
</script>
