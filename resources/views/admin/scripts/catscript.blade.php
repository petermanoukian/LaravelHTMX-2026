<script>
function toggleAddCat() {
    const addCat = document.getElementById('addcat');
    //addCat.classList.toggle('d-none');

    if (!addCat.classList.contains('d-none')) {
       
        //htmx.process(addCat);
        addCat.scrollIntoView({ behavior: 'smooth' });
    }
}

function closeAddCat() {
    const addCat = document.getElementById('addcat');
    if (addCat && !addCat.classList.contains('d-none')) {
        //addCat.classList.add('d-none');
    }
}


function bulkDelete() {
    const ids = Array.from(document.querySelectorAll('.cat-checkbox:checked')).map(cb => cb.value);
    if (ids.length > 0 && confirm('Are you sure you want to delete selected categories?')) {
        fetch('{{ route("admin.cat.destroyAll") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'HX-Request': 'true'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.text())
        .then(html => {
            const viewcats = document.getElementById('viewcats');
            viewcats.innerHTML = html;
            htmx.process(viewcats); // ✅ This fixes the dead first click
        });
    }
}

function updateBulkDeleteBtn() {
    const anyChecked = document.querySelectorAll('.cat-checkbox:checked').length > 0;
    const btn = document.getElementById('bulkDeleteBtn');
    if (btn) btn.classList.toggle('d-none', !anyChecked);
}

function toggleSelectAll(checkbox) {
    document.querySelectorAll('.cat-checkbox').forEach(cb => cb.checked = checkbox.checked);
    updateBulkDeleteBtn();
}


// HTMX loader indicator
document.body.addEventListener('htmx:beforeRequest', function(evt) {
    const target = evt.detail.target;
    target.classList.add('loading');
});

document.body.addEventListener('htmx:afterRequest', function(evt) {
    const target = evt.detail.target;
    target.classList.remove('loading');
   
    // Scroll to the updated list
    if (evt.detail.verb && evt.detail.verb.toUpperCase() === 'POST') {
        if (target.id === 'viewcats' || target.id === 'editcat') {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    }

    // Reset and hide the addcat form after successful post
    const addCat = document.getElementById('addcat');
    const addForm = addCat.querySelector('form');
    if (addForm && evt.detail.target.id === 'viewcats') {
        addForm.reset(); // clears all fields including file inputs
        //addCat.classList.add('d-none'); // hide the form again
    }

    // 👇 NEW: scroll to editcat if it was the target
    const editCat = document.getElementById('editcat');
    if (evt.detail.target.id === 'editcat') {
        editCat.classList.remove('d-none'); // ✅ Remove d-none to show it
        editCat.scrollIntoView({ behavior: 'smooth' });
    }


    const editForm = editCat.querySelector('form');
    if (editForm && evt.detail.target.id === 'viewcats') {
        editForm.reset(); // clear fields
        //editCat.classList.add('d-none'); // hide the form again
    }


    if (evt.detail.target.id === 'viewcats') {
        const selectAll = document.getElementById('selectAll');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

        function getCheckboxes() {
            return document.querySelectorAll('.cat-checkbox');
        }

        function updateBulkDeleteBtn() {
            const anyChecked = Array.from(getCheckboxes()).some(cb => cb.checked);
            bulkDeleteBtn.classList.toggle('d-none', !anyChecked);
        }

        selectAll.addEventListener('change', function() {
            getCheckboxes().forEach(cb => cb.checked = selectAll.checked);
            updateBulkDeleteBtn();
        });

        document.addEventListener('change', function(evt) {
            if (evt.target.classList.contains('cat-checkbox')) {
                updateBulkDeleteBtn();
            }
        });
    }
});




document.body.addEventListener('htmx:afterSwap', function(evt) {
    const target = evt.detail.target;

    // Always remove loading class if it was added
    target.classList.remove('loading');

    if (target.id === 'viewcats') {
        console.log('viewcats swapped — re-initializing');

        // 1. Re-attach checkbox / select-all listeners
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.cat-checkbox').forEach(cb => {
                    cb.checked = selectAll.checked;
                });
                updateBulkDeleteBtn();
            });
        }

        document.querySelectorAll('.cat-checkbox').forEach(cb => {
            cb.addEventListener('change', updateBulkDeleteBtn);
        });

        updateBulkDeleteBtn();

        // 2. Re-activate ALL HTMX attributes in the new content (critical!)
        htmx.process(target);

        // 3. Reset URL to clean base path (no ?page=...)
        //history.replaceState(null, '', '{{ route("admin.cat.index") }}');

        target.scrollIntoView({ behavior: 'smooth' });

        const addCat = document.getElementById('addcat');
        if (addCat) {
            const addForm = addCat.querySelector('form');
            if (addForm) addForm.reset();
            //addCat.classList.add('d-none');

        }

        const editCat = document.getElementById('editcat');
        if (editCat) {
            const editForm = editCat.querySelector('form');
            if (editForm) editForm.reset();
            //editCat.classList.add('d-none');
            
        }
    }

    if (target.id === 'editcat') {
        //target.classList.remove('d-none');
        target.scrollIntoView({ behavior: 'smooth' });
    }
});

// Optional: also catch afterRequest for safety (some actions use fetch instead of htmx)
document.body.addEventListener('htmx:afterRequest', function(evt) {
    evt.detail.target.classList.remove('loading');
});


function returnToPage1(page = 1) {
    console.log("returnToPage called for page", page);

    // Close modals
    const addModalEl = document.getElementById('addCatModal');
    if (addModalEl) {
        const modal = bootstrap.Modal.getInstance(addModalEl) || new bootstrap.Modal(addModalEl);
        modal.hide();
    }

    const editModalEl = document.getElementById('editCatModal');
    if (editModalEl) {
        const modal = bootstrap.Modal.getInstance(editModalEl);
        if (modal) modal.hide();
    }

    // Full Reset with delay
    setTimeout(() => {
        // Reset Add Form
        const addForm = document.getElementById('addcat');
        if (addForm) {
            addForm.reset();
            
            // Clear image preview
            const previewAdd = document.getElementById('previewAdd');
            if (previewAdd) {
                previewAdd.classList.add('d-none');
                previewAdd.src = '';
            }

            // Clear Trumbowyg / WYSIWYG editors
            if (typeof $.trumbowyg !== 'undefined') {
                $('#des').trumbowyg('empty');
                $('#dess').trumbowyg('empty');
            } else {
                // Fallback if trumbowyg not loaded
                document.getElementById('des').value = '';
                document.getElementById('dess').value = '';
            }

            console.log("Add form fully reset (including preview + wysiwyg)");
        }

        // Reset Edit Form (if needed)
        const editForm = document.getElementById('editcat');
        if (editForm) {
            editForm.reset();
            // Add similar preview/wysiwyg clearing for edit if you have them
        }

        // Refresh the page
        const pageLink = document.getElementById('page' + page);
        if (pageLink) {
            pageLink.click();
        } else {
            const page1 = document.getElementById('page1');
            if (page1) page1.click();
        }
    }, 3000);
}



document.body.addEventListener('htmx:afterRequest', function(evt) {
    
    if (evt.detail.target.id === 'name-validationadd') {
        try {
            const response = JSON.parse(evt.detail.xhr.responseText);
            const input = document.getElementById('name');
            const msg = document.getElementById('name-validationadd');

            msg.textContent = response.message || '';

            // If name is taken → clear input and block submit
            if (response.valid === false) {
                input.value = '';
                input.setCustomValidity("Name already taken."); // prevents form submit
            } else {
                input.setCustomValidity(""); // reset so form can submit
            }
        } catch (e) {
            console.error('Validation parse error', e);
        }
    }

    if (evt.detail.target.id === 'name-validationupd') {
        try {
            const response = JSON.parse(evt.detail.xhr.responseText);
            const input = document.getElementById('nameupd');
            const msg = document.getElementById('name-validationupd');
            msg.textContent = response.message || '';

            if (response.valid === false) {
                input.value = '';
                input.setCustomValidity("Name already taken."); // block submit
            } else {
                input.setCustomValidity(""); // allow submit
            }
        } catch (e) {
            console.error('Validation parse error (update)', e);
        }
    }


});

function closeEditModal() {
    const modalEl = document.getElementById('editCatModal');
    if (modalEl) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }
}

// Also handle via trigger (backup)
document.body.addEventListener('htmx:trigger', function(evt) {
    if (evt.detail.trigger === 'closeEditModal') {
        closeEditModal();
    }
});


function deleteCategory(id) {
    if (!confirm('Are you sure you want to delete this category?')) {
        return;
    }

    htmx.ajax('DELETE', '/admin/cat/' + id, {   // ← Hardcode the URL pattern
        target: '#viewcats',
        swap: 'innerHTML',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    // Refresh current page after delete
    setTimeout(() => {
        refreshCurrentPage();
    }, 600);
}
function finishUpdate() {
    setTimeout(() => {
        // Close modal if open
        const editModal = document.getElementById('editCatModal');
        if (editModal) {
            bootstrap.Modal.getInstance(editModal)?.hide();
        }

        // Refresh current page
        refreshCurrentPage();
    }, 400);
}

function refreshCurrentPage() {
    const activePage = document.querySelector('.page-item.active a');
    if (activePage) {
        activePage.click();
    } else {
        const page1 = document.getElementById('page1');
        if (page1) page1.click();
    }
}
</script>

