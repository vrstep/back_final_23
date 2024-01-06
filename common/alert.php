<?php
function displayAlert() {
    if (isset($_SESSION['status'])) {
    ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
            <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <?php echo $_SESSION['status']; ?>
                </div>
            </div>
        </div>
        <script>
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {
                    delay: 4000
                }) // 4 seconds delay
            })
            toastList.forEach(toast => toast.show());
        </script>
    <?php
        unset($_SESSION['status']);  // clear the message so it's not shown again
    }
}