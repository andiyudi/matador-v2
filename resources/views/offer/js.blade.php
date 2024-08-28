<script>
    document.addEventListener("DOMContentLoaded", function () {
        const procurementSelect = document.getElementById('procurement_id');
        const nameInput = document.getElementById('name');
        const divisionInput = document.getElementById('division');

        procurementSelect.addEventListener('change', function () {
            const selectedOption = procurementSelect.options[procurementSelect.selectedIndex];
            const selectedName = selectedOption.getAttribute('data-name');
            const selectedDivision = selectedOption.getAttribute('data-division');
            nameInput.value = selectedName;
            divisionInput.value = selectedDivision;
        });
    });
</script>
<script>
// @formatter:off
document.addEventListener("DOMContentLoaded", function () {
    var el;
    window.TomSelect && (new TomSelect(el = document.getElementById('procurement_id'), {
        copyClassesToDropdown: false,
        dropdownParent: 'body',
        controlInput: '<input>',
        render:{
            item: function(data,escape) {
                if( data.customProperties ){
                    return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                }
                return '<div>' + escape(data.text) + '</div>';
            },
            option: function(data,escape){
                if( data.customProperties ){
                    return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                }
                return '<div>' + escape(data.text) + '</div>';
            },
        },
    }));
});
// @formatter:on
</script>
<script>
    // @formatter:off
document.addEventListener("DOMContentLoaded", function () {
    var el;
    window.TomSelect && (new TomSelect(el = document.getElementById('business'), {
        copyClassesToDropdown: false,
        dropdownParent: 'body',
        controlInput: '<input>',
        render:{
            item: function(data,escape) {
                if( data.customProperties ){
                    return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                }
                return '<div>' + escape(data.text) + '</div>';
            },
            option: function(data,escape){
                if( data.customProperties ){
                    return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                }
                return '<div>' + escape(data.text) + '</div>';
            },
        },
    }));
});
// @formatter:on
</script>
<script>
    $(document).ready(function () {
    const businessSelect = $('#business');
    const selectedPartnersList = $('#selected_partners_list');

    businessSelect.on('change', function () {
        selectedPartnersList.empty();
        const selectedBusinessId = businessSelect.val();

        $.ajax({
            url: "{{ route('partner.fetch', '') }}/" + selectedBusinessId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                const partners = response;
                console.log(partners);  // Check the response data

                if (partners.length === 0) {
                    const noDataMessage = `
                        <tr>
                            <td colspan="7" class="text-center">Data vendor dengan kategori ini tidak ditemukan</td>
                        </tr>
                    `;
                    selectedPartnersList.append(noDataMessage);
                } else {
                    partners.forEach(partner => {
                        if (!partner.business_partner_id) {
                            console.error('business_partner_id is undefined for partner:', partner);
                            return;  // Skip this iteration if the ID is undefined
                        }

                        let partnerStatus = '';
                        switch (partner.status) {
                            case '0': partnerStatus = 'Registered'; break;
                            case '1': partnerStatus = 'Active'; break;
                            case '2': partnerStatus = 'Inactive'; break;
                            default: partnerStatus = 'Unknown'; break;
                        }

                        let formattedEndDeed = '';
                        if (partner.end_deed) {
                            const endDeedDate = new Date(partner.end_deed);
                            formattedEndDeed = `${endDeedDate.getDate()}-${endDeedDate.getMonth() + 1}-${endDeedDate.getFullYear()}`;
                        }

                        const row = `
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_partners[]" value="${partner.business_partner_id}">
                                </td>
                                <td>${partner.name}</td>
                                <td>${partnerStatus}</td>
                                <td>${partner.director}</td>
                                <td>${partner.phone}</td>
                                <td>${partner.email}</td>
                                <td>${formattedEndDeed}</td>
                            </tr>
                        `;
                        selectedPartnersList.append(row);
                    });
                }
            },
            error: function (error) {
                console.error('Error fetching partners:', error);
                alert('Error fetching partners: ' + error.responseText);
            }
        });
    });
});
</script>

