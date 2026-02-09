<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('admin.grades.edit') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
    <form action=""
    method="POST"
          class="ajax-form"
          data-modal-id="#editModal">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('admin.grades.fields.name')}} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="{{__('admin.grades.fields.name')}}" required minlength="3" maxlength="30" autocomplete="off">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>{{__('admin.grades.fields.sort_order')}}</label>
                    <input type="number" name="sort_order" class="form-control" min="0" max="1000">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('admin.grades.fields.status') }} <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="1" selected>{{ __('admin.global.active') }}</option>
                            <option value="0">{{ __('admin.global.disabled') }}</option>
                        </select>
                        <span class="text-danger error-text status_error"></span>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{__('admin.grades.fields.notes')}}</label>
                        <textarea class="form-control" name="notes" placeholder="{{__('admin.grades.fields.notes')}}" rows="5"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <span class="spinner-border spinner-border-sm d-none"></span> {{__('admin.global.save')}}
            </button>
        </div>

    </form>
</div>
</div>
</div>
