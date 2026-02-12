@extends('admin.layouts.master')

@section('title', __('admin.sections.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sections.title') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.sections.archived') }}</span>
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
                        <table class="table text-md-nowrap" id="sections_table">
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
                                    <td>{{ $section->notes ?? __('admin.sections.no_notes') }}</td>
                                    @canany('restore_sections','force-delete_sections')
                                        <td>
                                            @can('restore_sections')
                                                <a class="btn btn-info btn-sm restore-item"
                                                   href="#"
                                                   data-url="{{ route('admin.sections.restore', $section->id) }}"
                                                   data-id="{{ $section->id }}"
                                                   data-name="{{ $section->name }}"
                                                >
                                                    <i class="las la-store"></i> {{__('admin.global.restore')}}
                                                </a>
                                            @endcan
                                            @can('delete_sections')
                                                <a class="modal-effect btn btn-sm btn-danger delete-item"
                                                   href="#"
                                                   data-id="{{ $section->id }}"
                                                   data-url="{{ route('admin.sections.forceDelete', $section->id) }}"
                                                   data-name="{{ $section->name }}">
                                                    <i class="las la-trash"></i> {{__('admin.global.delete')}}
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
        });
    </script>
@endsection
