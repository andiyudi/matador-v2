<script>
    $(document).ready(function() {
        $('#printSchedule').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var tenderData = button.data('tender');
            var leadNameSelect = $('#selectLeadName');
            leadNameSelect.empty();
            $.ajax({
                url: route("offer.official"),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(index, official) {
                        leadNameSelect.append($('<option>', {
                            value: official.id,
                            text: official.name,
                            selected: official.id == tenderData.procurement.official_id
                        }));
                    });
                    var selectedOfficialName = leadNameSelect.find('option:selected').text();
                    $('#leadName').val(selectedOfficialName);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            leadNameSelect.on('change', function() {
                var leadName = leadNameSelect.find('option:selected').text();
                $('#leadName').val(leadName);
            });
            $('#printFormSchedule').submit(function (e) {
            e.preventDefault();
                var leadName = $('#leadName').val();
                var leadPosition = $('#leadPosition').val();
                var secretaryName = $('#secretaryName').val();
                var secretaryPosition = $('#secretaryPosition').val();

                var button = $(event.relatedTarget);
                var id = button.data('tender');

                var printUrl = route('schedule.print', id) +
                    '?leadName=' + encodeURIComponent(leadName) +
                    '&leadPosition=' + encodeURIComponent(leadPosition) +
                    '&secretaryName=' + encodeURIComponent(secretaryName) +
                    '&secretaryPosition=' + encodeURIComponent(secretaryPosition);

                window.open(printUrl, '_blank');

                $('#printSchedule').modal('hide');

                $('#printFormSchedule')[0].reset();

                location.reload();
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#printAanwijzing').on('show.bs.modal', function(event) {
            var buttonAanwijzing = $(event.relatedTarget);
            var tenderData = buttonAanwijzing.data('tender');
            var leadAanwijzingNameSelect = $('#selectLeadAanwijzingName');
            leadAanwijzingNameSelect.empty();
            $.ajax({
                url: route("offer.official"),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(index, official) {
                        leadAanwijzingNameSelect.append($('<option>', {
                            value: official.id,
                            text: official.name,
                            selected: official.id == tenderData.procurement.official_id
                        }));
                    });
                    var selectedOfficialName = leadAanwijzingNameSelect.find('option:selected').text();
                    $('#leadAanwijzingName').val(selectedOfficialName);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            leadAanwijzingNameSelect.on('change', function() {
                var leadAanwijzingName = leadAanwijzingNameSelect.find('option:selected').text();
                $('#leadAanwijzingName').val(leadAanwijzingName);
            });
            $('#printFormAanwijzing').submit(function (e) {
            e.preventDefault();
                var leadAanwijzingName = $('#leadAanwijzingName').val();
                var leadAanwijzingPosition = $('#leadAanwijzingPosition').val();
                var secretaryAanwijzingName = $('#secretaryAanwijzingName').val();
                var secretaryAanwijzingPosition = $('#secretaryAanwijzingPosition').val();
                var aanwijzingNumber = $('#aanwijzingNumber').val();
                var aanwijzingDate = $('#aanwijzingDate').val();
                var aanwijzingLocation = $('#aanwijzingLocation').val();

                var buttonAanwijzing = $(event.relatedTarget);
                var id = buttonAanwijzing.data('tender');

                var printUrl = route('schedule.show', id) +
                    '?leadAanwijzingName=' + encodeURIComponent(leadAanwijzingName) +
                    '&leadAanwijzingPosition=' + encodeURIComponent(leadAanwijzingPosition) +
                    '&secretaryAanwijzingName=' + encodeURIComponent(secretaryAanwijzingName) +
                    '&secretaryAanwijzingPosition=' + encodeURIComponent(secretaryAanwijzingPosition) +
                    '&aanwijzingNumber=' + encodeURIComponent(aanwijzingNumber) +
                    '&aanwijzingDate=' + encodeURIComponent(aanwijzingDate) +
                    '&aanwijzingLocation=' + encodeURIComponent(aanwijzingLocation);

                window.open(printUrl, '_blank');

                $('#printAanwijzing').modal('hide');

                $('#printFormAanwijzing')[0].reset();

                location.reload();
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#printBanego').on('show.bs.modal', function(event) {
            var buttonBanego = $(event.relatedTarget);
            var tenderData = buttonBanego.data('tender');
            var leadBanegoNameSelect = $('#selectLeadBanegoName');
            leadBanegoNameSelect.empty();
            $.ajax({
                url: route("offer.official"),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(index, official) {
                        leadBanegoNameSelect.append($('<option>', {
                            value: official.id,
                            text: official.name,
                            selected: official.id == tenderData.procurement.official_id
                        }));
                    });
                    var selectedOfficialName = leadBanegoNameSelect.find('option:selected').text();
                    $('#leadBanegoName').val(selectedOfficialName);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            leadBanegoNameSelect.on('change', function() {
                var leadBanegoName = leadBanegoNameSelect.find('option:selected').text();
                $('#leadBanegoName').val(leadBanegoName);
            });
            $('#printFormBanego').submit(function (e) {
            e.preventDefault();
                var leadBanegoName = $('#leadBanegoName').val();
                var leadBanegoPosition = $('#leadBanegoPosition').val();
                var secretaryBanegoName = $('#secretaryBanegoName').val();
                var secretaryBanegoPosition = $('#secretaryBanegoPosition').val();
                var banegoNumber = $('#banegoNumber').val();
                var banegoDate = $('#banegoDate').val();
                var banegoLocation = $('#banegoLocation').val();

                var buttonBanego = $(event.relatedTarget);
                var id = buttonBanego.data('tender');

                var printUrl = route('schedule.detail', id) +
                    '?leadBanegoName=' + encodeURIComponent(leadBanegoName) +
                    '&leadBanegoPosition=' + encodeURIComponent(leadBanegoPosition) +
                    '&secretaryBanegoName=' + encodeURIComponent(secretaryBanegoName) +
                    '&secretaryBanegoPosition=' + encodeURIComponent(secretaryBanegoPosition) +
                    '&banegoNumber=' + encodeURIComponent(banegoNumber) +
                    '&banegoDate=' + encodeURIComponent(banegoDate) +
                    '&banegoLocation=' + encodeURIComponent(banegoLocation);

                window.open(printUrl, '_blank');

                $('#printBanego').modal('hide');

                $('#printFormBanego')[0].reset();

                location.reload();
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#printTinjau').on('show.bs.modal', function(event) {
            var buttonTinjau = $(event.relatedTarget);
            var tenderData = buttonTinjau.data('tender');
            var leadTinjauNameSelect = $('#selectLeadTinjauName');
            leadTinjauNameSelect.empty();
            $.ajax({
                url: route("offer.official"),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(index, official) {
                        leadTinjauNameSelect.append($('<option>', {
                            value: official.id,
                            text: official.name,
                            selected: official.id == tenderData.procurement.official_id
                        }));
                    });
                    var selectedOfficialName = leadTinjauNameSelect.find('option:selected').text();
                    $('#leadTinjauName').val(selectedOfficialName);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            leadTinjauNameSelect.on('change', function() {
                var leadTinjauName = leadTinjauNameSelect.find('option:selected').text();
                $('#leadTinjauName').val(leadTinjauName);
            });
            $('#printFormTinjau').submit(function (e) {
            e.preventDefault();
                var leadTinjauName = $('#leadTinjauName').val();
                var leadTinjauPosition = $('#leadTinjauPosition').val();
                var secretaryTinjauName = $('#secretaryTinjauName').val();
                var secretaryTinjauPosition = $('#secretaryTinjauPosition').val();
                var tinjauDate = $('#tinjauDate').val();
                var tinjauLocation = $('#tinjauLocation').val();

                var buttonTinjau = $(event.relatedTarget);
                var id = buttonTinjau.data('tender');

                var printUrl = route('schedule.view', id) +
                    '?leadTinjauName=' + encodeURIComponent(leadTinjauName) +
                    '&leadTinjauPosition=' + encodeURIComponent(leadTinjauPosition) +
                    '&secretaryTinjauName=' + encodeURIComponent(secretaryTinjauName) +
                    '&secretaryTinjauPosition=' + encodeURIComponent(secretaryTinjauPosition) +
                    '&tinjauDate=' + encodeURIComponent(tinjauDate) +
                    '&tinjauLocation=' + encodeURIComponent(tinjauLocation);

                window.open(printUrl, '_blank');

                $('#printTinjau').modal('hide');

                $('#printFormTinjau')[0].reset();

                location.reload();
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#printUndangan').on('show.bs.modal', function(event) {
            var buttonInvitation = $(event.relatedTarget);
            var tenderData = buttonInvitation.data('tender');
            var leadInvitationNameSelect = $('#selectLeadInvitationName');
            leadInvitationNameSelect.empty();
            $.ajax({
                url: route("offer.official"),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(index, official) {
                        leadInvitationNameSelect.append($('<option>', {
                            value: official.id,
                            text: official.name,
                            selected: official.id == tenderData.procurement.official_id
                        }));
                    });
                    var selectedOfficialName = leadInvitationNameSelect.find('option:selected').text();
                    $('#leadInvitationName').val(selectedOfficialName);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            leadInvitationNameSelect.on('change', function() {
                var leadInvitationName = leadInvitationNameSelect.find('option:selected').text();
                $('#leadInvitationName').val(leadInvitationName);
            });
            $('#printFormUndangan').submit(function (e) {
            e.preventDefault();
                var leadInvitationName = $('#leadInvitationName').val();
                var leadInvitationPosition = $('#leadInvitationPosition').val();
                var invitationNumber = $('#invitationNumber').val();
                var invitationDate = $('#invitationDate').val();
                var meetingDate = $('#meetingDate').val();
                var meetingTime = $('#meetingTime').val();
                var meetingLocation = $('#meetingLocation').val();
                var zoomId = $('#zoomId').val();
                var zoomPass = $('#zoomPass').val();

                var buttonInvitation = $(event.relatedTarget);
                var id = buttonInvitation.data('tender');

                var printUrl = route('schedule.invitation', id) +
                    '?leadInvitationName=' + encodeURIComponent(leadInvitationName) +
                    '&leadInvitationPosition=' + encodeURIComponent(leadInvitationPosition) +
                    '&invitationNumber=' + encodeURIComponent(invitationNumber) +
                    '&invitationDate=' + encodeURIComponent(invitationDate) +
                    '&meetingDate=' + encodeURIComponent(meetingDate) +
                    '&meetingTime=' + encodeURIComponent(meetingTime) +
                    '&meetingLocation=' + encodeURIComponent(meetingLocation) +
                    '&zoomId=' + encodeURIComponent(zoomId) +
                    '&zoomPass=' + encodeURIComponent(zoomPass);

                window.open(printUrl, '_blank');

                $('#printUndangan').modal('hide');

                $('#printFormUndangan')[0].reset();

                location.reload();
            });
        });
        const zoomIdSelect = document.getElementById('zoomId');
        const zoomPassInput = document.getElementById('zoomPass');

        zoomIdSelect.addEventListener('change', function () {
            const selectedZoomId = this.value;
            if (selectedZoomId === '582 973 5145') {
                zoomPassInput.value = 'Pengadaan 1';
            } else if (selectedZoomId === '473 477 1443') {
                zoomPassInput.value = 'CMNP';
            } else {
                zoomPassInput.value = ''; // Clear the passcode if no valid Zoom ID is selected
            }
        });
    });
</script>
