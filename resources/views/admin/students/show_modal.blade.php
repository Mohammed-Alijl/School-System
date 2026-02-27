<!-- Show Student Modal -->
<div class="modal fade" id="showModal">
    <div class="modal-dialog modal-lg text-center" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header d-flex justify-content-between">
                <h6 class="modal-title font-weight-bold"><i class="fas fa-user-graduate text-primary mx-1"></i> {{ trans('admin.students.show') ?? 'Student Profile' }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                <!-- Header Card / Avatar Section -->
                <div class="card user-info-card shadow-sm mb-4 border-0 rounded-lg">
                    <div class="card-body p-3 d-flex align-items-center bg-light rounded-lg">
                        <img id="show_image" src="{{ URL::asset('assets/student/img/faces/boy_student.png') }}" alt="Student Avatar" class="avatar avatar-xxl brround bg-white shadow-sm mx-4" style="object-fit: cover;">
                        <div>
                            <h4 id="show_name" class="mb-1 font-weight-bold text-dark">Student Name</h4>
                            <p id="show_student_code" class="text-muted mb-0 font-weight-semibold"><i class="fas fa-barcode"></i> {{ trans('admin.students.fields.student_code') }}: <span></span></p>
                            <span id="show_status" class="badge badge-success mt-2 px-3 py-1">Active</span>
                        </div>
                    </div>
                </div>

                <!-- Info Sections -->
                <div class="row">
                    <!-- Academic Info -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary font-weight-bold mb-3 border-bottom pb-2"><i class="fas fa-graduation-cap mx-1"></i> {{ trans('admin.students.academic_information') }}</h6>
                        <ul class="list-unstyled mb-0 list-item-spacing">
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-primary-transparent text-primary mx-3"><i class="fas fa-school"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.students.fields.grade') }}</small> <span id="show_grade" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-info-transparent text-info mx-3"><i class="fas fa-chalkboard"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.students.fields.classroom') }}</small> <span id="show_classroom" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-secondary-transparent text-secondary mx-3"><i class="fas fa-school"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.students.fields.section') }}</small> <span id="show_section" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-warning-transparent text-warning mx-3"><i class="fas fa-calendar-alt"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.students.fields.academic_year') }}</small> <span id="show_academic_year" class="font-weight-semibold"></span></div>
                            </li>
                        </ul>
                    </div>

                    <!-- Personal & Guardian Info -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary font-weight-bold mb-3 border-bottom pb-2"><i class="fas fa-address-card mx-1"></i> {{ trans('admin.students.personal_information') }}</h6>
                        <ul class="list-unstyled mb-0 list-item-spacing">
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-success-transparent text-success mx-3"><i class="fas fa-envelope"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.students.fields.email') }}</small> <span id="show_email" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-danger-transparent text-danger mx-3"><i class="fas fa-id-card"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.students.fields.national_id') }}</small> <span id="show_national_id" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-info-transparent text-info mx-3"><i class="fas fa-birthday-cake"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.students.fields.date_of_birth') }}</small> <span id="show_date_of_birth" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-primary-transparent text-primary mx-3"><i class="fas fa-user-shield"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.students.fields.guardian') }}</small> <span id="show_guardian" class="font-weight-semibold"></span></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Demographics -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <h6 class="text-primary font-weight-bold mb-3 border-bottom pb-2"><i class="fas fa-globe mx-1"></i> {{ trans('admin.teachers.details') }}</h6>
                        <div class="row text-center bg-light rounded p-3 m-0 shadow-sm">
                            <div class="col-3 {{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right' }}">
                                <small class="text-muted d-block mb-1">{{ trans('admin.students.fields.gender') }}</small>
                                <span id="show_gender" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-3 {{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right' }}">
                                <small class="text-muted d-block mb-1">{{ trans('admin.students.fields.nationality') }}</small>
                                <span id="show_nationality" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-3 {{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right' }}">
                                <small class="text-muted d-block mb-1">{{ trans('admin.students.fields.religion') }}</small>
                                <span id="show_religion" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-3">
                                <small class="text-muted d-block mb-1">{{ trans('admin.students.fields.blood_type') }}</small>
                                <span id="show_blood_type" class="font-weight-bold text-danger"><i class="fas fa-tint mx-1"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="row" id="show_attachments_container" style="display: none;">
                    <div class="col-12">
                        <h6 class="text-primary font-weight-bold mb-3 border-bottom pb-2"><i class="fas fa-paperclip mx-1"></i> {{ trans('admin.students.fields.attachments') }}</h6>
                        <div class="d-flex flex-wrap gap-2" id="show_attachments_list">
                            <!-- Attachments will be rendered here via JS -->
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer pb-4 px-4">
                <button type="button" class="btn btn-secondary px-4 py-2" data-dismiss="modal">
                    <i class="fas fa-times mx-1"></i> {{ trans('admin.global.close') }}
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    .icon-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    .bg-primary-transparent { background-color: rgba(61, 80, 255, 0.1); }
    .bg-info-transparent { background-color: rgba(0, 204, 255, 0.1); }
    .bg-secondary-transparent { background-color: rgba(246, 38, 130, 0.1); }
    .bg-warning-transparent { background-color: rgba(255, 171, 0, 0.1); }
    .bg-success-transparent { background-color: rgba(0, 204, 115, 0.1); }
    .bg-danger-transparent { background-color: rgba(255, 71, 61, 0.1); }
    .avatar-xxl { width: 80px; height: 80px; }
    .list-item-spacing li { margin-bottom: 12px; }
    .badge { font-size: 13px; font-weight: 500; }
    .gap-2 { gap: 0.5rem; }
    .modal-content-demo { border: none; border-radius: 12px; overflow: hidden; }
    .modal-header { border-bottom: none; background: #fff; padding: 24px 24px 0; }
</style>
@push('scripts')
    <script>
        $(document).on('click', '.show-btn', function() {
            let btn = $(this);

            $('#show_name').text(btn.data('name_ar') + ' / ' + btn.data('name_en'));
            $('#show_student_code span').text(btn.data('student_code'));
            $('#show_email').text(btn.data('email'));
            $('#show_national_id').text(btn.data('national_id'));
            $('#show_date_of_birth').text(btn.data('date_of_birth'));

            $('#show_grade').text(btn.data('grade_name'));
            $('#show_classroom').text(btn.data('classroom_name'));
            $('#show_section').text(btn.data('section_name'));
            $('#show_academic_year').text(btn.data('academic_year'));
            $('#show_guardian').text(btn.data('guardian_name'));

            $('#show_gender').text(btn.data('gender'));
            $('#show_nationality').text(btn.data('nationality'));
            $('#show_religion').text(btn.data('religion'));
            $('#show_blood_type').html('<i class="fas fa-tint mx-1"></i> ' + btn.data('blood_type'));

            let statusText = btn.data('status');
            let statusBadge = $('#show_status');
            statusBadge.text(statusText);
            if (statusText === '{{ trans("admin.global.active") }}') {
                statusBadge.removeClass('badge-danger').addClass('badge-success');
            } else {
                statusBadge.removeClass('badge-success').addClass('badge-danger');
            }

            let profileImg = btn.data('image');
            if(profileImg) {
                $('#show_image').attr('src', profileImg);
            } else {
                $('#show_image').attr('src', "{{ URL::asset('assets/admin/img/faces/6.jpg') }}");
            }

            let attachments = btn.data('attachments') || [];
            if (typeof attachments === 'string') {
                try {
                    attachments = JSON.parse(attachments);
                } catch(e) {
                    attachments = [];
                }
            }
            let attachContainer = $('#show_attachments_container');
            let attachList = $('#show_attachments_list');

            attachList.empty();

            if(attachments.length > 0) {
                attachContainer.show();
                attachments.forEach(function(url) {
                    let name = url.split('/').pop();
                    let btnHtml = `<a href="${url}" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm mb-2 mx-2">
                                        <i class="fas fa-download mx-1"></i> ${name}
                                       </a>`;
                    attachList.append(btnHtml);
                });
            } else {
                attachContainer.hide();
            }
        });
    </script>
@endpush
