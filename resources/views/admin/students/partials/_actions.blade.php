<div class="btn-icon-list">
    @can('edit_students')
        <a href="javascript:void(0)" class="btn btn-info btn-sm edit-btn"
           data-id="{{ $row->id }}"
           data-url="{{ route('admin.students.update', $row->id) }}"
           data-student_code="{{ $row->student_code }}"
           data-name_ar="{{ $row->getTranslation('name', 'ar') }}"
           data-name_en="{{ $row->getTranslation('name', 'en') }}"
           data-email="{{ $row->email }}"
           data-national_id="{{ $row->national_id }}"
           data-date_of_birth="{{ $row->date_of_birth ? $row->date_of_birth->format('d-m-Y') : '' }}"
           data-gender_id="{{ $row->gender_id }}"
           data-nationality_id="{{ $row->nationality_id }}"
           data-blood_type_id="{{ $row->blood_type_id }}"
           data-religion_id="{{ $row->religion_id }}"
           data-grade_id="{{ $row->grade_id }}"
           data-classroom_id="{{ $row->classroom_id }}"
           data-classroom_name="{{ $row->classroom ? $row->classroom->getTranslation('name', app()->getLocale()) : '' }}"
           data-section_id="{{ $row->section_id }}"
           data-section_name="{{ $row->section ? $row->section->getTranslation('name', app()->getLocale()) : '' }}"
           data-academic_year="{{ $row->academic_year }}"
           data-guardian_id="{{ $row->guardian_id }}"
           data-status="{{ $row->status }}"
           data-image="{{ $row->image_url }}"
           data-attachments="{{ collect($row->attachments)->toJson() }}"
           data-toggle="modal" data-target="#editModal"
           title="{{ trans('admin.global.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
    @endcan

    @can('delete_students')
        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-btn delete-item"
           data-id="{{ $row->id }}"
           data-toggle="modal" data-target="#deleteModal"
           data-url="{{ route('admin.students.destroy', $row->id) }}"
           data-name="{{ $row->name }}"
           title="{{ trans('admin.global.delete') }}">
            <i class="fas fa-trash-alt"></i>
        </a>
    @endcan
</div>
