$(document).ready(function () {
    function fetchUserData() {
        $.ajax({
            url: 'http://localhost/new_hdpe/sticker/data',
            method: 'GET',
            success: function (data) {
                let rows = '';
                data.forEach(sticker => {
                    rows += `
                            <tr>
                                <td>${sticker.quote_item.quote_id}</td>
                                <td>${sticker.quote_item.quote.company_name}</td>
                                <td>${sticker.sticker_id}</td>
                            </tr>
                        `;
                });
                $('#userTable tbody').html(rows);
            }
        });
    }

    fetchUserData(); // Initial fetch
    setInterval(fetchUserData, 5000);
});// Fetch every 5 seconds
