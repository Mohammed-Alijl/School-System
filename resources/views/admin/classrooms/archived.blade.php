@extends('admin.layouts.master')

@section('title', __('admin.classrooms.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <style>
        .page-header-archive {
            background: linear-gradient(to right, #2c3e50, #e74c3c);
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
            border-radius: 16px;
        }

        .table-archive th {
            background-color: #f8f9fc !important;
            color: #4a5568 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0 !important;
        }
        /* Warning banner */
        .archive-alert {
            background: #fff5f5;
            border-left: 4px solid #fc8181;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        /* ─── DARK THEME OVERRIDES ─── */
        .dark-theme .glass-card {
            background: #1e212b;
            border-color: rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
        }
        .dark-theme .table-archive th {
            background-color: #14161f !important;
            border-bottom-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }
        .dark-theme .table-hover tbody tr:hover {
            background-color: #242836;
        }
        .dark-theme .table-archive td {
            border-bottom-color: rgba(255, 255, 255, 0.05) !important;
            color: #e2e8f0;
        }
        .dark-theme .text-muted {
            color: #94a3b8 !important;
        }
        .dark-theme h6, .dark-theme .font-weight-bold {
            color: #f1f5f9 !important;
        }
        .dark-theme .archive-alert {
            background: rgba(231, 76, 60, 0.1);
            border-left-color: #e74c3c;
        }
        .dark-theme .badge-light {
            background-color: rgba(255,255,255,0.05);
            color: #cbd5e1;
            border: 1px solid rgba(255,255,255,0.1) !important;
        }
        .dark-theme .btn-light {
            background: rgba(255,255,255,0.05) !important;
            border-color: rgba(255,255,255,0.05);
            color: #cbd5e1 !important;
        }
    </style>
@endsection

@section('page-header')
    <div class="page-header-archive d-flex justify-content-between align-items-center mt-4">
        <div class="d-flex align-items-center">
            <div class="mr-3 ml-3">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="las la-trash-alt tx-24 text-white"></i>
                </div>
            </div>
            <div>
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.classrooms.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.classrooms.archived_list') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.classrooms.index') }}" class="btn btn-light shadow-sm" style="border-radius: 8px; font-weight: 600;">
                <i class="las la-arrow-right mr-1 ml-1"></i> {{ __('admin.global.back') }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="archive-alert shadow-sm">
        <div class="mr-3 ml-3" style="width: 40px; height: 40px; border-radius: 50%; background: #fc8181; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i class="las la-exclamation-triangle text-white tx-20"></i>
        </div>
        <div>
            <h6 class="text-danger font-weight-bold mb-1">{{ __('admin.global.warning_title') }}</h6>
            <p class="text-muted mb-0 tx-13">{{__('admin.grades.warning_body')}}</p>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card glass-card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="grade_filter" class="form-label font-weight-bold">{{ __('admin.classrooms.fields.grade') }}:</label>
                            <select id="grade_filter" class="form-control select2">
                                <option value="">{{ __('admin.global.all') }}</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->name }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-archive table-hover" id="classrooms_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.classrooms.fields.name') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.classrooms.fields.grade') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.classrooms.fields.status') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.global.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classrooms as $classroom)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $classroom->name }}</td>
                                    <td>{{ $classroom->grade->name }}</td>
                                    <td>
                                        @if ($classroom->status)
                                            <span class="label text-success d-flex">{{ __('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ __('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm view-btn"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#showModal"
                                           data-name="{{ $classroom->name }}"
                                           data-grade="{{ $classroom->grade->name }}"
                                           data-status="{{ $classroom->status }}"
                                           data-status_text="{{ $classroom->status ? __('admin.global.active') : __('admin.global.disabled') }}"
                                           data-notes="{{ $classroom->notes ?? __('admin.grades.no_notes') }}"
                                           data-sections='{!! json_encode($classroom->sections) !!}'
                                        >
                                            <i class="las la-eye"></i> {{__('admin.global.view')}}
                                        </a>
                                        @can('restore_classrooms')
                                        <a class="btn btn-info btn-sm restore-item"
                                        href="#"
                                           data-url="{{ route('admin.classrooms.restore', $classroom->id) }}"
                                           data-id="{{ $classroom->id }}"
                                           data-name="{{ $classroom->name }}"
                                        >
                                            <i class="las la-store"></i> {{__('admin.global.restore')}}
                                        </a>
                                        @endcan
                                        @can('delete_classrooms')
                                            <a class="modal-effect btn btn-danger btn-sm delete-item"
                                               href="#"
                                               data-id="{{ $classroom->id }}"
                                               data-url="{{ route('admin.classrooms.forceDelete', $classroom->id) }}"
                                               data-name="{{ $classroom->name }}">
                                                <i class="las la-trash"></i> {{__('admin.global.delete')}}
                                            </a>
                                        @endcan
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

    @include('admin.classrooms.show_modal')
@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')

    <script>
        $(document).ready(function() {
            var table = $('#classrooms_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });

            $('#grade_filter').on('change', function() {
                var selectedGrade = $(this).val();
                if (selectedGrade) {
                    table.column(2).search('^' + selectedGrade + '$', true, false).draw();
                } else {
                    table.column(2).search('').draw();
                }
            });
        });
    </script>
    @stack('scripts')
@endsection
