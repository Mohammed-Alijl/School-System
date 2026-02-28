@extends('admin.layouts.master')

@section('title', __('admin.teachers.archived'))

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
                <h4 class="content-title mb-0 my-auto">{{ __('admin.teachers.title') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.teachers.archived') }}</span>
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
                        <table class="table text-md-nowrap" id="teachers_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.teacher_code') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.name') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.email') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.national_id') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.phone') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.status') }}</th>
                                @canany(['restore_teachers','force-delete_teachers'])
                                    <th class="wd-20p border-bottom-0">{{ trans('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="#" class="text-primary font-weight-bold show-btn"
                                           data-toggle="modal"
                                           data-target="#showModal"
                                           data-teacher_code="{{ $teacher->teacher_code }}"
                                           data-name_ar="{{ $teacher->getTranslation('name', 'ar') }}"
                                           data-name_en="{{ $teacher->getTranslation('name', 'en') }}"
                                           data-email="{{ $teacher->email }}"
                                           data-national_id="{{ $teacher->national_id }}"
                                           data-gender="{{ optional($teacher->gender)->name }}"
                                           data-blood_type="{{ optional($teacher->bloodType)->name }}"
                                           data-nationality="{{ optional($teacher->nationality)->name }}"
                                           data-religion="{{ optional($teacher->religion)->name }}"
                                           data-specialization="{{ optional($teacher->specialization)->name }}"
                                           data-joining_date="{{ $teacher->joining_date->format('Y-m-d') }}"
                                           data-address="{{ $teacher->address }}"
                                           data-phone="{{ $teacher->phone }}"
                                           data-status="{{ $teacher->status ? trans('admin.global.active') : trans('admin.global.disabled') }}"
                                           data-image="{{ $teacher->imageUrl }}"
                                           data-attachments='@json($teacher->attachments->map(function($att) {
                                               return [
                                                   "url" => asset("storage/" . $att->attachment_path),
                                                   "name" => basename($att->attachment_path)
                                               ];
                                           }))'>
                                            {{ $teacher->teacher_code }}
                                        </a>
                                    </td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->national_id }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>
                                        @if ($teacher->status)
                                            <span class="label text-success d-flex">{{ trans('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ trans('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    @canany(['restore_teachers','force-delete_teachers'])
                                        <td>
                                            @can('restore_teachers')
                                                <a class="btn btn-info btn-sm restore-item"
                                                   href="#"
                                                   data-url="{{ route('admin.teachers.restore', $teacher->id) }}"
                                                   data-id="{{ $teacher->id }}"
                                                   data-name="{{ $teacher->name }}"
                                                >
                                                    <i class="las la-store"></i> {{__('admin.global.restore')}}
                                                </a>
                                            @endcan
                                            @can('force-delete_teachers')
                                                <a class="modal-effect btn btn-sm btn-danger delete-item"
                                                   href="#"
                                                   data-id="{{ $teacher->id }}"
                                                   data-url="{{ route('admin.teachers.forceDelete', $teacher->id) }}"
                                                   data-name="{{ $teacher->name }}">
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
    @include('admin.teachers.show_modal')

    <script>
        $(document).ready(function() {
            $('#teachers_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
    @stack('scripts')
@endsection
