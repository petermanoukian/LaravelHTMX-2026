<script>
function toggleAdd() {
    const add = document.getElementById('add');
    add.classList.toggle('d-none');

    if (!add.classList.contains('d-none')) {
        htmx.process(add);
        add.scrollIntoView({ behavior: 'smooth' });
    }
}

function bulkDelete() {
    const ids = Array.from(document.querySelectorAll('.checkbox:checked')).map(cb => cb.value);
    if (ids.length > 0 && confirm('Are you sure you want to delete selected subcategories?')) {
        fetch('{{ route("admin.subcat.destroyAll") }}', {
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
            const viewlist = document.getElementById('viewlist');
            viewlist.innerHTML = html;
            htmx.process(viewlist);
        });
    }
}

function updateBulkDeleteBtn() {
    const anyChecked = document.querySelectorAll('.checkbox:checked').length > 0;
    const btn = document.getElementById('bulkDeleteBtn');
    if (btn) btn.classList.toggle('d-none', !anyChecked);
}

function toggleSelectAll(checkbox) {
    document.querySelectorAll('.checkbox').forEach(cb => cb.checked = checkbox.checked);
    updateBulkDeleteBtn();
}

// HTMX loader indicator
document.body.addEventListener('htmx:beforeRequest', function(evt) {
    evt.detail.target.classList.add('loading');
});

document.body.addEventListener('htmx:afterRequest', function(evt) {
    const target = evt.detail.target;
    target.classList.remove('loading');

    if (evt.detail.verb && evt.detail.verb.toUpperCase() === 'POST') {
        if (target.id === 'viewlist' || target.id === 'edit') {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    }

    const add = document.getElementById('add');
    const addForm = add ? add.querySelector('form') : null;
    if (addForm && evt.detail.target.id === 'viewlist') {
        addForm.reset();
        add.classList.add('d-none');
    }

    const edit = document.getElementById('edit');
    if (evt.detail.target.id === 'edit') {
        edit.classList.remove('d-none');
        edit.scrollIntoView({ behavior: 'smooth' });
    }

    const editForm = edit ? edit.querySelector('form') : null;
    if (editForm && evt.detail.target.id === 'viewlist') {
        editForm.reset();
        edit.classList.add('d-none');
    }

    if (evt.detail.target.id === 'viewlist') {
        const selectAll = document.getElementById('selectAll');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

        function getCheckboxes() {
            return document.querySelectorAll('.checkbox');
        }

        function updateBulkDeleteBtn() {
            const anyChecked = Array.from(getCheckboxes()).some(cb => cb.checked);
            bulkDeleteBtn.classList.toggle('d-none', !anyChecked);
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                getCheckboxes().forEach(cb => cb.checked = selectAll.checked);
                updateBulkDeleteBtn();
            });
        }

        document.addEventListener('change', function(evt) {
            if (evt.target.classList.contains('checkbox')) {
                updateBulkDeleteBtn();
            }
        });
    }
});

document.body.addEventListener('htmx:afterSwap', function(evt) {
    const target = evt.detail.target;
    target.classList.remove('loading');

    if (target.id === 'viewlist') {
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.checkbox').forEach(cb => {
                    cb.checked = selectAll.checked;
                });
                updateBulkDeleteBtn();
            });
        }

        document.querySelectorAll('.checkbox').forEach(cb => {
            cb.addEventListener('change', updateBulkDeleteBtn);
        });

        updateBulkDeleteBtn();
        htmx.process(target);
        target.scrollIntoView({ behavior: 'smooth' });

        const add = document.getElementById('add');
        if (add) {
            const addForm = add.querySelector('form');
            if (addForm) addForm.reset();
            add.classList.add('d-none');
        }

        const edit = document.getElementById('edit');
        if (edit) {
            const editForm = edit.querySelector('form');
            if (editForm) editForm.reset();
            edit.classList.add('d-none');
        }
    }

    if (target.id === 'edit') {
        target.classList.remove('d-none');
        target.scrollIntoView({ behavior: 'smooth' });
    }
});

function returnToPage1() {
    document.body.addEventListener('htmx:afterRequest', function(evt) {
        if (evt.detail.verb && evt.detail.verb.toUpperCase() !== 'GET') {
            const firstPageLink = document.getElementById('page1');
            if (firstPageLink) {
                setTimeout(function() {
                    firstPageLink.click();
                }, 500);
            }
        }
    });

    setTimeout(function() {
        const firstPageLink = document.getElementById('page1');
        if (firstPageLink) {
            firstPageLink.click();
        }
    }, 700);
}

document.body.addEventListener('htmx:afterRequest', function(evt) {
    if (evt.detail.target.id === 'name-validationadd') {
        try {
            const response = JSON.parse(evt.detail.xhr.responseText);
            const input = document.getElementById('name');
            const msg = document.getElementById('name-validationadd');
            msg.textContent = response.message || '';
            if (response.valid === false) {
                input.value = '';
                input.setCustomValidity("Name already taken.");
            } else {
                input.setCustomValidity("");
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
                input.setCustomValidity("Name already taken.");
            } else {
                input.setCustomValidity("");
            }
        } catch (e) {
            console.error('Validation parse error (update)', e);
        }
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script> 
    document.addEventListener('DOMContentLoaded', function () 
    { new Choices('.searchable', { searchEnabled: true, itemSelectText: '', }); }); 
 
    document.addEventListener('DOMContentLoaded', function () {
        // Initial load
        initChoices();

        // Re-init after HTMX content swap
        document.body.addEventListener('htmx:afterSwap', function(evt) {
            initChoices();
        });
    });

    function initChoices() {
        document.querySelectorAll('.searchable').forEach(function(el) {
            if (!el.dataset.choicesInit) {
                new Choices(el, {
                    searchEnabled: true,
                    itemSelectText: '',
                });
                el.dataset.choicesInit = "true"; // mark as initialized
            }
        });
    }
</script>