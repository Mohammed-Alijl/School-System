<!-- Show Grade Modal -->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold" id="showModalLabel">
                    <i class="las la-info-circle tx-20 mr-1 ml-1 text-primary"></i> 
                    {{ __('admin.grades.show') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                
                <!-- Grade Info Banner -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-primary-transparent border-primary m-0" style="border-radius: 8px;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 ml-3">
                                        <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 10px;">
                                            <i class="las la-graduation-cap tx-24"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 tx-18 font-weight-bold tx-primary" id="show-grade-name">--</h4>
                                    </div>
                                    <div class="ml-auto mr-auto">
                                        <span id="show-status-badge" class="badge">--</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <h6 class="font-weight-bold tx-14 mb-2">{{ __('admin.grades.fields.notes') }}</h6>
                    <div class="p-3 bg-light rounded" id="show-notes" style="min-height: 50px;">
                        --
                    </div>
                </div>

                <!-- Classrooms List -->
                <div>
                    <h6 class="font-weight-bold tx-14 mb-3 d-flex align-items-center">
                        <i class="las la-layer-group mr-1 ml-1 text-primary"></i> {{ __('admin.grades.classrooms_list') }}
                        <span class="badge badge-pill badge-primary ml-auto mr-auto" id="show-classrooms-count">0</span>
                    </h6>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0 text-md-nowrap" id="classrooms-table">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin.classrooms.fields.name') }}</th>
                                    <th>{{ __('admin.classrooms.fields.status') }}</th>
                                </tr>
                            </thead>
                            <tbody id="classrooms-table-body">
                                <!-- Classrooms will be dynamically populated here via JS -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Empty State for Classrooms -->
                    <div id="no-classrooms-empty-state" class="text-center p-4 d-none bg-light rounded">
                        <i class="las la-folder-open tx-40 text-muted mb-2"></i>
                        <h6 class="text-muted mb-0">{{ __('admin.grades.no_classrooms') }}</h6>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal"><i class="las la-times"></i> {{ __('admin.global.close') }}</button>
            </div>
        </div>
    </div>
</div>
