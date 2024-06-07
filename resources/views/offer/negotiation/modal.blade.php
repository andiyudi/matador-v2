<div class="modal fade" id="printNegotiation" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="negotiationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="printFormNegotiation">
                <div class="modal-header">
                    <h5 class="modal-title" id="negotiationModalLabel">Print Negotiation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
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
                            <label for="leadPosition" class="form-label">Lead Position</label>
                            <select name="leadPosition" id="leadPosition" class="form-select" required>
                                <option value="TIM">TIM</option>
                                <option value="KETUA">KETUA</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
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
