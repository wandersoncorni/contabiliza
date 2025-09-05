<style>
    .accordion-item.is-invalid {
        border-color: #dc3545 !important;

    }

</style>
<div class="row">
    <div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="btn-toolbar d-flex mb-3">
                    <button type="button" class="btn btn-sm btn-tertiary ms-auto d-flex" id="add-partner" disabled>
                        <i class="heroicon heroicon-plus-circle me-2"></i> Adicionar sócio
                    </button>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="progress-wrapper mt-2 mb-3">
                    <div class="progress-info">
                        <div class="h6 mb-0 me-3">Participação dos sócios</div>
                        <div class="small fw-bold text-gray-500">
                            <span id="percent-total">0 %</span>
                        </div>
                    </div>
                    <div class="progress mb-0">
                        <div class="progress-bar bg-info" role="progressbar" id="partner-progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                </div>
            </div>
            <div id="partners-container"></div>
        </div>
    </div>
</div>
