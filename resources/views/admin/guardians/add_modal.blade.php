<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addGuardianModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGuardianModalLabel">
                    <i class="fas fa-user-plus"></i> {{ trans('admin.guardians.add') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.guardians.store') }}" method="POST" class="ajax-form" id="addGuardianForm" data-modal-id="#addModal" enctype="multipart/form-data" data-parsley-validate>
                    @csrf

                    <div id="addGuardianWizard">

                        <h3><i class="fas fa-male"></i> {{ trans('admin.guardians.father_information') }}</h3>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.name_father_ar') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_father[ar]" id="name_father_ar" required minlength="3" maxlength="30" data-parsley-group="step-1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.name_father_en') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_father[en]" id="name_father_en" required minlength="3" maxlength="30" pattern="[a-zA-Z\s]+" data-parsley-group="step-1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.national_id_father') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control numeric-only" name="national_id_father" id="national_id_father" maxlength="10" required data-parsley-length="[9, 10]" data-parsley-group="step-1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.passport_id_father') }}</label>
                                        <input type="text" class="form-control numeric-only" name="passport_id_father" id="passport_id_father" minlength="8" maxlength="10" data-parsley-group="step-1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.phone_father') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control numeric-only" id="phone_father_input" required maxlength="10" data-parsley-group="step-1">
                                        <input type="hidden" name="phone_father" id="phone_father_hidden">
                                        <span class="text-danger error-text phone_father_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.job_father_ar') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="job_father[ar]" id="job_father_ar" required minlength="3" maxlength="30" data-parsley-group="step-1">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.job_father_en') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="job_father[en]" id="job_father_en" required minlength="3" maxlength="30" pattern="[a-zA-Z\s]+" data-parsley-group="step-1">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.nationality_father_id') }} <span class="text-danger">*</span></label>
                                        <select class="form-control" name="nationality_father_id" required data-parsley-group="step-1">
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.blood_type_father_id') }} <span class="text-danger">*</span></label>
                                        <select class="form-control" name="blood_type_father_id" required data-parsley-group="step-1">
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($blood_types as $blood_type)
                                                <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.religion_father_id') }} <span class="text-danger">*</span></label>
                                        <select class="form-control" name="religion_father_id" required data-parsley-group="step-1">
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($religions as $religion)
                                                <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.address_father') }} <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="address_father" rows="3" required maxlength="100" data-parsley-group="step-1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3><i class="fas fa-female"></i> {{ trans('admin.guardians.mother_information') }}</h3>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.name_mother_ar') }}</label>
                                        <input type="text" class="form-control" name="name_mother[ar]" minlength="3" maxlength="30" data-parsley-group="step-2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.name_mother_en') }}</label>
                                        <input type="text" class="form-control" name="name_mother[en]" minlength="3" maxlength="30" pattern="[a-zA-Z\s]+" data-parsley-group="step-2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.national_id_mother') }}</label>
                                        <input type="text" class="form-control numeric-only" name="national_id_mother" maxlength="10" data-parsley-group="step-2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.passport_id_mother') }}</label>
                                        <input type="text" class="form-control numeric-only" name="passport_id_mother" minlength="8" maxlength="10" data-parsley-group="step-2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.phone_mother') }}</label>
                                        <input type="text" class="form-control numeric-only" id="phone_mother_input" maxlength="10" data-parsley-group="step-2">
                                        <input type="hidden" name="phone_mother" id="phone_mother_hidden">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.job_mother_ar') }}</label>
                                        <input type="text" class="form-control" name="job_mother[ar]" minlength="3" maxlength="30" data-parsley-group="step-2">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.job_mother_en') }}</label>
                                        <input type="text" class="form-control" name="job_mother[en]" minlength="3" maxlength="30" data-parsley-group="step-2">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.nationality_mother_id') }}</label>
                                        <select class="form-control" name="nationality_mother_id" data-parsley-group="step-2">
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.blood_type_mother_id') }}</label>
                                        <select class="form-control" name="blood_type_mother_id" data-parsley-group="step-2">
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($blood_types as $blood_type)
                                                <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.religion_mother_id') }}</label>
                                        <select class="form-control" name="religion_mother_id" data-parsley-group="step-2">
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($religions as $religion)
                                                <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.address_mother') }}</label>
                                        <textarea class="form-control" name="address_mother" rows="3" maxlength="100" data-parsley-group="step-2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3><i class="fas fa-check-circle"></i> {{ trans('admin.guardians.auth_and_attachments') }}</h3>
                        <section>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.email') }} <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" required maxlength="50" data-parsley-group="step-3">
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.password') }} <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password" id="password" required minlength="8" maxlength="30" data-parsley-group="step-3">
                                        <span class="text-danger error-text password_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.password_confirmation') }} <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" class="form-control" required data-parsley-equalto="#password" data-parsley-group="step-3">
                                        <span class="text-danger error-text password_confirmation_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.image') }}</label>
                                        <input type="file" class="dropify" name="image" accept="image/jpeg, image/png, image/jpg" data-height="150" data-parsley-group="step-3"/>
                                        <span class="text-danger error-text image_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.attachments') }}</label>
                                        <input type="file" name="attachments[]" id="attachments" accept=".jpg, .png, .pdf" multiple data-parsley-group="step-3">
                                        <small class="text-muted">{{ trans('admin.guardians.attachments_help') }}</small>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('input', '.numeric-only', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $(function() {
                let inputFather = document.querySelector("#phone_father_input");
                itiFather = window.intlTelInput(inputFather, {
                    onlyCountries: ["ps", "sa", "eg", "jo", "qa", "us"],
                    initialCountry: "ps",
                    utilsScript: "assets/admin/plugins/telephoneinput/utils.js",
                });

                let inputMother = document.querySelector("#phone_mother_input");
                itiMother = window.intlTelInput(inputMother, {
                    onlyCountries: ["ps", "sa", "eg", "jo", "qa", "us"],
                    initialCountry: "ps",
                    utilsScript: "assets/admin/plugins/telephoneinput/utils.js",
                });
            });

            var form = $('#addGuardianForm');

            $("#addGuardianWizard").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
                labels: {
                    finish: "{{ trans('admin.global.save') }}",
                    next: "{{ trans('admin.global.next') }}",
                    previous: "{{ trans('admin.global.previous') }}"
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    if (currentIndex > newIndex) { return true; }

                    var currentGroup = 'step-' + (currentIndex + 1);
                    form.parsley().validate({ group: currentGroup });

                    return form.parsley().isValid({ group: currentGroup });
                },
                onFinishing: function (event, currentIndex) {
                    form.parsley().validate({ group: 'step-3' });
                    return form.parsley().isValid({ group: 'step-3' });
                },
                onFinished: function (event, currentIndex) {
                    $('#phone_father_hidden').val(itiFather.getNumber());

                    if($('#phone_mother_input').val()) {
                        $('#phone_mother_hidden').val(itiMother.getNumber());
                    }

                    form.submit();
                }
            });

            $('#addModal').on('hidden.bs.modal', function () {
                $("#addGuardianWizard").steps("reset");
                form.parsley().reset();
                form[0].reset();
            });

            (function($) {
                if($('#attachments').length) {
                    $('#attachments').FancyFileUpload({
                        params : { action : 'fileuploader' },
                        maxfilesize : 2000000
                    });
                }
            })(jQuery);

            $('.dropify').dropify({
                messages: {
                    'default': '{{__('admin.global.dropify.drag_drop')}}',
                    'replace': '{{__('admin.global.dropify.replace')}}',
                    'remove': '{{__('admin.global.delete')}}',
                    'error': '{{__('admin.global.dropify.error')}}'
                }
            });
        });
    </script>
@endpush
