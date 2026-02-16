<script>
        function previewImage(event, previewId) {
        const input = event.target;
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/trumbowyg/dist/trumbowyg.min.js"></script>
<script> 
    $('.dess').trumbowyg(); 
    $('.dessx').trumbowyg(); 

    document.body.addEventListener('htmx:afterSwap', function(evt) {
        // Re-initialize Trumbowyg on any new textareas
        $('.dess').trumbowyg();
        $('.dessx').trumbowyg();
    });
</script>