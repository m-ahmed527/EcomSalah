<script>
    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function () {
            // sirf numbers, + aur - allow karo
            this.value = this.value.replace(/[^0-9+\-]/g, '');
        });

        // prevent pasting of invalid chars
        phoneInput.addEventListener('paste', function (e) {
            e.preventDefault();
            let pasteData = (e.clipboardData || window.clipboardData).getData('text');
            pasteData = pasteData.replace(/[^0-9+\-]/g, '');
            document.execCommand('insertText', false, pasteData);
        });
    });
</script>