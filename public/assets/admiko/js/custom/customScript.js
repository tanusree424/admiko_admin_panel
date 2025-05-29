$(document).ready(function() {

    $("#purchaseorders_table").on('click', '.view-order-summery', function() {
        let orderId = $(this).data('id');
        let url = $(this).data('url');
        let userId = $(this).data('userid');

        $("#exportPurchaseOrderExcel").attr("href", url+"/exportExcel/" + orderId);
        $("#exportPurchaseOrderPdf").attr("href", url+"/exportPdf/" + orderId + "/" + userId);
    $.ajax({
        url: "/admin/purchaseorders/" + orderId,
        type: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);

            let tableData = '';
            // Loop through the data and create table rows
            let count = 1;
            data.data.forEach(function(item){
                let highlightClass = item.orderqty < item.moq ? 'row-warning' : '';
                tableData+=`<tr class="${highlightClass}">
                        <td>${item.id}</td>
                        <td>${item.distributor_name}</td>
                        <td>${item.partcode}</td>
                        <td>${item.productname}</td>
                        <td>${item.catname}</td>
                        <td>${item.brand_name}</td>
                        <td>${item.part_description}</td>
                        <td>${item.ordertime}</td>
                        <td>${item.orderprice}</td>
                        <td>${item.moq}</td>
                        <td>${item.orderqty}</td>
                        <td>${item.updatedtime}</td>
                        <td>${item.excelid}</td>
                    </tr>`;
            })


            $('.puchaseOrderViewDetails .custom-modal-body tbody').html(tableData);
            $('.puchaseOrderViewDetails').fadeIn(); // Show modal
        },
        error: function (xhr, status, error) {
            console.error("Error fetching order summary:", xhr.responseText);
        }
    });
})

$("#AdminUserTable").on("click",".addUserShippingAddress", function(){
    let userId = $(this).data('id');
    let url = $(this).data('url');
    $("#adminUserAddShippingAddressModalSave").attr("data-id", userId);
    $("#adminUserAddShippingAddressModalSave").attr("data-url", url);
    $(".adminUserAddShippingAddressModal").fadeIn();
    let urlAddress = $(this).data('url') + "/getaddressByUserId/" + userId;
    getAddtessByUserId(userId, urlAddress);
});

$("#adminUserAddShippingAddressModalSave").on('click',function(){
    let billing_company_address = $("#billing_company_address").val();
    let shipping_company_address = $("#shipping_company_address").val();
    let userId = $(this).data('id');
    let urlPost = $(this).data('url') + `/addcompanyaddress`;
    $.ajax({
        url: urlPost,
        type: "POST",
        dataType: "json",
        data: {
            billing_company_address: billing_company_address,
            shipping_company_address: shipping_company_address,
            userId: userId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response);

            $(".adminUserAddShippingAddressModal").fadeOut();
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
        }
    });

    // write function to get address by userId


})

function getAddtessByUserId(userId, urlAddress){
    $.ajax({
        url: urlAddress,
        type: "GET",
        dataType: "json",
        success: function(data) {
            console.log('Data:::::::',data);
            $(".adminUserAddShippingAddressModal #billing_company_address").val(data.billing_address);
            $(".adminUserAddShippingAddressModal #shipping_company_address").val(data.shipping_address);
            if (data.shipping_company_address == "") {
                $("#billing_address_checkbox").prop("checked", false);
            } else {
                $("#billing_address_checkbox").prop("checked", true);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching order summary:", xhr.responseText);
        }
    });
}

$("#billing_address_checkbox").on('change', function() {
    if ($(this).is(':checked')) {
        $("#shipping_company_address").val($("#billing_company_address").val());
    } else {
        $("#shipping_company_address").val("");
    }
}
);


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


$("#salesreport_table").on('click','.view-sales-report-summery',function(){
    let orderId = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    $("#exportPSalesReportExcel").attr("href", url+"/exportExcel/" + orderId);
    // $("#exportPurchaseOrderPdf").attr("href", url+"/exportPdf/" + orderId + "/" + userId);
    console.log('url:::::::::', url);
$.ajax({
    url: url + "/" + orderId,
    type: "GET",
    dataType: "json",
    success: function(data) {
        console.log(data);
        let tableData = '';
        // Loop through the data and create table rows
        let count = 1;
        data.data.forEach(function(data){
            let highlightClass = data.orderqty < data.moq ? 'row-warning' : '';
            tableData+=` <tr>
						<td>${data.id}</td>
                        <td>${data.productname}</td>
                        <td>${data.catname}</td>
                        <td>${data.brand_name}</td>
                        <td>${data.part_description}</td>
						<td>${data.distributor_name}</td>
						<td>${data.invoicenumber}</td>
						<td>${data.invoicedate}</td>
						<td>${data.reportmonth}</td>
						<td>${data.week}</td>
						<td>${data.customername}</td>
						<td>${data.location}</td>
						<td>${data.channel}</td>
						<td>${data.qty}</td>
						<td>${data.originalunitprice}</td>
						<td>${data.grossamount}</td>
						<td>${data.createdtime}</td>
                    </tr>`;
        })

        $('.salesReportViewDetails .custom-modal-body tbody').html(tableData);
        $('.salesReportViewDetails').fadeIn(); // Show modal
    },
    error: function (xhr, status, error) {
        console.error("Error fetching order summary:", xhr.responseText);
    }
});
})


$("#stockreport_table").on('click','.view-stock-report-summery',function(){
    let orderId = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    $("#exportStockReportExcel").attr("href", url+"/exportExcel/" + orderId);
    // $("#exportPurchaseOrderPdf").attr("href", url+"/exportPdf/" + orderId + "/" + userId);
    console.log('url:::::::::', url);
    //stockReportViewDetails

    $.ajax({
        url: url + "/" + orderId,
        type: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);

            let tableData = '';
            // Loop through the data and create table rows
            let count = 1;
            data.data.forEach(function(data){
                let highlightClass = data.orderqty < data.moq ? 'row-warning' : '';
                tableData+=`<tr><td>${data.id}</td>
                <td>${data.distributor_name}</td>
						<td>${data.productid}</td>
                        <td>${data.productname}</td>
                        <td>${data.catname}</td>
                        <td>${data.brand_name}</td>
                        <td>${data.part_description}</td>
						<td>${data.stockinhand}</td>
                        <td>${data.createdtime}</td>
                        </tr>`;
            })


            $('.stockReportViewDetails .custom-modal-body tbody').html(tableData);
            $('.stockReportViewDetails').fadeIn(); // Show modal
        },
        error: function (xhr, status, error) {
            console.error("Error fetching order summary:", xhr.responseText);
        }
    });

})

/*
$("#purchaseorders_table").on('click','.delete-po-order',function(){
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/delete/${order_id}`;
    $.ajax({
        url: urlPost,
        type: "POST",
        dataType: "json",
        data: {
            order_id: order_id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
        }
    });
})
*/


$("#purchaseorders_table").on('click', '.delete-po-order', function() {
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/delete/${order_id}`;

    // Show a confirmation dialog
    if (confirm("Are you sure you want to delete this purchase order?")) {
        $.ajax({
            url: urlPost,
            type: "POST",
            dataType: "json",
            data: {
                order_id: order_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Reload the page or update the DOM if necessary
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    } else {
        // If the user cancels the confirmation
        console.log("Purchase Order deletion was canceled.");
    }
});


/*
$("#salesreport_table").on('click','.delete-sales-order',function(){
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/delete/${order_id}`;
    $.ajax({
        url: urlPost,
        type: "POST",
        dataType: "json",
        data: {
            order_id: order_id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
        }
    });
})
*/


$("#salesreport_table").on('click', '.delete-sales-order', function() {
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/delete/${order_id}`;

    // Show a confirmation dialog
    if (confirm("Are you sure you want to delete this sales ?")) {
        $.ajax({
            url: urlPost,
            type: "POST",
            dataType: "json",
            data: {
                order_id: order_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Reload the page or update the DOM if necessary
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    } else {
        // If the user cancels the confirmation
        console.log("sales  deletetion  was canceled.");
    }
});


$("#salesreport_table").on('click', '.confirm-order-btn', function() {
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/confirm/${order_id}`;

    // Show a confirmation dialog
    if (confirm("Are you sure you want to confirm this sales?")) {
        $.ajax({
            url: urlPost,
            type: "POST",
            dataType: "json",
            data: {
                order_id: order_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Reload the page or update the DOM if necessary
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    } else {
        // If the user cancels the confirmation
        console.log("sales confirmation was canceled.");
    }
});


/*

$("#stockreport_table").on('click','.delete-stock-report',function(){
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/delete/${order_id}`;
    $.ajax({
        url: urlPost,
        type: "POST",
        dataType: "json",
        data: {
            order_id: order_id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
        }
    });
})*/



$("#stockreport_table").on('click', '.delete-stock-report', function() {
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/delete/${order_id}`;

    // Show a confirmation dialog
    if (confirm("Are you sure you want to delete this stock ?")) {
        $.ajax({
            url: urlPost,
            type: "POST",
            dataType: "json",
            data: {
                order_id: order_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Reload the page or update the DOM if necessary
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    } else {
        // If the user cancels the confirmation
        console.log("stock  deletetion  was canceled.");
    }
});


$("#stockreport_table").on('click', '.confirm-order-btn', function() {
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/confirm/${order_id}`;

    // Show a confirmation dialog
    if (confirm("Are you sure you want to confirm this stock?")) {
        $.ajax({
            url: urlPost,
            type: "POST",
            dataType: "json",
            data: {
                order_id: order_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Reload the page or update the DOM if necessary
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    } else {
        // If the user cancels the confirmation
        console.log("stock confirmation was canceled.");
    }
});

/*

$("#purchaseorders_table").on('click','.confirm-order-btn',function(){
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/confirm/${order_id}`;

    $.ajax({
        url: urlPost,
        type: "POST",
        dataType: "json",
        data: {
            order_id: order_id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
        }
    });
})*/

$("#purchaseorders_table").on('click', '.confirm-order-btn', function() {
    let order_id = $(this).data('id');
    let url = $(this).data('url');
    let userId = $(this).data('userid');
    let urlPost = url + `/confirm/${order_id}`;

    // Show a confirmation dialog
    if (confirm("Are you sure you want to confirm this order?")) {
        $.ajax({
            url: urlPost,
            type: "POST",
            dataType: "json",
            data: {
                order_id: order_id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Reload the page or update the DOM if necessary
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error:", xhr.responseText);
            }
        });
    } else {
        // If the user cancels the confirmation
        console.log("Order confirmation was canceled.");
    }
});
// Inventory Stock
$("#inventorystocks_table").on('click', '.view-stock-detail', function (e) {
    e.preventDefault();
    console.log('Inventory stock detail clicked'); // ✅ Confirm this appears in console



});
});
