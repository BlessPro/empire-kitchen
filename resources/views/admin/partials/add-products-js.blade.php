<script>
(function() {
  const modal     = document.getElementById('addProductModal');
  const form      = document.getElementById('addProductForm');
  const roLabel   = document.getElementById('apmProjectLabel');   // text label
  const roHidden  = document.getElementById('apmProjectHidden');  // hidden id

  const fldType = document.getElementById('apmType');
  const fldName = document.getElementById('apmName');
  const errBox  = document.getElementById('apmErr');
  const btnClose  = document.getElementById('apmClose');
  const btnCancel = document.getElementById('apmCancel');
  const csrf = '{{ csrf_token() }}';

  // Current contextual project (MUST be set before open)
  let ctxProjectId = null;
  let ctxProjectName = null;

  function openModal() {
    if (!ctxProjectId) {
      // Safety: guard against missing data attributes
      alert('No project context found for this action.');
      return;
    }
    // Fill the read-only display + hidden input
    roLabel.textContent = ctxProjectName || `Project #${ctxProjectId}`;
    roHidden.value = ctxProjectId;

    errBox?.classList.add('hidden');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
  }

  function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
    form?.reset();
    errBox?.classList.add('hidden');

    // keep ctxProjectId/Name; they’ll be overwritten on next trigger click anyway
  }

  // Open from menu item: REQUIRED data attributes
  document.addEventListener('click', (e) => {
    const a = e.target.closest('.add-product-trigger');
    if (!a) return;
    e.preventDefault();
    e.stopPropagation();

    ctxProjectId   = a.dataset.projectId ? Number(a.dataset.projectId) : null;
    ctxProjectName = a.dataset.projectName || null;

    // hide any “more” menus if you have them
    document.querySelectorAll('.more-menu').forEach(m => m.classList.add('hidden'));

    openModal();
  });

  btnClose?.addEventListener('click', closeModal);
  btnCancel?.addEventListener('click', closeModal);
  modal?.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
  });

  form?.addEventListener('submit', async (e) => {
    e.preventDefault();
    errBox?.classList.add('hidden');

    const payload = {
      project_id: ctxProjectId,                             // always from context
      product_type: String(fldType?.value || ''),
      name: (fldName?.value || '').trim() || null,
    };

    try {
      if (!payload.project_id) throw new Error('Project context is missing.');
      if (!payload.product_type) throw new Error('Please select a product type.');

      const res = await fetch(`{{ route('admin.products.quickCreate') }}`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrf,
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify(payload)
      });

      const txt = await res.text();
      if (!res.ok) {
        let msg = `HTTP ${res.status}`;
        try {
          const j = JSON.parse(txt);
          if (j?.errors) msg = Object.values(j.errors).flat().join('\n');
          else if (j?.message) msg = j.message;
          else msg = txt.slice(0, 500);
        } catch { msg = txt.slice(0, 500); }
        throw new Error(msg);
      }

      const j = JSON.parse(txt);
      if (!j?.ok || !j?.next_url) throw new Error('Unexpected response.');
      window.location = j.next_url; // Step 2 page

    } catch (err) {
      if (errBox) {
        errBox.textContent = err.message || 'Failed to create product.';
        errBox.classList.remove('hidden');
      }
    }
  });
})();
</script>
