<script>
    $(document).ready(function() {
        $(document).on('click', '.restore-item', function(e) {
            e.preventDefault();

            var button = $(this);
            var url = button.data('url');
            var id = button.data('id');
            var row = button.closest('tr');

            swal({
                title: "{{ __('admin.global.warning_title') }}",
                text: "{{ __('admin.global.warning_restore') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "{{ __('admin.global.restore') }}",
                cancelButtonText: "{{ __('admin.global.cancel') }}",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            swal({
                                title: "{{ __('admin.global.restored') }}",
                                text: response.message,
                                type: "success",
                                showConfirmButton: true,
                                confirmButtonText: "{{__('admin.global.ok')}}",
                            });

                            row.fadeOut(500, function() {
                                $(this).remove();
                            });
                        },
                        error: function(xhr) {
                            var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "{{ __('admin.global.failed_restore') }}";
                            swal({
                                title: "{{ __('admin.global.error_title') }}",
                                text: errorMessage,
                                type: "error",
                                confirmButtonColor: "#007bff",
                                confirmButtonText: "{{__('admin.global.ok')}}",
                            });
                        }
                    });
                }
            });
        });
    });
</script>
