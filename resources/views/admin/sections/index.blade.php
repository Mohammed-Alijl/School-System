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

    <style>
        /* ─── GLASS CARD ─── */
        .glass-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important;
            border: 1px solid rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }
        .glass-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.08) !important; }

        /* ─── FILTER SECTION ─── */
        .filter-section {
            background: #f8f9fc;
            border-radius: 14px;
            padding: 1.4rem 1.6rem;
            margin-bottom: 1.75rem;
            border: 1px dashed #e3e6f0;
        }

        /* ─── FORM CONTROLS ─── */
        .form-control-modern {
            border-radius: 8px;
            border: 1px solid #e3e6f0;
            padding: 0.55rem 1rem;
            font-size: 0.875rem;
            box-shadow: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control-modern:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.18);
        }
        .form-control-modern:disabled { background-color: #f1f3f9; opacity: 0.7; cursor: not-allowed; }

        /* ─── TABLE HEADER ─── */
        table.dataTable thead th {
            border-bottom: 2px solid #edf2f7 !important;
            color: #4a5568; font-weight: 700;
            text-transform: uppercase; font-size: 0.72rem; letter-spacing: 1px;
        }
        .table-hover tbody tr:hover { background-color: #f8fafc; transition: background-color 0.2s ease; }

        /* ─── STATUS BADGES ─── */
        .badge-modern { padding: 0.45em 0.95em; border-radius: 30px; font-weight: 600; font-size: 82%; letter-spacing: 0.4px; }
        .badge-active { background-color: #e3fcef; color: #0d965e; border: 1px solid #c9f5e1; }
        .badge-inactive { background-color: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }

        /* ─── ACTION BUTTONS ─── */
        .action-icon-btn { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
        .action-icon-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important; }

        /* ─── RESET BUTTON ─── */
        #reset_filters { border: 1px solid #dce1ef; color: #6c7a9c; background: #fff; }
        #reset_filters:hover { background: #f1f3f9; border-color: #c4cbdc; }

        /* ══════════════════════════════════════
           DARK THEME OVERRIDES
        ══════════════════════════════════════ */
        .dark-theme .glass-card { background: #1e212b; border-color: rgba(255,255,255,0.05); box-shadow: 0 4px 20px rgba(0,0,0,0.35) !important; }
        .dark-theme .filter-section { background: #14161f; border-color: rgba(255,255,255,0.08); }
        .dark-theme .filter-section .form-label { color: #94a3b8 !important; }
        .dark-theme .form-control-modern { background-color: #1e212b; border-color: rgba(255,255,255,0.1); color: #e2e8f0; }
        .dark-theme .form-control-modern:disabled { background-color: #12141c; color: #64748b; }
        .dark-theme #reset_filters { background: #1e212b; border-color: rgba(255,255,255,0.08); color: #94a3b8; }
        .dark-theme #reset_filters:hover { background: #242836; }
        .dark-theme table.dataTable thead th { border-bottom-color: rgba(255,255,255,0.08) !important; color: #cbd5e1; }
        .dark-theme .table-hover tbody tr:hover { background-color: #242836; }
        .dark-theme .badge-active { background-color: rgba(13,150,94,0.15); border-color: rgba(13,150,94,0.25); }
        .dark-theme .badge-inactive { background-color: rgba(220,38,38,0.12); border-color: rgba(220,38,38,0.2); }
    </style>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.academic_structure') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.sections.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('view-archived_sections')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="btn btn-modern btn-danger shadow-sm" href="{{ route('admin.sections.archived') }}">
                        <i class="las la-archive tx-16 mr-1 ml-1"></i>
                        {{ trans('admin.sections.archived') }}
                    </a>
                </div>
            @endcan
            @can('create_sections')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm"
                       data-effect="effect-scale" data-toggle="modal" href="#addModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ trans('admin.sections.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">

            {{-- ─── Advanced Filter Section ─── --}}
            <div class="filter-section shadow-sm">
                <div class="row align-items-end">

                    {{-- Grade --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-layer-group mr-1"></i> {{ trans('admin.sections.fields.grade') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_grade">
                            <option value="">{{ trans('admin.global.all') }}</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Classroom --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-chalkboard mr-1"></i> {{ trans('admin.sections.fields.classroom') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_classroom" disabled>
                            <option value="">{{ trans('admin.global.all') }}</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-toggle-on mr-1"></i> {{ trans('admin.sections.fields.status') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_status">
                            <option value="">{{ trans('admin.global.all') }}</option>
                            <option value="1">{{ trans('admin.global.active') }}</option>
                            <option value="0">{{ trans('admin.global.disabled') }}</option>
                        </select>
                    </div>

                    {{-- Reset Button --}}
                    <div class="col-md-3 text-right mt-3 mt-md-0">
                        <button class="btn btn-modern w-100" id="reset_filters">
                            <i class="las la-sync-alt mr-1 ml-1"></i>
                            {{ trans('admin.global.reset_filters', [], null) ?? 'Reset Filters' }}
                        </button>
                    </div>

                </div>
            </div>

            {{-- ─── Glass Table Card ─── --}}
            <div class="card glass-card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover text-md-nowrap" id="sections_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.sections.fields.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.sections.fields.grade') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.sections.fields.classroom') }}</th>
                                <th class="wd-10p border-bottom-0 text-center">{{ __('admin.sections.fields.status') }}</th>
                                <th class="wd-10p border-bottom-0 text-center">{{ __('admin.global.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    @include('admin.sections.add_modal')
    @include('admin.sections.edit_modal')
    @include('admin.sections.show_modal')

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/file-upload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
    $(document).ready(function() {

        var table = $('#sections_table').DataTable({
            ...globalTableConfig,
            processing: true,
            serverSide: true,
            language: $.extend({}, datatable_lang),
            ajax: {
                url: "{{ route('admin.sections.index') }}",
                data: function(d) {
                    d.filter_grade     = $('#filter_grade').val();
                    d.filter_classroom = $('#filter_classroom').val();
                    d.filter_status    = $('#filter_status').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex',    name: 'DT_RowIndex',    orderable: false, searchable: false},
                {data: 'name',           name: 'name'},
                {data: 'grade_name',     name: 'grade_name',     defaultContent: '-'},
                {data: 'classroom_name', name: 'classroom_name', defaultContent: '-'},
                {data: 'status',         name: 'status',         className: 'text-center'},
                {data: 'actions',        name: 'actions',        orderable: false, searchable: false, className: 'text-center'},
            ],
        });

        /* ─── Grade filter → load classrooms ─── */
        $('#filter_grade').on('change', function () {
            let gradeId = $(this).val();
            let classroomSelect = $('#filter_classroom');

            classroomSelect.empty().append('<option value="">{{ trans('admin.global.all') }}</option>').prop('disabled', true);

            if (gradeId) {
                $.ajax({
                    url: "{{ route('admin.classrooms.by-grade') }}",
                    data: { grade_id: gradeId },
                    success: function (response) {
                        if (response.success && Object.keys(response.data).length) {
                            $.each(response.data, function (id, name) {
                                classroomSelect.append('<option value="' + id + '">' + name + '</option>');
                            });
                            classroomSelect.prop('disabled', false);
                        }
                    }
                });
            }
            table.draw();
        });

        /* ─── Classroom filter ─── */
        $('#filter_classroom').on('change', function () {
            table.draw();
        });

        /* ─── Status direct filter ─── */
        $('#filter_status').on('change', function () {
            table.draw();
        });

        /* ─── Reset all filters ─── */
        $('#reset_filters').on('click', function () {
            $('#filter_grade').val('').trigger('change');
            $('#filter_status').val('');
            table.draw();
        });

    });
    </script>
    @stack('scripts')
@endsection
