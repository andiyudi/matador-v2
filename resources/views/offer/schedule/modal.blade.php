<div class="modal fade" id="printSchedule" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="printFormSchedule">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Print Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="secretaryName" class="form-label">Secretary Name</label>
                            <input type="text" class="form-control" id="secretaryName" value="{{ $tender->secretary }}" placeholder="Enter secretary name" required>
                        </div>
                        <div class="col mb-3">
                            <label for="selectLeadName" class="form-label">Creator Name</label>
                            <select name="selectLeadName" id="selectLeadName" class="form-select">
                                <option value=""></option>
                            </select>
                            <input type="hidden" class="form-control" id="leadName" name="leadName" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="secretaryPosition" class="form-label">Secretary Position</label>
                            <input type="text" class="form-control" value="Sekretaris PPKH" id="secretaryPosition" placeholder="Enter secretary position" required>
                        </div>
                        <div class="col mb-3">
                            <label for="leadPosition" class="form-label">Lead Position</label>
                            <input type="text" class="form-control" id="leadPosition" value="Ketua PPKH" placeholder="Enter lead position" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="printAanwijzing" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="aanwijzingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="printFormAanwijzing">
                <div class="modal-header">
                    <h5 class="modal-title" id="aanwijzingModalLabel">Print Aanwijzing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="number" class="form-label">Number</label>
                            <input type="text" id="number" name="number" class="form-control" data-mask="****/BA-PPKH-CMNP/****/****" data-mask-visible="true" placeholder="****/BA-PPKH-CMNP/****/****" autocomplete="off">
                        </div>
                        <div class="col mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="Enter aanwijzing date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="selectLeadAanwijzingName" class="form-label">Creator Name</label>
                            <select name="selectLeadAanwijzingName" id="selectLeadAanwijzingName" class="form-select">
                                <option value=""></option>
                            </select>
                            <input type="hidden" class="form-control" id="leadAanwijzingName" name="leadAanwijzingName" value="">
                        </div>
                        <div class="col mb-3">
                            <label for="secretaryAanwijzingName" class="form-label">Secretary Name</label>
                            <input type="text" class="form-control" id="secretaryAanwijzingName" value="{{ $tender->secretary }}" placeholder="Enter secretary name" required>
                            <input type="hidden" class="form-control" id="location" name="location" value="PT. Citra Marga Nusaphala Persada, Tbk">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="leadAanwijzingPosition" class="form-label">Lead Position</label>
                            <input type="text" class="form-control" id="leadAanwijzingPosition" value="TIM PPKH" placeholder="Enter lead position" required>
                        </div>
                        <div class="col mb-3">
                            <label for="secretaryAanwijzingPosition" class="form-label">Secretary Position</label>
                            <input type="text" class="form-control" value="SEKRETARIS" id="secretaryAanwijzingPosition" placeholder="Enter secretary position" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="printBanego" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="banegoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="printFormBanego">
                <div class="modal-header">
                    <h5 class="modal-title" id="banegoModalLabel">Print Berita Acara Negosiasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="banegoNumber" class="form-label">Number</label>
                            <input type="text" id="banegoNumber" name="banegoNumber" class="form-control" data-mask="****/BA-PPKH-CMNP/****/****" data-mask-visible="true" placeholder="****/BA-PPKH-CMNP/****/****" autocomplete="off">
                        </div>
                        <div class="col mb-3">
                            <label for="banegoDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="banegoDate" name="banegoDate" placeholder="Enter nego date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="selectLeadBanegoName" class="form-label">Creator Name</label>
                            <select name="selectLeadBanegoName" id="selectLeadBanegoName" class="form-select">
                                <option value=""></option>
                            </select>
                            <input type="hidden" class="form-control" id="leadBanegoName" name="leadBanegoName" value="">
                        </div>
                        <div class="col mb-3">
                            <label for="secretaryBanegoName" class="form-label">Secretary Name</label>
                            <input type="text" class="form-control" id="secretaryBanegoName" value="{{ $tender->secretary }}" placeholder="Enter secretary name" required>
                            <input type="hidden" class="form-control" id="banegoLocation" name="banegoLocation" value="PT. Citra Marga Nusaphala Persada, Tbk">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="leadBanegoPosition" class="form-label">Lead Position</label>
                            <input type="text" class="form-control" id="leadBanegoPosition" value="TIM PPKH" placeholder="Enter lead position" required>
                        </div>
                        <div class="col mb-3">
                            <label for="secretaryBanegoPosition" class="form-label">Secretary Position</label>
                            <input type="text" class="form-control" value="SEKRETARIS" id="secretaryBanegoPosition" placeholder="Enter secretary position" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
