<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

<div class="alert alert-danger alert-dismissible fade show" role="alert">

    <?= $message ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert">
    </button>

</div>

<script>
    setTimeout(() => {

        const alert = document.querySelector('.alert');

        if (alert) {
            alert.remove();
        }

    }, 3000);
</script>