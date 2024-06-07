
<script>
    $(document).ready(function() {
        $('#printNegotiation').on('show.bs.modal', function(event) {
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
            $('#printFormNegotiation').submit(function (e) {
            e.preventDefault();
                var leadName = $('#leadName').val();
                var leadPosition = $('#leadPosition').val();
                var date = $('#date').val();

                var button = $(event.relatedTarget);
                var id = button.data('tender');

                var printUrl = route('negotiation.show', id) +
                    '?leadName=' + encodeURIComponent(leadName) +
                    '&leadPosition=' + encodeURIComponent(leadPosition) +
                    '&date=' + encodeURIComponent(date);

                window.open(printUrl, '_blank');

                $('#printNegotiation').modal('hide');

                $('#printFormNegotiation')[0].reset();

                location.reload();
            });
        });
    });
</script>
