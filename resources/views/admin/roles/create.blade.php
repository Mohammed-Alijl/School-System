@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('admin.sidebar.users')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('admin.sidebar.roles')}}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{__('admin.roles.title')}}</h4>
                    </div>
                    <div class="card-body">
                        <form id="addForm" action="{{ route('admin.roles.store') }}" method="POST" data-parsley-validate="">
                            @csrf
                                <div class="form-group mb-4">
                                    <label>{{__('admin.roles.fields.name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="{{__('admin.roles.fields.name_placeholder')}}" required autocomplete="off" minlength="3" maxlength="30">
                                </div>

                                <div class="form-group mb-3 border-bottom pb-2">
                                    <label class="ckbox">
                                        <input type="checkbox" id="selectAllGlobal">
                                        <span class="font-weight-bold">{{__('admin.roles.select_all')}}</span>
                                    </label>
                                </div>

                                <div class="row">
                                    @foreach($groupedPermissions as $model => $permissions)
                                        <div class="col-md-4 mb-4"> <div class="card border h-100"> <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                                    <h6 class="card-title mb-0 text-capitalize">{{ str_replace('_', ' ', $model) }}</h6>

                                                    <label class="ckbox mb-0">
                                                        <input type="checkbox" class="select-all-model" data-model="{{ $model }}">
                                                        <small>{{__('admin.global.all')}}</small>
                                                    </label>
                                                </div>
                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        @foreach($permissions as $permission)
                                                            <div class="col-12 mb-2">
                                                                <label class="ckbox">
                                                                    <input type="checkbox" name="permissions[]"
                                                                           required
                                                                           value="{{ $permission->name }}"
                                                                           class="{{ $model }}-checkbox">
                                                                    <span class="text-muted text-capitalize">
                                                            {{ str_replace('_' . $model, '', $permission->name) }}
                                                        </span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            <input type="submit" class="btn btn-primary" value="{{__('admin.global.send')}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/form-validation.js')}}"></script>

    <script>
        $(document).on('click', '#selectAllGlobal', function() {
            $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        });

        $(document).on('click', '.select-all-model', function() {
            var modelName = $(this).data('model');
            $('.' + modelName + '-checkbox').prop('checked', $(this).prop('checked'));
        });
    </script>
@endsection
