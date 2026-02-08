@extends('admin.layouts.master')
@section('title', __('admin.roles.title'))
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
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.roles.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                {{-- 🔥 حماية زر الإضافة --}}
                @can('create_roles')
                    <a class="modal-effect btn btn-primary-gradient btn-with-icon btn-block"
                       href="{{route('admin.roles.create')}}">
                        <i class="fas fa-plus-circle"></i> {{ __('admin.roles.add') }}
                    </a>
                @endcan
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
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="roles_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('admin.roles.fields.name')}}</th>
                                <th>{{__('admin.roles.fields.permissions_count')}}</th>
                                @if(auth()->user()->can('edit_roles') || auth()->user()->can('delete_roles'))
                                    <th>{{__('admin.roles.actions')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @can('view_roles')
                                            <a href="{{route('admin.roles.show',$role->id)}}">{{ $role->name }}</a>
                                        @else
                                            {{ $role->name }}
                                        @endcan
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $role->permissions_count }}</span>
                                    </td>
                                    @if(auth()->user()->can('edit_roles') || auth()->user()->can('delete_roles'))
                                    <td>
                                        @if($role->name !== 'Super Admin')
                                            @can('edit_roles')
                                                <a class="modal-effect btn btn-sm btn-info"
                                                   data-effect="effect-scale"
                                                   data-permissions="{{ $role->permissions()->pluck('name') }}"
                                                   href="{{route('admin.roles.edit',$role->id)}}">
                                                    <i class="las la-pen"></i> {{__('admin.global.edit')}}
                                                </a>
                                            @endcan

                                            @can('delete_roles')
                                                <a class="modal-effect btn btn-sm btn-danger delete-item"
                                                   href="#"
                                                   data-id="{{ $role->id }}"
                                                   data-url="{{ route('admin.roles.destroy', $role->id) }}"
                                                   data-name="{{ $role->name }}">
                                                    <i class="las la-trash"></i> {{__('admin.global.delete')}}
                                                </a>
                                            @endcan
                                        @else
                                            <span class="text-muted"><i class="las la-lock"></i></span>
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

@endsection

@section('js')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.datatable_config')
    <script>
        $(document).ready(function() {

            $('#roles_table').DataTable(globalTableConfig);

            @if (session('status') === 'success')
            swal(
                {
                    title: '{{__('admin.global.success')}}',
                    text: '{{session('message')}}',
                    type: 'success',
                    confirmButtonColor: '#57a94f',
                    confirmButtonText: '{{__('admin.global.ok')}}'
                }
            )
            @endif

            @error('message')
            swal(
                {
                    title: '{{__('admin.global.failed')}}',
                    text: '{{$message}}',
                    type: 'error',
                    confirmButtonColor: '#57a94f',
                    confirmButtonText: '{{__('admin.global.ok')}}'
                }
            )
            @enderror
        });
    </script>
@endsection
