<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "800",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    });
    window.addEventListener('sucess-toast', event => {
            toastr.warning(event.detail.message, event.detail.title);
    });
    window.addEventListener('info-toast', event => {
            toastr.warning(event.detail.message, event.detail.title);
    });
    window.addEventListener('warning-toast', event => {
            toastr.warning(event.detail.message, event.detail.title);
    });
    window.addEventListener('error-toast', event => {
            toastr.warning(event.detail.message, event.detail.title);
    });
</script>
