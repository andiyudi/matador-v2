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
                            <input type="text" class="form-control" value="SEKRETARIS" id="secretaryPosition" placeholder="Enter secretary position" required>
                        </div>
                        <div class="col mb-3">
                            <label for="leadPosition" class="form-label">Lead Position</label>
                            <select name="leadPosition" id="leadPosition" class="form-select" required>
                                <option value="TIM">TIM</option>
                                <option value="KETUA">KETUA</option>
                            </select>
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
                            <label for="aanwijzingNumber" class="form-label">Number</label>
                            <input type="text" id="aanwijzingNumber" name="aanwijzingNumber" class="form-control" data-mask="****/BA-PPKH-CMNP/****/****" data-mask-visible="true" placeholder="****/BA-PPKH-CMNP/****/****" autocomplete="off">
                        </div>
                        <div class="col mb-3">
                            <label for="aanwijzingDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="aanwijzingDate" name="aanwijzingDate" placeholder="Enter aanwijzing date" required>
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
                            <input type="hidden" class="form-control" id="aanwijzingLocation" name="aanwijzingLocation" value="PT. Citra Marga Nusaphala Persada, Tbk">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="leadAanwijzingPosition" class="form-label">Lead Position</label>
                            <select name="leadAanwijzingPosition" id="leadAanwijzingPosition" class="form-select" required>
                                <option value="TIM">TIM</option>
                                <option value="KETUA">KETUA</option>
                            </select>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
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
                            <select name="leadBanegoPosition" id="leadBanegoPosition" class="form-select" required>
                                <option value="TIM">TIM</option>
                                <option value="KETUA">KETUA</option>
                            </select>
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
<div class="modal fade" id="printTinjau" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="tinjauModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="printFormTinjau">
                <div class="modal-header">
                    <h5 class="modal-title" id="tinjauModalLabel">Print Berita Acara Peninjauan Lapangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="tinjauDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="tinjauDate" name="tinjauDate" placeholder="Enter tinjau date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="selectLeadTinjauName" class="form-label">Creator Name</label>
                            <select name="selectLeadTinjauName" id="selectLeadTinjauName" class="form-select">
                                <option value=""></option>
                            </select>
                            <input type="hidden" class="form-control" id="leadTinjauName" name="leadTinjauName" value="">
                        </div>
                        <div class="col mb-3">
                            <label for="secretaryTinjauName" class="form-label">Secretary Name</label>
                            <input type="text" class="form-control" id="secretaryTinjauName" value="{{ $tender->secretary }}" placeholder="Enter secretary name" required>
                            <input type="hidden" class="form-control" id="tinjauLocation" name="tinjauLocation" value="PT. Citra Marga Nusaphala Persada, Tbk">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="leadTinjauPosition" class="form-label">Lead Position</label>
                            <select name="leadTinjauPosition" id="leadTinjauPosition" class="form-select" required>
                                <option value="TIM">TIM</option>
                                <option value="KETUA">KETUA</option>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="secretaryTinjauPosition" class="form-label">Secretary Position</label>
                            <input type="text" class="form-control" value="SEKRETARIS" id="secretaryTinjauPosition" placeholder="Enter secretary position" required>
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
<div class="modal fade" id="printUndangan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="undanganModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="printFormUndangan">
                <div class="modal-header">
                    <h5 class="modal-title" id="undanganModalLabel">Print Undangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="invitationNumber" class="form-label">Number</label>
                            <input type="text" id="invitationNumber" name="invitationNumber" class="form-control" data-mask="****/Und-PPKH-CMNP/****/****" data-mask-visible="true" placeholder="****/Und-PPKH-CMNP/****/****" autocomplete="off">
                        </div>
                        <div class="col mb-3">
                            <label for="invitationDate" class="form-label">Invitation Date</label>
                            <input type="date" class="form-control" id="invitationDate" name="invitationDate" placeholder="Enter invitation date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="meetingDate" class="form-label">Meeting Date</label>
                            <input type="date" class="form-control" id="meetingDate" name="meetingDate" placeholder="Enter meeting date" required>
                        </div>
                        <div class="col mb-3">
                            <label for="meetingTime" class="form-label">Meeting Time</label>
                            <input type="text" class="form-control" id="meetingTime" name="meetingTime" placeholder="Enter meeting time" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="meetingLocation" class="form-label">Meeting Location</label>
                            <textarea name="meetingLocation" id="meetingLocation" class="form-control" cols="30" rows="3" required></textarea>
                        </div>
                        <div class="col mb-3">
                            <label for="meetingAgenda" class="form-label">Meeting Agenda</label>
                            <textarea name="meetingAgenda" id="meetingAgenda" class="form-control" cols="30" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="zoomId" class="form-label">Zoom ID</label>
                            <input type="text" class="form-control" name="zoomId" id="zoomId" required>
                        </div>
                        <div class="col mb-3">
                            <label for="zoomPass" class="form-label">Zoom Passcode</label>
                            <input type="text" class="form-control" name="zoomPass" id="zoomPass" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="selectLeadInvitationName" class="form-label">Creator Name</label>
                            <select name="selectLeadInvitationName" id="selectLeadInvitationName" class="form-select">
                                <option value=""></option>
                            </select>
                            <input type="hidden" class="form-control" id="leadInvitationName" name="leadInvitationName" value="">
                        </div>
                        <div class="col mb-3">
                            <label for="leadInvitationPosition" class="form-label">Lead Position</label>
                            <select name="leadInvitationPosition" id="leadInvitationPosition" class="form-select" required>
                                <option value="TIM">TIM</option>
                                <option value="KETUA">KETUA</option>
                            </select>
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
