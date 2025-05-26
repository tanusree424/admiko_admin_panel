$(document).ready(function() {

    $("#purchaseorders_table").on('click', '.view-order-summery', function() {
        let orderId = $(this).data('id');
        let url = $(this).data('url');

        $("#exportPurchaseOrderExcel").attr("href", url+"/exportExcel/" + orderId);
        $("#exportPurchaseOrderPdf").attr("href", url+"/exportPdf/" + orderId);
    $.ajax({
        url: "/admin/purchaseorders/" + orderId,
        type: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);

            let tableData = '';
            // Loop through the data and create table rows
            data.data.forEach(function(item){
                let highlightClass = item.orderqty < item.moq ? 'row-warning' : '';
                tableData+=`<tr class="${highlightClass}">
                        <td>${item.id}</td>
                        <td>${item.distributorid}</td>
                        <td>${item.partcode}</td>
                        <td>${item.ordertime}</td>
                        <td>${item.orderprice}</td>
                        <td>${item.moq}</td>
                        <td>${item.orderqty}</td>
                        <td>${item.updatedtime}</td>
                        <td>${item.excelid}</td>
                        <td>
                        <a href="/admin/purchaseorders/${item.id}/edit" target="_blank" class="edit-link" draggable="false">
                        <svg width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
  <path d="M12.146.146a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708L4.207 14.5H1v-3.207L12.146.146zM11.207 2L14 4.793 13.207 5.5 10.414 2.707 11.207 2z"/></svg>
                        </a>
                        </td>
                        <td>
                          <a data-id="${item.id}" class="delete-link js-ak-delete-link" class="edit-link" draggable="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5H6a.5.5 0 0 1-.5-.5v-8z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2H5V1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5V2h2.5a1 1 0 0 1 1 1zM6 2h4v-.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5V2z"/>
</svg> </a>

                        </td>
                    </tr>`;
            })


            $('#customModal .custom-modal-body tbody').html(tableData);
            $('#customModal').fadeIn(); // Show modal
        },
        error: function (xhr, status, error) {
            console.error("Error fetching order summary:", xhr.responseText);
        }
    });
})



// Close modal when clicking close icon
$(document).on('click', '.custom-modal-close', function () {
    $('#customModal').fadeOut();
});

// Optional: close when clicking outside modal content
$(window).on('click', function (event) {
    if ($(event.target).is('#customModal')) {
        $('#customModal').fadeOut();
    }
});


// Open the modal
function openCustomModal(dataHtml) {
    const $modal = $('#customModal');
    $modal.find('tbody').html(dataHtml);
    $modal.fadeIn(); // Show the modal
}

// Close modal when clicking close buttons
$('.custom-modal-close, #modalCloseBtn').on('click', function() {
    $('#customModal').fadeOut();
});

});