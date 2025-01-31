<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="printForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="printPopupLabel">Fill in the details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="selectCreatorName" class="form-label">Creator Name</label>
                            <select name="selectCreatorName" id="selectCreatorName" class="form-select">
                                <option value=""></option>
                            </select>
                            <input type="hidden" class="form-control" id="creatorName" name="creatorName" value="">
                        </div>
                        <div class="col mb-3">
                            <label for="supervisorName" class="form-label">Supervisor Name</label>
                            <input type="text" class="form-control" id="supervisorName" value="" placeholder="Enter supervisor name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="creatorPosition" class="form-label">Creator Position</label>
                            <input type="text" class="form-control" id="creatorPosition" value="Kasi Pengadaan" placeholder="Enter creator position" required>
                        </div>
                        <div class="col mb-3">
                            <label for="supervisorPosition" class="form-label">Supervisor Position</label>
                            <input type="text" class="form-control" value="Manajer Divisi Umum" id="supervisorPosition" placeholder="Enter supervisor position" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="printBtn">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#printModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var tenderData = button.data('tender');
            var creatorNameSelect = $('#selectCreatorName');
            creatorNameSelect.empty();
            $.ajax({
                url: route("offer.official"),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(index, official) {
                        creatorNameSelect.append($('<option>', {
                            value: official.id,
                            text: official.name,
                            selected: official.id == tenderData.procurement.official_id
                        }));
                    });
                    var selectedOfficialName = creatorNameSelect.find('option:selected').text();
                    $('#creatorName').val(selectedOfficialName);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            creatorNameSelect.on('change', function() {
                var creatorName = creatorNameSelect.find('option:selected').text();
                $('#creatorName').val(creatorName);
            });
            $('#printForm').submit(function (e) {
            e.preventDefault();
                var creatorName = $('#creatorName').val();
                var creatorPosition = $('#creatorPosition').val();
                var supervisorName = $('#supervisorName').val();
                var supervisorPosition = $('#supervisorPosition').val();

                var button = $(event.relatedTarget);
                var id = button.data('tender');

                var printUrl = route('offer.print', id) +
                    '?creatorName=' + encodeURIComponent(creatorName) +
                    '&creatorPosition=' + encodeURIComponent(creatorPosition) +
                    '&supervisorName=' + encodeURIComponent(supervisorName) +
                    '&supervisorPosition=' + encodeURIComponent(supervisorPosition);

                window.open(printUrl, '_blank');

                $('#printModal').modal('hide');

                $('#printForm')[0].reset();

                location.reload();
            });
        });
    });
</script>
