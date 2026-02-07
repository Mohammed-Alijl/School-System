@extends('admin.layouts.master')
@section('title', 'Roles & Permissions')

@section('content')
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <a class="modal-effect btn btn-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#addModal">Add Role</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="roles_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th> <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach($role->permissions as $perm)
                                <span class="badge badge-success">{{ $perm->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a class="modal-effect btn btn-sm btn-info"
                                   data-effect="effect-scale"
                                   data-id="{{ $role->id }}"
                                   data-name="{{ $role->name }}"
                                   data-permissions="{{ $role->permissions->pluck('name') }}"
                                   data-toggle="modal"
                                   href="#editModal">
                                    <i class="las la-pen"></i>
                                </a>

                                <a class="modal-effect btn btn-sm btn-danger"
                                   data-effect="effect-scale"
                                   data-id="{{ $role->id }}"
                                   data-name="{{ $role->name }}"
                                   data-toggle="modal"
                                   href="#deleteModal">
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

{{--@include('admin.roles.add_modal')--}}
{{--@include('admin.roles.edit_modal')--}}
{{--@include('admin.roles.delete_modal')--}}

@endsection

@section('js')
<script>
    // ... (نفس دالة submitForm السابقة) ...

    // عند فتح مودال التعديل
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var permissions = button.data('permissions') // هذه مصفوفة بالصلاحيات التي يملكها

        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);

        // 1. تصفير كل الـ Checkboxes أولاً
        modal.find('input[type="checkbox"]').prop('checked', false);

        // 2. تفعيل الصلاحيات التي يملكها الرتبة فقط
        // permissions عبارة عن Array ['admins', 'users', ...]
        $.each(permissions, function(index, value) {
            // نبحث عن الـ checkbox الذي يملك نفس الـ value ونفعله
            modal.find('input[value="' + value + '"]').prop('checked', true);
        });

        var url = "{{ route('admin.roles.update', ':id') }}";
        url = url.replace(':id', id);
        $('#editForm').attr('action', url);
    })
</script>
@endsection
