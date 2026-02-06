@extends('admin.layouts.master')

@section('title', __('admin.admins.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
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
                                <th class="wd-20p border-bottom-0">{{ __('admin.admins.actions') }}</th>
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
                                    <td class="align-content-center">
                                        <a class="modal-effect btn btn-sm btn-info"
                                           data-effect="effect-scale"
                                           data-toggle="modal"
                                           href="#editModal"
                                           data-id="{{ $admin->id }}"
                                           data-name="{{ $admin->name }}"
                                           data-email="{{ $admin->email }}"
                                           data-status="{{ $admin->status }}"
                                           title="{{ __('admin.actions.edit') }}">
                                            <i class="las la-pen"></i>
                                        </a>

                                        <a class="modal-effect btn btn-sm btn-danger"
                                           data-effect="effect-scale"
                                           data-toggle="modal"
                                           href="#deleteModal"
                                           data-id="{{ $admin->id }}"
                                           data-name="{{ $admin->name }}"
                                           title="{{ __('admin.actions.delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
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

{{--    @include('admin.admins.add_modal')--}}
{{--    @include('admin.admins.edit_modal')--}}
{{--    @include('admin.admins.delete_modal')--}}

@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var tableConfig = {
                responsive: false,
            };

            @if(app()->getLocale() == 'ar')
                tableConfig.language = {
                "sProcessing": "جارٍ التحميل...",
                "sLengthMenu": "أظهر _MENU_ مدخلات",
                "sZeroRecords": "لم يعثر على أية سجلات",
                "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix": "",
                "sSearch": "بحث:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                }
            };
            @endif

            $('#admins_table').DataTable(tableConfig);

            // Edit Modal
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var name = button.data('name')
                var email = button.data('email')
                var status = button.data('status')

                var modal = $(this)
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #email').val(email);
                modal.find('.modal-body #status').val(status);

                var url = "{{ route('admin.admins.update', ':id') }}";
                url = url.replace(':id', id);
                $('#editForm').attr('action', url);
            });

            // Delete Modal Logic
            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var name = button.data('name')

                var modal = $(this)
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #name').val(name);

                var url = "{{ route('admin.admins.destroy', ':id') }}";
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
            });
        });
    </script>
@endsection
