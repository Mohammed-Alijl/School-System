@extends('admin.layouts.master')

@section('title', __('admin.grades.archived'))

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

        .btn-restore {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.2);
            transition: all 0.2s ease;
        }
        
        .btn-restore:hover {
            background: #2ecc71;
            color: white;
            box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);
            transform: translateY(-2px);
        }

        .btn-force-delete {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.2);
            transition: all 0.2s ease;
        }

        .btn-force-delete:hover {
            background: #e74c3c;
            color: white;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
            transform: translateY(-2px);
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
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.grades.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.grades.archived_list') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.grades.index') }}" class="btn btn-light shadow-sm" style="border-radius: 8px; font-weight: 600;">
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
            <p class="text-muted mb-0 tx-13">{!! __('admin.grades.warning_body') !!}</p>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="sections_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.grades.fields.name') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.grades.fields.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.grades.fields.notes') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.global.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $grade->name }}</td>
                                    <td>
                                        @if ($grade->status)
                                            <span class="label text-success d-flex">{{ __('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ __('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $grade->notes ?? __('admin.sections.no_notes') }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm view-btn"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#showModal"
                                           data-name="{{ $grade->name }}"
                                           data-status="{{ $grade->status }}"
                                           data-status_text="{{ $grade->status ? __('admin.global.active') : __('admin.global.disabled') }}"
                                           data-notes="{{ $grade->notes ?? __('admin.grades.no_notes') }}"
                                           data-classrooms='{!! json_encode($grade->classrooms) !!}'
                                        >
                                            <i class="las la-eye"></i> {{__('admin.global.view')}}
                                        </a>
                                        @can('restore_grades')
                                            <a class="btn btn-info btn-sm restore-item"
                                                   href="#"
                                                   data-url="{{ route('admin.grades.restore', $grade->id) }}"
                                                   data-id="{{ $grade->id }}"
                                                   data-name="{{ $grade->name }}"
                                                >
                                                    <i class="las la-store"></i> {{__('admin.global.restore')}}
                                                </a>
                                            @endcan
                                            @can('delete_sections')
                                                <a class="modal-effect btn btn-sm btn-danger delete-item"
                                                   href="#"
                                                   data-id="{{ $grade->id }}"
                                                   data-url="{{ route('admin.grades.forceDelete', $grade->id) }}"
                                                   data-name="{{ $grade->name }}">
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
    
    @include('admin.grades.show_modal')
@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')

    <script>
        $(document).ready(function() {
            $('#sections_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });
            
            // Handle Show Modal Populating
            $('.view-btn').on('click', function() {
                var btn = $(this);
                $('#show-grade-name').text(btn.data('name'));
                $('#show-notes').text(btn.data('notes'));
                
                var statusBadge = $('#show-status-badge');
                if (btn.data('status') == 1) {
                    statusBadge.removeClass('badge-danger').addClass('badge-success').text(btn.data('status_text'));
                } else {
                    statusBadge.removeClass('badge-success').addClass('badge-danger').text(btn.data('status_text'));
                }

                var classrooms = btn.data('classrooms');
                var tbody = $('#classrooms-table-body');
                tbody.empty();
                
                if (classrooms && classrooms.length > 0) {
                    $('#classrooms-table').removeClass('d-none');
                    $('#no-classrooms-empty-state').addClass('d-none');
                    
                    $('#show-classrooms-count').text(classrooms.length);
                    
                    $.each(classrooms, function(index, classroom) {
                        var statusHtml = classroom.status == 1 
                            ? '<span class="label text-success d-flex">{{ __("admin.global.active") }}</span>' 
                            : '<span class="label text-danger d-flex">{{ __("admin.global.disabled") }}</span>';
                            
                        var classroomName = typeof classroom.name === 'object' 
                            ? (classroom.name['{{ app()->getLocale() }}'] || Object.values(classroom.name)[0])
                            : classroom.name;
                        
                        tbody.append('<tr><td>' + (index + 1) + '</td><td>' + classroomName + '</td><td>' + statusHtml + '</td></tr>');
                    });
                } else {
                    $('#classrooms-table').addClass('d-none');
                    $('#no-classrooms-empty-state').removeClass('d-none');
                    $('#show-classrooms-count').text('0');
                }
            });
        });
    </script>
    @stack('scripts')
@endsection
