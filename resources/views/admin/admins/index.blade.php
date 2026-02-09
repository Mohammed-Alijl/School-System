@extends('admin.layouts.master')

@section('title', __('admin.admins.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{URL::asset('assets/admin/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.admins.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <a class="modal-effect btn btn-primary-gradient btn-with-icon btn-block"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#addModal">
                    <i class="fas fa-plus-circle"></i> {{ __('admin.admins.add') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="admins_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.admins.fields.image') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.admins.fields.name') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.admins.fields.email') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.admins.fields.status') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.admins.fields.roles') }}</th>
                                @if(auth()->user()->can('edit_admins') || auth()->user()->can('delete_admins'))
                                    <th class="wd-20p border-bottom-0">{{ __('admin.admins.actions') }}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td class="align-content-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <img alt="avatar" class="avatar avatar-md brround bg-white" src="{{ $admin->image_url }}">
                                    </td>
                                    <td class="align-content-center">{{ $admin->name }}</td>
                                    <td class="align-content-center">{{ $admin->email }}</td>
                                    <td class="align-content-center">
                                        @if ($admin->status)
                                            <span class="label text-success d-flex">
                                                    {{ __('admin.global.active') }}
                                                </span>
                                        @else
                                            <span class="label text-danger d-flex">
                                                    {{ __('admin.global.disabled') }}
                                                </span>
                                        @endif
                                    </td>
                                    <td class="align-content-center">
                                        @if (!empty($admin->getRoleNames()))
                                            @foreach ($admin->getRoleNames() as $role)
                                                <span class="badge badge-primary">{{ $role }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    @if(auth()->user()->can('edit_admins') || auth()->user()->can('delete_admins'))
                                    <td class="align-content-center">
                                        @if(!in_array("Super Admin",$admin->roles->pluck('name')->toArray()))
                                        @can('edit_admins')
                                        <a class="modal-effect btn btn-sm btn-info"
                                           data-effect="effect-scale"
                                           data-toggle="modal"
                                           href="#editModal"
                                           data-id="{{ $admin->id }}"
                                           data-name="{{ $admin->name }}"
                                           data-email="{{ $admin->email }}"
                                           data-status="{{ $admin->status }}"
                                           data-roles='@json($admin->roles->pluck("name"))'
                                           data-image='{{ $admin->image_path  }}'
                                           title="{{ __('admin.actions.edit') }}">
                                            <i class="las la-pen"></i> {{__('admin.global.edit')}}
                                        </a>
                                        @endcan
                                        @can('delete_admins')
                                        <a class="modal-effect btn btn-sm btn-danger delete-item"
                                           href="#"
                                           data-id="{{ $admin->id }}"
                                           data-url="{{ route('admin.admins.destroy', $admin->id) }}"
                                           data-name="{{ $admin->name }}">
                                            <i class="las la-trash"></i> {{__('admin.global.delete')}}
                                        </a>
                                        @endcan
                                        @else
                                            <span class="text-muted"><i class="las la-lock"></i></span> {{__('admin.global.protected')}}
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    @include('admin.admins.add_modal')
    @include('admin.admins.edit_modal')

@endsection

@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/admin/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{URL::asset('assets/admin/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{URL::asset('assets/admin/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/admin/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{URL::asset('assets/admin/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <!-- Ionicons js -->
    <script src="{{URL::asset('assets/admin/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('assets/admin/js/form-elements.js')}}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/file-upload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    <script>

        $(document).ready(function() {
            $('#admins_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
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
                var btn = $('#submit-btn');
                var spinner = $('#spinner');
                var btnText = $('#btn-text');

                var formData = new FormData(this);
                btn.attr('disabled', true);
                spinner.removeClass('d-none');
                btnText.text('{{__("admin.global.loading")}}...');

                $('.error-text').text('');
                $('input, select').removeClass('is-invalid');

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
                                location.reload();
                            }, 2000);
                        } else {
                            btn.attr('disabled', false);
                            spinner.addClass('d-none');
                            btnText.text('{{__("admin.global.save")}}');
                        }
                    },
                    error: function(xhr) {
                        btn.attr('disabled', false);
                        spinner.addClass('d-none');
                        btnText.text('{{__("admin.global.save")}}');

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, val) {
                                var input = form.find('[name="'+key+'"]');
                                if(input.length === 0) {
                                    input = form.find('[name="'+key+'[]"]');
                                }
                                input.addClass('is-invalid');

                                $('.'+key+'_error').text(val[0]);
                            });

                            // swal("{{__('admin.global.error_title')}}", "{{__('admin.global.validation_error')}}", "error");
                        } else {
                            swal("Error!", "Something went wrong (Server Error).", "error");
                            console.log(xhr.responseText);
                        }
                    }
                });
            });


            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);

                var id = button.data('id');
                var name = button.data('name');
                var email = button.data('email');
                var status = button.data('status');
                var roles = button.data('roles');

                var modal = $(this);

                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #email').val(email);
                modal.find('.modal-body #status').val(status);
                modal.find('.modal-body #roles').val(roles).trigger('change');

                var url = "{{ route('admin.admins.update', ':id') }}";
                url = url.replace(':id', id);
                $('#editForm').attr('action', url);

                $('.error-text').text('');
                $('input').removeClass('is-invalid');
                modal.find('#edit_password').val(''); // تفريغ الباسورد
                modal.find('input[name="password_confirmation"]').val('');

            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var parsleyInstance = form.parsley();
                parsleyInstance.validate();

                if (!parsleyInstance.isValid()) {
                    return;
                }

                var actionUrl = form.attr('action');
                var formData = new FormData(this);

                var btn = $('#update-btn');
                var spinner = $('#update-spinner');
                var btnText = $('#update-btn-text');

                btn.attr('disabled', true);
                spinner.removeClass('d-none');
                btnText.text('{{__("admin.global.loading")}}...');

                $('.error-text').text('');
                $('input, select').removeClass('is-invalid');

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        if(response.status === 'success') {
                            $('#editModal').modal('hide');
                            swal({
                                title: "{{__('admin.global.success')}}",
                                text: response.message,
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        btn.attr('disabled', false);
                        spinner.addClass('d-none');
                        btnText.text('{{__("admin.global.save_changes")}}');

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, val) {
                                var input = form.find('[name="'+key+'"]');
                                if(input.length === 0) {
                                    input = form.find('[name="'+key+'[]"]');
                                }
                                input.addClass('is-invalid');
                                form.find('.'+key+'_error').text(val[0]);
                            });
                        } else {
                            swal("{{__('admin.global.error_title')}}", "{{__('admin.admins.messages.failed.update')}}", "error");
                        }
                    }
                });
            });
        });
    </script>
@endsection
