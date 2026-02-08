@extends('admin.layouts.master')
@section('css')
    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('admin.sidebar.users')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('admin.sidebar.roles')}}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{__('admin.roles.title')}}</h4>
                </div>
                <div class="card-body">
                    <form id="addForm" action="{{ route('admin.roles.store') }}" method="POST" data-parsley-validate="">
                        @csrf

                        <div class="form-group mb-4">
                            <label>{{__('admin.roles.fields.name')}} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="{{__('admin.roles.fields.name_placeholder')}}" autocomplete="off" minlength="3" maxlength="30" required>
                            <span class="text-danger error-text name_error"></span>
                        </div>

                        <div class="form-group mb-3 border-bottom pb-2">
                            <label class="ckbox">
                                <input type="checkbox" id="selectAllGlobal">
                                <span class="font-weight-bold">{{__('admin.roles.select_all')}}</span>
                            </label>
                            <div class="text-danger error-text permissions_error mt-2"></div>
                        </div>

                        <div class="row">
                            @foreach($groupedPermissions as $model => $permissions)
                                <div class="col-md-4 mb-4">
                                    <div class="card border h-100">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                            <h6 class="card-title mb-0 text-capitalize">{{ str_replace('_', ' ', $model) }}</h6>
                                            <label class="ckbox mb-0">
                                                <input type="checkbox" class="select-all-model" data-model="{{ $model }}">
                                                <small>{{__('admin.global.all')}}</small>
                                            </label>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row">
                                                @foreach($permissions as $permission)
                                                    <div class="col-12 mb-2">
                                                        <label class="ckbox">
                                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="{{ $model }}-checkbox">
                                                            <span class="text-muted text-capitalize">
                                                                {{ str_replace('_' . $model, '', $permission->name) }}
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
                            <span id="btn-text">{{__('admin.global.send')}}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/sweet-alert/jquery.sweet-alert.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>

    <script>
        $(document).on('click', '#selectAllGlobal', function() {
            $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        });

        $(document).on('click', '.select-all-model', function() {
            var modelName = $(this).data('model');
            $('.' + modelName + '-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('#addForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);

            var parsleyInstance = form.parsley();

            parsleyInstance.validate();

            if (!parsleyInstance.isValid()) {
                return;
            }

            var actionUrl = form.attr('action');
            var formData = new FormData(this);
            var btn = $('#submit-btn');
            var spinner = $('#spinner');
            var btnText = $('#btn-text');

            btn.attr('disabled', true);
            spinner.removeClass('d-none');
            btnText.text('{{__("admin.global.loading")}}...');

            $('span.error-text').text('');
            $('input').removeClass('is-invalid');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    if(response.status === 'success') {
                        swal({
                            title: "{{__('admin.global.success')}}",
                            text: response.message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(function(){
                            window.location.href = "{{ route('admin.roles.index') }}";
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    btn.attr('disabled', false);
                    spinner.addClass('d-none');
                    btnText.text('{{__("admin.global.send")}}');

                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, val) {
                            $('input[name="'+key+'"]').addClass('is-invalid');
                            $('input[name="'+key+'[]"]').addClass('is-invalid'); // عشان يلون الـ checkboxes لو أمكن

                            $('.'+key+'_error').text(val[0]);
                        });
                    } else {
                        swal("Error!", "Something went wrong.", "error");
                    }
                }
            });
        });
    </script>
@endsection
