// Variables to keep track of pagination state
var currentPage = 1;
var rowsPerPage = 15;

$(document).ready(function () {
  // Event handler for supplier ID change
  $('#supplier_id').change(onSupplierChange);

  // Event handler for PO number change
  $('#po_number').change(onPONumberChange);

  // Event handler for weight option change
  $('input[name="weight_option"]').change(onWeightOptionChange);

  // Event handler for form submission
  $('form').submit(validateForm);

  // Event handler for "Generate Batch Numbers" button click
  $('#generateBatchNumbersBtn').click(generateBatchNumbers);

  // Event handler for "Print Batch Numbers" button click
  $('#printBatchNumbersBtn').click(printBatchNumbers);

  // Event handler for "Print Report" button click
  $('#printReportBtn').click(printReport);
});

// Function to handle form validation
function validateForm(event) {
  event.preventDefault(); // Prevent form submission

  // Validate supplier ID
  var supplierId = $('#supplier_id').val();
  if (!supplierId) {
    alert('Please select a supplier.');
    return;
  }

  // Validate PO number
  var poNumber = $('#po_number').val();
  if (!poNumber) {
    alert('Please select a PO number.');
    return;
  }

  // Validate inventory type
  var inventoryType = $('#inventory_type_id').val();
  if (!inventoryType) {
    alert('Please select an inventory type.');
    return;
  }

  // Validate product name
  var inventoryType = $('#part_name_id').val();
  if (!inventoryType) {
    alert('Please select product name.');
    return;
  }

  // Validate batch prefix
  var batchPrefix = $('#batch_prefix_id').val();
  if (!batchPrefix) {
    alert('Please select a batch prefix.');
    return;
  }

  // Validate quantity delivered
  var bags = parseInt($('#bags').val());
  if (isNaN(bags) || bags <= 0) {
    alert('Please enter a valid quantity delivered.');
    return;
  }

  // Validate weight per bag
  var weight = parseFloat($('#weight').val());
  if (isNaN(weight) || weight <= 0) {
    alert('Please enter a valid weight per bag.');
    return;
  }

  generateBatchNumbers();
}

function onSupplierChange() {
  var supplierId = $(this).val();
  if (supplierId) {
    toggleElements(true);
    $.request('onShowPONumbers', {
      data: { supplier_id: supplierId },
      success: function (data) {
        console.log('AJAX Response Data:', data);
        populatePONumbers(data.poNumbers);
        $('#supplier_batch').val(data.supplierBatch);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('Failed to fetch PO numbers');
      }
    });
  } else {
    toggleElements(false);
  }
}

// Function to toggle elements based on supplier ID
function toggleElements(show) {
  $('#po_numbers_wrapper, #inventory_type_select, #batch_prefix_select').toggle(show);
}

// Function to handle PO number change
function onPONumberChange() {
  var poNumber = $('#po_number').val();
  if (poNumber) {
    $.request('onSelectPO', {
      data: { po_number: poNumber },
      success: function (data) {
        console.log('AJAX Response Data:', data);
        if (data.poDetails && data.supplier_batch) {
          // Populate the PO details
          populatePODetails(data.poDetails);

          // Set the supplier batch in the hidden input
          $('#supplier_batch').val(data.supplier_batch);
        } else {
          console.error('Failed to retrieve PO details or supplier batch.');
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Failed to retrieve PO details or supplier batch.');
      }
    });
  } else {
    console.error('Invalid PO number.');
  }
  $('#receiving_form').show();
  $('#bag_details_table').hide();
}

// Function to populate PO details
function populatePODetails(poDetails) {
    // Clear previous details
    $('#po_details_container').empty();

    // Display PO details
    $('#po_details_container').append('<p>PO Number: ' + poDetails.po_number + '</p>');
    $('#po_details_container').append('<p>Supplier: ' + poDetails.supplier + '</p>');
}


// Function to handle weight option change
function onWeightOptionChange() {
  var option = $(this).val();
  $('input[name="weight"]').toggle(option !== 'different').prop('disabled', option === 'different');
}

// Function to populate PO numbers dropdown
function populatePONumbers(poNumbers) {
  var $poNumberSelect = $('#po_number');
  $poNumberSelect.empty(); // Clear previous options
  poNumbers.forEach(function (poNumber) {
    $poNumberSelect.append(new Option(poNumber, poNumber));
  });
}

// Function to generate batch numbers for the current page
function generateBatchNumbers() {
    event.preventDefault();
    console.log('Generating batch numbers for page ' + currentPage + '...');

    // Check if batch prefix is selected
    var batchPrefix = $('#batch_prefix_id option:selected').text();
    if (!batchPrefix) {
        alert('Please select a batch prefix.');
        return;
    }

    // Get the current date in YYYYMMDD format
    var currentDate = new Date();
    var dateString = currentDate.toISOString().slice(0, 10).replace(/-/g, "");

    // Get batch required option
    var batchRequired = $('input[name="batch_required"]:checked').val();

    // Retrieve the supplier batch
    var supplierBatch = $('#supplier_batch').val();

    // Get the start and end indexes for the current page
    var startIndex = (currentPage - 1) * rowsPerPage + 1;
    var endIndex = Math.min(startIndex + rowsPerPage - 1, parseInt($('#bags').val()));

    // Clear previous rows from the table body
    var tbody = $('#bag_details_table tbody');
    tbody.empty();

    // Initialize sum of weight and sum of actual weight
    var sumOfWeight = 0;
    var sumOfActual = 0;

    // Loop through each bag to generate batch numbers and create table rows
    for (var i = startIndex; i <= endIndex; i++) {
        // Generate batch number
        var batchNumber = "";
        if (batchRequired === 'yes') {
            batchNumber = dateString + batchPrefix + '-' + i;
        } else {
            batchNumber = supplierBatch + batchPrefix + '-' + i;
        }

        // Get the weight per bag from the input field
        var bags = parseInt($('#bags').val());
        var weight = parseFloat($('#weight').val());
        var weightPerBag = weight / bags;

        // Construct QR code data object
        var qrCodeData = {
            'batch_number': batchNumber,
            'bag_number': i,
            'weight_per_bag': weightPerBag,
            'po_number': $('#po_number').val(),
            'supplier_name': $('#supplier_id option:selected').text(),
            'batch_prefix_id': batchPrefix
        };

        // Convert QR code data object to a JSON string
        var qrCodeText = JSON.stringify(qrCodeData);

        // Construct table row HTML
        var row = '<tr><td>' + i + '</td>';

        // Add input field for bag weight if different weight option is selected
        if ($('input[name="weight_option"]:checked').val() === 'different') {
            row += '<td><input type="number" name="bag_weight[]" placeholder="Weight"></td>';
        } else {
            row += '<td>' + weightPerBag.toFixed(2) + '</td>';
        }

        // Add batch number
        row += '<td>' + batchNumber + '</td>';

        // Add table row to the tbody
        tbody.append(row);

        // Calculate total weight
        sumOfWeight += parseFloat(weightPerBag);
    }

    // Display sum of weight
    $('#total_weight').text(sumOfWeight);
    $('#sum_of_weight').show();

    // Show the bag details table
    $('#bag_details_table').show();
    updateCurrentPageDisplay();

    // Show pagination controls
    $('.pagination').show();
}




// Function to save actual weight
function saveActualWeight(value) {
  console.log('Actual weight saved: ' + value);
}

// Function to go to the previous page
function goToPreviousPage() {
  if (currentPage > 1) {
    currentPage--;
    generateBatchNumbers();
  }
}

// Function to go to the next page
function goToNextPage() {
  var maxPages = Math.ceil(parseInt($('#bags').val()) / rowsPerPage);
  if (currentPage < maxPages) {
    currentPage++;
    generateBatchNumbers();
  }
}

// Function to update the display of current page number
function updateCurrentPageDisplay() {
  $('#currentPage').text(currentPage);
}

function printBatchNumbers() {
    var bags = parseInt($('#bags').val());


    if (!isNaN(bags) && bags > 0) {

        var currentDate = new Date();
        var dateString = currentDate.toISOString().slice(0, 10).replace(/-/g, "");

        var printWindow = window.open('', '_MaterialBatch');

        printWindow.document.open();
        printWindow.document.write('<html><head><title>Batch Numbers</title>');

        printWindow.document.write('<style>body { font-family: Arial, sans-serif; }</style>');
        printWindow.document.write('<style>.qr-code-container { text-align: center; padding: 20px; }</style>');
        printWindow.document.write('<style>.qr-code { display: inline-block; }</style>');
        printWindow.document.write('<style>.batch-number { font-size: 45px; }</style>');
        printWindow.document.write('<style>@media print { .qr-code-container { page-break-before: always; } }</style>');
        printWindow.document.write('</head><body>');

        // Retrieve the selected batch prefix
        var batchPrefix = $('#batch_prefix_id option:selected').text();

        if (!batchPrefix) {
            alert('Please select a batch prefix.');
            return;
        }

        var supplier = $('#part_name_id option:selected').text();

        // Retrieve the supplier batch
        var supplierBatch = $('#supplier_batch').val();
        // Generate QR codes for each bag
        for (var i = 1; i <= bags; i++) {
            var batchNumber = "";
            // Check if batch is required
            var batchRequired = $('input[name="batch_required"]:checked').val();
            if (batchRequired === 'yes') {
                batchNumber = dateString + batchPrefix + '-' + i;
            } else {
                batchNumber = supplierBatch + batchPrefix + '-' + i;
            }

            var bagDetailsUrl = window.location.hostname+ "/inventory" + "/" + 'bagdetailsform?bags=' + i + '&batchNumber=' + batchNumber + '&batchPrefix=' + batchPrefix;
            var qrCodeHtml = '<div class="qr-code-container">';
            qrCodeHtml += '<p class="batch-number" style="font-weight: bold; margin-bottom: 10px;">Batch Number: ' + batchNumber + '</p>';
            qrCodeHtml += '<div class="qr-code" id="qrcode-' + i + '"></div>';
            qrCodeHtml += '<p class="batch-number" style="font-weight: bold; margin-bottom: 10px;">Product Name: ' + supplier + '</p></div>';
           

            printWindow.document.write(qrCodeHtml);

            new QRCode(printWindow.document.getElementById('qrcode-' + i), {
                text: bagDetailsUrl,
                width: 780,
                height: 800,
                displayText: { visibility: false },
                mode: 'canvas',
            });
        }

        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    } else {
        alert('Please enter a valid number of bags.');
    }
}



function printReport() {
    // Get total bags and total weight
    var totalBags = parseInt($('#bags').val());
    var totalWeight = parseFloat($('#weight').val());


    var printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: "Arial", sans-serif; background-color: #f5f5f5; margin: 10px; }');
    printWindow.document.write('table { width: 100%; border-collapse: separate; border-spacing: 0; margin-bottom: 10px; border-radius: 10px; overflow: hidden; }');
    printWindow.document.write('th, td { padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #1d2240; color: #fff; font-weight: bold; }');
    printWindow.document.write('tr:nth-child(even) { background-color: #f2f2f2; }');
    printWindow.document.write('.totals-row { background-color: #1d2240; color: #fff; font-weight: bold; }');
    printWindow.document.write('.totals-row td { border-color: #1d2240; padding: 10px; }');
    printWindow.document.write('@page { size: A4; margin: 10px; }');
    printWindow.document.write('@media print { table { page-break-inside: auto; } tr { page-break-inside: avoid; page-break-after: auto; } }');
    printWindow.document.write('.header { background-color: #ddd; color: #151414; padding: 15px 0; }');
    printWindow.document.write('.header img { max-width: 180px; margin-bottom: 5px; }');
    printWindow.document.write('.header h1 { margin: 0; font-size: 22px; font-weight: bold; margin-bottom: 5px; }');
    printWindow.document.write('.header p { margin: 0; font-size: 14px; }');
    printWindow.document.write('.section { margin-top: 10px; }');
    printWindow.document.write('.section-title { background-color: #ddd; padding: 5px; }');
    printWindow.document.write('.section-content { border: 1px solid #ccc; border-radius: 10px; padding: 10px; margin-top: 5px; }');
    printWindow.document.write('.section-content h3 { font-size: 14px; margin: 0; padding: 0; }');
    printWindow.document.write('.section-content p { margin: 2px; padding: 2px; }');
    printWindow.document.write('.section-content table { width: 100%; border-collapse: collapse; margin-top: 5px; }');
    // printWindow.document.write('.section-content table td { border: 1px solid #ccc; padding: 8px; }');
    printWindow.document.write('.signature-table td { width: 16%; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');

    // Add BT Industrial Group header
    var receivedDate = getCurrentDate();
    var selectedPONumber = $('#po_number').val();
    var selectedSupplierName = $('#supplier_id option:selected').text();

    printWindow.document.write('<div class="header">');
    printWindow.document.write('<div style="display: flex; justify-content: space-between; align-items: center; padding: 0 10px;">');
    printWindow.document.write('<div>');
    printWindow.document.write('<img src="http://bailaerp.bt-industrial.co.za/themes/hambern-hambern-blank-bootstrap-4/assets/images/BT-logos-02.png" alt="BT Industrial" style="max-width: 180px; margin-bottom: 5px;">');
    printWindow.document.write('<h3 style="margin: 0;">Received Date: ' + receivedDate + '</h3>');
    printWindow.document.write('</div>');
    printWindow.document.write('<div style="text-align: center;">');
    printWindow.document.write('<h1 style="margin: 0; font-size: 22px; font-weight: bold; margin-bottom: 5px;">BT INDUSTRIAL GROUP</h1>');
    printWindow.document.write('<p style="margin: 0; font-size: 14px;">11 Barnsley St, Benoni, Johannesburg, 1501</p>');
    printWindow.document.write('<p style="margin: 0; font-size: 14px;"><b>VAT NO:</b> 4090279110 | <b>P:</b> +27 10 109 1728 | <b>F:</b> +27 86 459 5761</p>');
    printWindow.document.write('<h2 style="margin: 0; font-size: 20px; margin-bottom: 10px;">RAW MATERIAL RECEIVING</h2>');
    printWindow.document.write('</div>');
    printWindow.document.write('</div>');
    printWindow.document.write('</div>');

    // Add received from section
    printWindow.document.write('<div class="section">');
    printWindow.document.write('<div class="section-title">Received From:</div>');
    printWindow.document.write('<div class="section-content">');
    printWindow.document.write('<p><strong>PO Number:</strong> ' + selectedPONumber + '</p>');
    printWindow.document.write('<p><strong>Supplier:</strong> ' + selectedSupplierName + '</p>');
    printWindow.document.write('</div>');

    // Add driver's information section
    printWindow.document.write('<div class="section">');
    printWindow.document.write('<div class="section-title">Driver Information:</div>');
    printWindow.document.write('<div class="section-content">');
    printWindow.document.write('<p><strong>Driver\'s Name: </strong> ' + $('#driver_name').val() + '</p>');
    printWindow.document.write('<p><strong>Truck Reg Number: </strong> ' + $('#truck_reg_number').val() + '</p>');
    printWindow.document.write('<p><strong>Truck Trailer Reg Number:</strong> ' + $('#truck_trailer_reg_number').val() + '</p>');
    printWindow.document.write('<p style="display: inline-block; margin-right: 20px;"><strong>Driver Signature:</strong></p>');
    printWindow.document.write('<p style="display: inline-block; border-bottom: 1px solid #000; width: 50%; margin: 0;">&nbsp;</p>');
    printWindow.document.write('<p><strong>Date:</strong> ' + receivedDate + '</p>');
    printWindow.document.write('</div>');

    // Add total bags and total weight section
    printWindow.document.write('<div class="section">');
    printWindow.document.write('<div class="section-title">Description:</div>');
    printWindow.document.write('<div class="section-content">');
    printWindow.document.write('<p><strong>Total Bags: </strong></td><td>' + totalBags + '</p>');
    printWindow.document.write('<p><strong>Total Weight: </strong></td><td>' + totalWeight + ' kg</p>');
    // Include disclaimer
    printWindow.document.write('<p><em>Please note: The weight provided above has not been verified by BT Industrial Group. Following verification, the actual weight from the scale will be provided.</em></p>');
    printWindow.document.write('</div>');


    // Add BT Operations Release section
    printWindow.document.write('<div class="section">');
    printWindow.document.write('<div class="section-content">');
    printWindow.document.write('<h4>BT Operations Release:</h4>');
    printWindow.document.write('<table class="signature-table">');
    printWindow.document.write('<tr><td >NAME:</td><td ></td><td >DATE:</td><td >' + receivedDate + '</td><td >SIGNATURE:</td><td ></td></tr>');
    printWindow.document.write('</table>');
    printWindow.document.write('</div>');
    printWindow.document.write('</div>');

    // Add BT Security Release section
    printWindow.document.write('<div class="section">');
    printWindow.document.write('<div class="section-content">');
    printWindow.document.write('<h3>BT Security Release:</h3>');
    printWindow.document.write('<table class="signature-table">');
    printWindow.document.write('<tr><td >NAME:</td><td ></td><td >DATE:</td><td >' + receivedDate + '</td><td >SIGNATURE:</td><td ></td></tr>');
    printWindow.document.write('</table>');
    printWindow.document.write('</div>');
    printWindow.document.write('</div>');

    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
function getCurrentDate() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var yyyy = today.getFullYear();

    return yyyy + '-' + mm + '-' + dd;
}
