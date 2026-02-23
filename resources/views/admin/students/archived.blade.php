@extends('admin.layouts.master')

@section('title', __('admin.students.archived'))

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
                <h4 class="content-title mb-0 my-auto">{{ __('admin.students.title') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.students.archived') }}</span>
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
                        <table class="table text-md-nowrap" id="students_table">
                            <thead>
                            <tr>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.student_code') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.name') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.guardian') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.grade') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.classroom') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.section') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.status') }}</th>
                                @canany('restore_students','force-delete_students')
                                    <th class="wd-20p border-bottom-0">{{ trans('admin.global.actions') }}</th>
                                @endcanany
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->student_code }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->guardian->name_father }}</td>
                                    <td>{{ $student->grade->name }}</td>
                                    <td>{{ $student->classroom->name }}</td>
                                    <td>{{ $student->section->name }}</td>
                                    <td>
                                        @if ($student->status)
                                            <span class="label text-success d-flex">{{ trans('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ trans('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    @canany('restore_students','force-delete_students')
                                        <td>
                                            @can('restore_students')
                                                <a class="btn btn-info btn-sm restore-item"
                                                   href="#"
                                                   data-url="{{ route('admin.students.restore', $student->id) }}"
                                                   data-id="{{ $student->id }}"
                                                   data-name="{{ $student->name }}"
                                                >
                                                    <i class="las la-store"></i> {{__('admin.global.restore')}}
                                                </a>
                                            @endcan
                                            @can('force-delete_students')
                                                <a class="modal-effect btn btn-sm btn-danger delete-item"
                                                   href="#"
                                                   data-id="{{ $student->id }}"
                                                   data-url="{{ route('admin.students.forceDelete', $student->id) }}"
                                                   data-name="{{ $student->name }}">
                                                    <i class="las la-trash"></i> {{trans('admin.global.delete')}}
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
            $('#students_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
@endsection
