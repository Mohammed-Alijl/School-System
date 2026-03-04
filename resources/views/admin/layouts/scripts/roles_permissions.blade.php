{{-- Shared JS for the roles permission-grid select-all behaviour --}}
<script>
    $(document).on('click', '#selectAllGlobal', function() {
        let isChecked = $(this).prop('checked');
        $('input[type="checkbox"]').prop('checked', isChecked);
        $('.select-all-model').prop('checked', isChecked);
    });

    $(document).on('click', '.select-all-model', function() {
        let modelName = $(this).data('model');
        let checkboxes = $('.' + modelName + '-checkbox');
        let isChecked  = $(this).prop('checked');
        checkboxes.prop('checked', isChecked);

        let allChecked = $('input[name="permissions[]"]').length > 0 &&
                         $('input[name="permissions[]"]:not(:checked)').length === 0;
        $('#selectAllGlobal').prop('checked', allChecked);
    });

    $(document).on('change', 'input[name="permissions[]"]', function() {
        let modelName = $(this).closest('.permission-group-card').data('model');
        if (modelName) {
            let total   = $('.' + modelName + '-checkbox').length;
            let checked = $('.' + modelName + '-checkbox:checked').length;
            $('.select-all-model[data-model="' + modelName + '"]').prop('checked', total === checked);
        }
        let allChecked = $('input[name="permissions[]"]').length > 0 &&
                         $('input[name="permissions[]"]:not(:checked)').length === 0;
        $('#selectAllGlobal').prop('checked', allChecked);
    });
</script>
