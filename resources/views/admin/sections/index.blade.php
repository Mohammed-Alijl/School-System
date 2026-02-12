@extends('admin.layouts.master')

@section('title', __('admin.sections.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.academic_structure') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.sections.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('view-archived_sections')
                 <div class="pr-1 mb-3 mb-xl-0">
                    <a class="modal-effect btn btn-warning-gradient btn-with-icon btn-block"
                       href="{{route('admin..classrooms.archived')}}">
                        <i class="fas fa-book ml-2"></i>  {{__('admin.sections.archived') }}
                    </a>
            </div>
            @endcan
            @can('create_sections')
                  <div class="pr-1 mb-3 mb-xl-0">
                <a class="modal-effect btn btn-primary-gradient btn-with-icon btn-block"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#addModal">
                    <i class="fas fa-plus-circle ml-2"></i> {{ __('admin.sections.add') }}
                </a>
            </div>
            @endcan
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
                        <table class="table text-md-nowrap" id="classrooms_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.sections.fields.name') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.sections.fields.grade') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.sections.fields.classroom') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.sections.fields.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.sections.fields.notes') }}</th>
                                @canany('edit_sections','delete_sections')
                                    <th class="wd-20p border-bottom-0">{{ __('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sections as $section)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $section->name }}</td>
                                    <td>{{ $section->grade->name }}</td>
                                    <td>{{ $section->classroom->name }}</td>
                                    <td>
                                        @if ($section->status)
                                            <span class="label text-success d-flex">{{ __('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ __('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $grade->notes ?? __('admin.sections.no_notes') }}</td>
                                    @canany('edit_sections','delete_sections')
                                    <td>
                                        @can('edit_sections')
                                            <a class="btn btn-info btn-sm edit-btn"
                                               href="#"
                                               data-toggle="modal"
                                               data-target="#editModal"
                                               data-url="{{ route('admin.sections.update', $section->id) }}"
                                               data-name_ar="{{ $section->getTranslation('name', 'ar') }}"
                                               data-name_en="{{ $section->getTranslation('name', 'en') }}"
                                               data-grade_id="{{ $section->grade_id }}"
                                               data-classroom_id="{{ $section->classroom_id }}"
                                               data-status="{{ $section->status }}">
                                                <i class="las la-pen"></i> {{__('admin.global.edit')}}
                                            </a>
                                        @endcan
                                        @can('delete_sections')
                                            <a class="modal-effect btn btn-sm btn-danger delete-item"
                                               href="#"
                                               data-id="{{ $section->id }}"
                                               data-url="{{ route('admin.sections.destroy', $section->id) }}"
                                               data-name="{{ $section->name }}">
                                                <i class="las la-trash"></i> {{__('admin.global.archive')}}
                                            </a>
                                        @endcan
                                    </td>
                                    @endcanany
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

    @include('admin.sections.add_modal')
{{--    @include('admin.sections.edit_modal')--}}

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/file-upload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>
{{--    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>--}}

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            $('#classrooms_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });



            $('select[name="grade_id"]').on('change', function() {
                var GradeId = $(this).val();
                var classroomSelect = $(this).closest('form').find('select[name="classroom_id"]');

                if (GradeId) {
                    $.ajax({
                        url: "{{ URL::to('admin/classes') }}/" + GradeId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            classroomSelect.empty();
                            classroomSelect.append('<option value="" selected disabled>-- اختر الصف --</option>');

                            $.each(data, function(key, value) {

                                classroomSelect.append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });

            $(document).on('click', '.edit-btn', function() {
                var gradeId = $(this).data('grade_id');
                var classroomId = $(this).data('classroom_id');

                var modal = $('#editModal');
                var classroomSelect = modal.find('select[name="classroom_id"]');
                classroomSelect.empty();

                if(gradeId) {
                    $.ajax({
                        url: "{{ URL::to('admin/classes') }}/" + gradeId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $.each(data, function(key, value) {
                                var select = (key == classroomId) ? 'selected' : '';
                                classroomSelect.append('<option value="' + key + '" '+select+'>' + value + '</option>');
                            });
                            classroomSelect.trigger('change');
                        }
                    });
                }
            });
        });
    </script>
@endsection
