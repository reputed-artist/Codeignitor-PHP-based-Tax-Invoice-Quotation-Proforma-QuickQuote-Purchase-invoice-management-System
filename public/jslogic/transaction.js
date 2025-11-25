/* -------------------- Bootstrap Custom File Input Label ------------------- */

// $(".custom-file-input").on("change", function() {
//     let fileName = $(this).val().split("\\").pop();
//     let label = $(this).siblings(".custom-file-label");

//     if (label.data("default-title") === undefined) {
//         label.data("default-title", label.html());
//     }

//     if (fileName === "") {
//         label.removeClass("selected").html(label.data("default-title"));
//     } else {
//         label.addClass("selected").html(fileName);
//     }
// });
// $(document).on('hidden.bs.modal', function () {
//     $('.modal-backdrop').remove();  // Remove any leftover backdrops
// });


// $(document).on("click", "#edit_product", function() {
//     // Show add modal
//     $('#modal-default1').modal('show');
//     //$('#modal-default').modal('hide');
// });

// $('#modal-default1').on('hidden.bs.modal', function () {
//     $('#modal-default').modal('show');
// });

$('#modal-default1').on('shown.bs.modal', function () {
    // Reset phone input state for the second modal
    $('#phoneedit').removeClass('is-invalid is-valid');
    $('.iti2').removeClass('is-invalid is-valid');
    $('#error-msg2').hide(); // Hide any error message
});


$('#modal-default').on('hidden.bs.modal', function () {
    // Reset all input validations
    $('#modal-default').find('input, select, textarea').removeClass('is-invalid is-valid');

    // Reset Select2 styling
    $('#modal-default').find('.select2').each(function() {
        $(this).val(null).trigger('change'); // Clear selection
        $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid is-valid');
    });

    // Reset form fields (assuming a form exists inside the modal)
    $('#modal-default').find('form')[0].reset();

    // Optionally hide custom error messages
    // $('#modal-default').find('.error, .text-danger').text('').hide();
    $('#modal-default').find('[id$="_error"]').text('').hide();

});

$('#modal-default1').on('hidden.bs.modal', function () {
    $('#phoneedit').removeClass('is-invalid is-valid');
    $('.iti2').removeClass('is-invalid is-valid');
    $('#error-msg2').hide();
});



// Reset validation state when modal is hidden
$('#modal-default2').on('hidden.bs.modal', function () {
    $('#phoneedit').removeClass('is-invalid is-valid');
    $('.iti2').removeClass('is-invalid is-valid');
    $('#error-msg2').hide();
});

// When the "Edit" button is clicked


// When the add button is clicked (trigger modal-default)
$(document).on("click", "#btnplus.add", function() {
    // Hide the edit modal if it's open
    $('#modal-default1').modal('hide');

    // Show the add modal
    $('#modal-default').modal('show');
    
    // Optionally reset the add modal form fields
    $('#addRecordForm')[0].reset();
});

// If the add modal is opened, hide the edit modal
$('#modal-default').on('show.bs.modal', function() {
    $('#modal-default1').modal('hide'); // Hide the edit modal
});

// If the edit modal is opened, hide the add modal
$('#modal-default1').on('show.bs.modal', function() {
    $('#modal-default').modal('hide'); // Hide the add modal
});




function formatIndianNumber(x) {
    // Convert to float first
    let num = parseFloat(x);

    if (isNaN(num)) return "0.00";

    // Fix to 2 decimals
    num = num.toFixed(2);

    let [intPart, decPart] = num.split('.');

    // Indian comma logic
    let last3 = intPart.slice(-3);
    let rest = intPart.slice(0, -3);

    if (rest !== "") {
        rest = rest.replace(/\B(?=(\d{2})+(?!\d))/g, ",");
        intPart = rest + "," + last3;
    }

    return intPart + "." + decPart;
}

/* -------------------------------------------------------------------------- */
/*                                Fetch Records                               */
/* -------------------------------------------------------------------------- */
    
function fetch() {
 
   // var totalAmount = 0;
   let totalAmount = 0;


// Set total after loop
$('#totalamt').text(totalAmount.toFixed(2));

    console.log("fetch called from insert");

    $.ajax({
        type: "get",
        url: base_url + "/transaction/managetransaction", // Using base_url defined in the view
        //'type': 'GET',
        dataSrc: 'aaData',
        dataType:'json',
        success: function(response) {
            console.log(response);  

            response.aaData.forEach(function(row) {
            totalAmount += parseFloat(row.amount || 0);
           });
            console.log(totalAmount);

            //$('#example1').DataTable().clear().destroy();
             var table = $("#example").DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'processing' :true,
                'info': true,
                'autoWidth': false,
                'footer':true,
                'data': response.aaData,
                dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
                buttons: getExportButtons('#example1',[0,1,2,3,4,5,6,7,8]),  
        

         "dataType": 'json',
           "columns": [
                { 'data': 'id',
                        render: function (data, type, row, meta) {
                           return meta.row + meta.settings._iDisplayStart + 1;
                      }
                    },
                     
            { 'data': 'c_name' },
            { 'data': 'location' },
             {
                'data': 'dateofpayment',
                render: function(data, type, row, meta) {
                    var parts = data.split('-');
                    var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                    return formattedDate;
                }
            },// Add the 'id' column
             {
                'data': 'u_type',
                render: function(data, type, row, meta) {
                    if (data == 0) {
                        return '<span class="label label-success">' + "Client" + '</span>';
                    } 
                    else if (data == 1)
                    {
                        return '<span class="label label-warning">' + "Supplier" + '</span>';
                    }
                    else {
                        return '<span class="label bg-navy">' + "Dual(Cust/Sup)" + '</span>';
                    }
                }
            }, // Corrected the order based on your PHP code
            
            { 'data': 'purpose' },
            
            
             // Corrected the order based on your PHP code
           
            
            
            { 'data': 'bank' },
           { 'data': 'amount',
           render: function(data, type, row, meta) {
let num = parseFloat(data).toFixed(2);
return formatIndianNumber(num);

                   //return parseFloat(data).toFixed(2);
                }
             },
            { 'data': 'created' },
         
                    {
                      'data': 'editaction',
                         render: function (data, type, row, meta) {
                             return '<a class="btn btn-primary btn-xs" id="edit_product" data-id="' + row.pay_id + '"><i class="fa fa-pencil" style="width:15px;height:10px"></i></a>';
                         }
                      },

                    // {
                    //   'data': 'viewaction',
                    //      render: function (data, type, row, meta) {
                    //             return '<a href="get-info.php?infoid=' + row.cid + '"><button class="btn btn-warning btn-xs"><i class="fa fa-fw fa-eye"></i></button></a>';
                    //      }
                    //   },
                       
                    {
                      'data': 'deleteaction',
                         render: function (data, type, row, meta) {
                                return '<a class="btn btn-danger btn-xs" id="delete_product" data-id="' + row.pay_id + '" ><i class="fa fa-trash-o"  style="width:15px;height:10px"></i></a>';
                         }
                      }
                    
                    // Add more columns as needed
                ],
                 initComplete: function () {
                    var btns = $('.dt-button');
                    btns.addClass('btn btn-primary btn-sm btn-group');
                    btns.removeClass('dt-button');

                },        
                
                   "lengthMenu": [[10, 50, 150, -1], [10, 50, 150, "All"]]
      
        }); 
    

               // $('#totalamt').text(parseFloat(totalAmount).toFixed(2));
               $('#totalamt').text(formatIndianNumber(Number(totalAmount)));



                   document.querySelectorAll('.toggle-vis').forEach((el) => {
                    el.addEventListener('click', function (e) {
                        e.preventDefault();

                        let columnIdx = e.target.getAttribute('data-column');
                        let column = table.column(columnIdx);

                        // Toggle the visibility
                        const isVisible = column.visible();
                        column.visible(!isVisible);

                        // Highlight the clicked button
                        if (!isVisible) {
                            // If the column is now visible, highlight the button
                            e.target.style.backgroundColor = ''; // Set background color to red
                        } else {
                            // If the column is now hidden, reset the button color
                            e.target.style.backgroundColor = '#d9534f'; // Reset background color
                        }
                    });
                });


   
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    fetch();


/* -------------------------------------------------------------------------- */
/*                               Insert Records                               */
/* -------------------------------------------------------------------------- */
let hasDuplicateRecord = false;
let duplicateCheckTimeout;
// Function to check for duplicate records
// Function to convert date from DD-MM-YYYY to YYYY-MM-DD
// Function to convert date from DD-MM-YYYY to YYYY-MM-DD
function convertDateToMySQL(dateString) {
    if (!dateString) return '';
    
    console.log('Converting date:', dateString);
    
    // Check if already in YYYY-MM-DD format
    if (dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
        return dateString;
    }
    
    // Convert from DD-MM-YYYY to YYYY-MM-DD
    const parts = dateString.split('-');
    if (parts.length === 3) {
        // If format is DD-MM-YYYY
        if (parts[0].length === 2 && parts[1].length === 2 && parts[2].length === 4) {
            const mysqlDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
            console.log('Converted date:', mysqlDate);
            return mysqlDate;
        }
        // If format is MM-DD-YYYY
        else if (parts[0].length === 2 && parts[1].length === 2 && parts[2].length === 4) {
            const mysqlDate = `${parts[2]}-${parts[0]}-${parts[1]}`;
            console.log('Converted date:', mysqlDate);
            return mysqlDate;
        }
    }
    
    console.log('Date format not recognized, returning as is');
    return dateString;
}
function checkDuplicateRecord() {
        const rawDate = $('#datepicker').val().trim();
    const mysqlDate = convertDateToMySQL(rawDate);

    const formData = {
        company_name: $('#co').val().trim(),
        //location: $('#purpose').val().trim(),
        purpose: $('#purpose').val().trim(), // Add purpose field if needed
        dateofpayment: mysqlDate,
        //modeofpayment: $('#modeofpayment').val().trim(),
        amount: $('#amount').val().trim(),
        ctype: $('#ctype').val().trim()
    };

    console.log('Date conversion:', {
        input: rawDate,
        mysql: mysqlDate
    });
    // Check if at least one field has value before making API call
    const hasData = Object.values(formData).some(value => value !== '');
    
    if (!hasData) {
        hasDuplicateRecord = false;
        return;
    }

    $.ajax({
        url: base_url + '/transaction/checkDuplicateRecord',
        type: 'POST',
        data: formData,
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            console.log('Duplicate check response:', response);
            hasDuplicateRecord = response.exists;
            
                      if (response.exists) {
                // Store duplicate record details for showing in alert
                window.duplicateRecordDetails = response.duplicate_record;
                
                $('#duplicateWarning').html(`
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Similar transaction found! You'll be asked to confirm before submitting.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            } else {
                $('#duplicateWarning').html('');
            }
        },
        error: function(xhr, status, error) {
            console.error('Duplicate check error:', error);
            console.error('Response text:', xhr.responseText);
            hasDuplicateRecord = false;
            $('#duplicateWarning').html('');
        }
    });
}
// Debounced duplicate check on field changes
$('#co, #purpose, #datepicker, #amount, #ctype').on('input change', function() {
    clearTimeout(duplicateCheckTimeout);
    duplicateCheckTimeout = setTimeout(() => {
        checkDuplicateRecord();
    }, 800);
});

// Function to show duplicate confirmation alert
// Function to show duplicate confirmation alert
function showDuplicateConfirmation() {
    const duplicate = window.duplicateRecordDetails;
    
    const duplicateDetails = `
        <div style="text-align: left; font-size: 14px; margin: 15px 0;">
            <p><strong>Similar transaction record found:</strong></p>
            <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; border-left: 4px solid #ffc107;">
                <p><strong>Company ID:</strong> ${duplicate.cid || 'N/A'}</p>
                <p><strong>Purpose:</strong> ${duplicate.purpose || 'N/A'}</p>
                <p><strong>Date of Payment:</strong> ${duplicate.dateofpayment || 'N/A'}</p>
                <p><strong>Amount:</strong> ${duplicate.amount || 'N/A'}</p>
                <p><strong>Bank:</strong> ${duplicate.bank || 'N/A'}</p>
            </div>
            <p style="margin-top: 10px; color: #856404;">Do you want to proceed with this duplicate entry?</p>
        </div>
    `;

    Swal.fire({
        title: 'Duplicate Transaction Found!',
        html: duplicateDetails,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Submit Anyway',
        cancelButtonText: 'No, Cancel',
        width: '600px'
    }).then((result) => {
        if (result.isConfirmed) {
            // User confirmed, proceed with submission
            console.log('User confirmed duplicate submission');
            submitTransaction();
        } else {
            // User cancelled, show info message
            console.log('User cancelled duplicate submission');
            Swal.fire({
                title: 'Cancelled',
                text: 'Transaction submission was cancelled.',
                icon: 'info',
                confirmButtonText: 'OK',
                timer: 2000
            });
        }
    });
}// Function to submit transaction data

function submitTransaction() {
    var payid = $('#payid').val().trim();
    var co = $('#co').val();
    var purpose = $('#purpose').val();
    var rawDate = $('#datepicker').val();
    var mysqlDate = convertDateToMySQL(rawDate);
    var ctype = $('#ctype').val();
    var amount = $('#amount').val();

    // Validate once more before sending
    if (!co || !purpose || !amount || !ctype || !mysqlDate) {
        Swal.fire({
            title: "Validation Error!",
            text: "Please fill all required fields",
            icon: "error",
            confirmButtonText: "OK"
        });
        return;
    }

    var fd = new FormData();
    fd.append("payid", payid);
    fd.append("co", co);
    fd.append("purpose", purpose);
    fd.append("amount", amount);
    fd.append("ctype", ctype);
    fd.append("dateofpayment", mysqlDate);
    
    // ADD CREATED FIELD - use current date in YYYY-MM-DD format
    var currentDate = new Date();
    var createdDate = currentDate.toISOString().split('T')[0]; // YYYY-MM-DD
    fd.append("created", createdDate);

    console.log("Submitting transaction data:");
    for (var pair of fd.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    // Show loading indicator
    Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we save your transaction',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        type: "post",
        url: base_url + "/transaction/insert",
        data: fd,
        processData: false,
        contentType: false,
        dataType: "json",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            console.log('Insert Response:', response);
            
            Swal.close();
            
            if (response.res === "success") {
                Swal.fire({
                    title: "Success!",
                    text: response.message || "Transaction inserted successfully!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 3000,
                }).then(function() {
                    $("#modal-default").modal("hide");
                    $("#form")[0].reset();
                    $(".select2").val(null).trigger('change');
                    $("#example").DataTable().clear().destroy();
                    fetch();
                    
                    hasDuplicateRecord = false;
                    $('#duplicateWarning').html('');
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message || "Failed to insert transaction",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.close();
            console.error("AJAX Error: ", status, error);
            console.error("Response text: ", xhr.responseText);
            
            Swal.fire({
                title: "Server Error!",
                text: "Failed to connect to server: " + error,
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    });
}
$(document).on("click", "#submit", function(e) {
    e.preventDefault();

     isValid = true;

    // Clear previous error messages
    $('#co_error').text('');
    $('#purpose_error').text('');
    $('#amount_error').text('');
    $('#dtp_error').text('');
    $('#ctype_error').text('');
    $('#bank_error').text('');
    // // Validate Company Name
    // if ($('#c_nameedit').val().trim() === '') {
    //     $('#c_name_error').text('Company name is required.');
    //     isValid = false;
    // }

    $('#co, #purpose, #amount, #datepicker, #ctype').removeClass('is-invalid');

    // Validate Company Name
    // if ($('#co').val().trim() === '') {
    //     $('#co_error').text('Company name is required.');
    //     $('#co').addClass('is-invalid'); // Highlight the field
    //     isValid = false;
    // }

    // Validate Address
    if ($('#purpose').val().trim() === '') {
        $('#purpose_error').text('Purpose is required.');
        $('#purpose').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Mobile Number
    if ($('#amount').val().trim() === '') {
        $('#amount_error').text('Amount is required.');
        $('#amount').addClass('is-invalid'); // Highlight the field
            //$('#phoneedit').addClass('is-invalid');  // Adding class to input
    //$('.iti').addClass('is-invalid');        // Adding class to intl-tel-input wrapper
    isValid = false;
        //isValid = false;
    }

    // Validate GST
    if ($('#datepicker').val().trim() === '') {
        $('#dtp_error').text('Date of payment is required.');
        $('#datepicker').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    
//let isValid = true;

// First Select2
if ($('#ctype').val() === '' || $('#ctype').val() === null) {
    $('#ctype_error').text('Bank name is required.');
    $('#ctype').next('.select2-container').find('.select2-selection').addClass('is-invalid');
    isValid = false;
} else {
    $('#ctype').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
}

// Second Select2
if ($('#co').val() === '' || $('#co').val() === null) {
    $('#co_error').text('Company name is required.');
    $('#co').next('.select2-container').find('.select2-selection').addClass('is-invalid');
    isValid = false;
} else {
    $('#co').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
}



        // If duplicate record exists, show confirmation alert
    if (hasDuplicateRecord && window.duplicateRecordDetails) {
        console.log('Duplicate found, showing confirmation');
        showDuplicateConfirmation();
    } else {
        // No duplicates found, proceed with submission
        console.log('No duplicates found, proceeding with submission');
        submitTransaction();
    }
});


  //       // Get form data

  //       var payid=$('#payid').val().trim();
  //       var co=$('#co').val();
  //       //$('#item').text("Supply Of : "+item_name);
  //       var purpose=$('#purpose').val();
  //       var dateofpayment = $('#datepicker').val();
  //       var ctype=$('#ctype').val();
  //       var amount = $('#amount').val();
    
  //       var u_type = 0; // Assuming you want this value
  //       var fd = new FormData();
  //       fd.append("payid", payid);
  //       fd.append("co", co);
  //       fd.append("purpose", purpose);
  //       fd.append("amount", amount);
  //       fd.append("ctype", ctype);

  //       fd.append("dateofpayment", dateofpayment);


  //       //fd.append("u_type", u_type); // Ensure this is included

  //       console.log("cid: ", payid);
  //       console.log("c_name: ", co);
  //       console.log("c_add: ", purpose);
  //       console.log("fullno: ", amount);
  //       //console.log("country: ", countr);
  //       //console.log("gst: ", gst);
  //       console.log("email: ", dateofpayment);
  //       console.log("ctype: ", ctype);
  //       console.log("u_type: ", u_type);


  //       console.log(fd);    

  //       $.ajax({
  //           type: "post",  // Change this to "post" if using POST
  //           url: base_url + "/transaction/insert",
  //           data: fd,
  //           processData: false,
  //           contentType: false,
  //           dataType:"json",
  //           headers: {
  //               'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
  //           },
  //           success: function(response) {
                
  //                       try {
  //           // Parse JSON response
  //           const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
  //           console.log('Parsed Response:', jsonResponse);

  //           $("#modal-default").modal("hide");
  //           $("#form")[0].reset();
  //           $(".select2").val(null).trigger('change');
  //           $("#example").DataTable().clear().destroy();
  //               fetch();
  //       } catch (error) {
  //           console.error('Invalid JSON Response:', error);
  //       }

  //           },
  //           error: function(xhr, status, error) {
  //               console.error("AJAX Error: ", status, error);
  //           }
  //       });
  //   }
  // }) 






/* -------------------------------------------------------------------------- */
/*                               Delete Records                               */
/* -------------------------------------------------------------------------- */

   $(document).on('click', '#delete_product', function(e){
      
      var del_id = $(this).data('id');

      console.log(del_id);
      
   Swal.fire({
  title: 'Are you sure?',
  text: "It will be deleted permanently!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!',
  // Remove the showLoaderOnConfirm option
  // showLoaderOnConfirm: true,
  allowOutsideClick: false        
}).then((result) => {
  if (result.isConfirmed) {
    console.log("Base URL:", base_url);
console.log("Delete URL:", base_url+"/transaction/delete/" + encodeURIComponent(del_id));

    // Perform the deletion operation using AJAX ?edit_id=" + encodeURIComponent(edit_id),
    $.ajax({
      url: base_url+"/transaction/delete?del_id=" + encodeURIComponent(del_id),
      type: 'get',
      //data: { delete: del_id },
      dataType: 'json'
    })
    .done(function(response){
      console.log(response);
      console.log(response.message);
      // Display success message using Swal.fire
       Swal.fire({
        title: 'Deleted!',
        text: response.message,
        icon: response.status,
        showConfirmButton: false
      });
      // Refresh the product list or perform other actions as needed
      readProducts();
    })
    .fail(function(){
      // Display error message using Swal.fire
      Swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
    });
  }
});
      e.preventDefault();
      console.log(del_id);
    });
    

  

  function readProducts(){
    setTimeout(function(){
            window.location.href = base_url+'/transaction/managetransaction';
         }, 3000);
    //$('#load-products').load('manage-clients.php'); 
  }

/* -------------------------------------------------------------------------- */
/*                                Edit Records                                */
/* -------------------------------------------------------------------------- */


    $(document).on("click", "#edit_product", function () {
        $('#modal-default').modal('hide');
        $('#modal-default1').modal('show');

        var edit_id = $(this).data("id");

        console.log(edit_id);

        $.ajax({
            url: base_url + "/transaction/edit?edit_id=" + encodeURIComponent(edit_id),
            type: "get",
            dataType: "JSON",
            // data: {
            //     edit_id: edit_id
            // },
            success: function (response) {
                console.log("AJAX response:", response);

                $('#payidedit').val(response.post.pay_id);
                $('#editamount').val(response.post.amount);
                $('#editpurpose').val(response.post.purpose);
                $('#editlocation').val(response.post.location);

                // Handle DatePicker formatting
                const rawDate = response.post.dateofpayment;
                const dateParts = rawDate.split("-");
                const year = parseInt(dateParts[0], 10);
                const month = parseInt(dateParts[1], 10) - 1;
                const day = parseInt(dateParts[2], 10);
                const dateForPicker = new Date(year, month, day);
                const formattedDate = `${String(day).padStart(2, '0')}-${String(month + 1).padStart(2, '0')}-${year}`;
                $('#editdatepicker').val(formattedDate);
                $("#editdatepicker").datepicker({
                    format: "dd-mm-yyyy",
                    language: "fr",
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true
                });
                $("#editdatepicker").datepicker("update", dateForPicker);


                 $('#coedit').select2({
                    placeholder: 'Select a Client',
                    allowClear: true,
                ajax: {
                    url: base_url + "/transaction/getclient",
                    type: 'get', // Adjust URL to get client data
                    dataType: 'json',
                      delay: 250, // Add a delay to limit requests for better performance
                        data: function(params) {
                            // Send the current input value to the server as 'category_name'
                            return {
                                category_name: params.term || '' // params.term is the search term
                            };
                        },
                        processResults: function(data) {
                            console.log(data); // For debugging, remove this after testing
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });

            // // After options are loaded, set the selected value
            $('#coedit').append(new Option(response.post.c_name, response.post.cid, true, true)).trigger('change');


                // Now update #editctype select2 with Bank Details
                $('#editctype').select2({
                    placeholder: 'Select a Bank',
                    allowClear: true,
                    ajax: {
                        url: base_url + "/transaction/getBankDetails",
                        type: 'get',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                term: params.term || '' // Send search term if applicable
                            };
                        },
                        processResults: function (data) {
                            console.log("Bank Details Data:", data);
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });

                // Set the selected bank based on response
                if (response.post.bank) {
                    let bank = response.post.bank;
                    let selectedOption = new Option(bank, bank, true, true);
                    $('#editctype').append(selectedOption).trigger('change');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    });


/* -------------------------------------------------------------------------- */
/*                               Update Records                               */
/* -------------------------------------------------------------------------- */



// $(document).on("click", "#update", function(e) {
//     e.preventDefault();

  
//      isValid = true;

//     // Clear previous error messages
//     $('#coedit_error').text('');
//     $('#editpurpose_error').text('');
//     $('#editamount_error').text('');
//     $('#editdtp_error').text('');
//     $('#editctype_error').text('');
//     //$('#bank_error').text('');
//     // // Validate Company Name
//     // if ($('#c_nameedit').val().trim() === '') {
//     //     $('#c_name_error').text('Company name is required.');
//     //     isValid = false;
//     // }

//     $('#coedit, #editpurpose, #editamount, #editdatepicker, #editctype').removeClass('is-invalid');

//     // Validate Company Name
//     // if ($('#coedit').val().trim() === '') {
//     //     $('#coedit_error').text('Company name is required.');
//     //     $('#coedit').addClass('is-invalid'); // Highlight the field
//     //     isValid = false;
//     // }

//     // Validate Address
//     if ($('#editpurpose').val().trim() === '') {
//         $('#editpurpose_error').text('Purpose is required.');
//         $('#editpurpose').addClass('is-invalid'); // Highlight the field
//         isValid = false;
//     }

//     // Validate Mobile Number
//     if ($('#editamount').val().trim() === '') {
//         $('#editamount_error').text('Amount is required.');
//         $('#editamount').addClass('is-invalid'); // Highlight the field
//             //$('#phoneedit').addClass('is-invalid');  // Adding class to input
//     //$('.iti').addClass('is-invalid');        // Adding class to intl-tel-input wrapper
//     isValid = false;
//         //isValid = false;
//     }

//     // Validate GST
//     if ($('#editdatepicker').val().trim() === '') {
//         $('#editdtp_error').text('dateofpayment is required.');
//         $('#editdatepicker').addClass('is-invalid'); // Highlight the field
//         isValid = false;
//     }



// if ($('#editctype').val() === '' || $('#ctype').val() === null) {
//     $('#editctype_error').text('Bank name is required.');
//     $('#editctype').next('.select2-container').find('.select2-selection').addClass('is-invalid');
//     isValid = false;
// } else {
//     $('#editctype').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
// }

// // Second Select2
// if ($('#coedit').val() === '' || $('#co').val() === null) {
//     $('#coedit_error').text('Company name is required.');
//     $('#coedit').next('.select2-container').find('.select2-selection').addClass('is-invalid');
//     isValid = false;
// } else {
//     $('#coedit').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
// }





//     // Prevent form submission if validation fails
//     if (!isValid) {
//         e.preventDefault();
//         return;
//     } else {
//         // Get form data
//         var payid=$('#payidedit').val().trim();
//         var co=$('#coedit').val();
//         //$('#item').text("Supply Of : "+item_name);
//         var purpose=$('#editpurpose').val();
//         var dateofpayment = $('#editdatepicker').val();
//         var ctype=$('#editctype').val();
//         var amount = $('#editamount').val();
    
//         var u_type = 0; // Assuming you want this value
//         var fd = new FormData();
//         fd.append("payidedit", payid);
//         fd.append("coedit", co);
//         fd.append("editpurpose", purpose);
//         fd.append("editamount", amount);
//         fd.append("editctype", ctype);

//         fd.append("editdateofpayment", dateofpayment);

//         console.log(fd);

//         $.ajax({
//             type: "post",
//             url: base_url + "/transaction/update",
//             data: fd,
//             processData: false,
//             contentType: false,
//             headers: {
//                  'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
//              },
//             dataType: "json",
//             success: function(response) {
//                 if (response.res == "success") {
//                 //console.log(response);
//                     //toastr["success"](response.message);
//                     $("#modal-default1").modal("hide");
//                      $("#example").DataTable().clear().destroy();
//                        fetch();  // Refetch the data

//                 } else {
//                     toastr["error"](response.message);
//                 }
//             },
//         });
//     }
//  });
// Update functionality - duplicate checking variables
let hasDuplicateRecordEdit = false;
let duplicateCheckTimeoutEdit;

// Function to check for duplicate records in edit mode
function checkDuplicateRecordEdit() {
    const rawDate = $('#editdatepicker').val().trim();
    const mysqlDate = convertDateToMySQL(rawDate);

    const formData = {
        company_name: $('#coedit').val().trim(),
        purpose: $('#editpurpose').val().trim(),
        dateofpayment: mysqlDate,
        amount: $('#editamount').val().trim(),
        ctype: $('#editctype').val().trim(),
        exclude_payid: $('#payidedit').val().trim() // Exclude current record
    };

    console.log('Edit Duplicate check data:', formData);

    // Check if at least one field has value before making API call
    const hasData = Object.values(formData).some(value => value !== '');
    
    if (!hasData) {
        hasDuplicateRecordEdit = false;
        return;
    }

    $.ajax({
        url: base_url + '/transaction/checkDuplicateRecord',
        type: 'POST',
        data: formData,
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            console.log('Edit Duplicate check response:', response);
            hasDuplicateRecordEdit = response.exists;
            
            if (response.exists) {
                // Store duplicate record details for showing in alert
                window.duplicateRecordDetailsEdit = response.duplicate_record;
                
                $('#duplicateWarningEdit').html(`
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Similar transaction found! You'll be asked to confirm before updating.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            } else {
                $('#duplicateWarningEdit').html('');
            }
        },
        error: function(xhr, status, error) {
            console.error('Edit Duplicate check error:', error);
            console.error('Response text:', xhr.responseText);
            hasDuplicateRecordEdit = false;
            $('#duplicateWarningEdit').html('');
        }
    });
}

// Debounced duplicate check on field changes for edit form
$('#coedit, #editpurpose, #editdatepicker, #editamount, #editctype').on('input change', function() {
    clearTimeout(duplicateCheckTimeoutEdit);
    duplicateCheckTimeoutEdit = setTimeout(() => {
        checkDuplicateRecordEdit();
    }, 800);
});

// Function to show duplicate confirmation alert for edit
function showDuplicateConfirmationEdit() {
    const duplicate = window.duplicateRecordDetailsEdit;
    
    const duplicateDetails = `
        <div style="text-align: left; font-size: 14px; margin: 15px 0;">
            <p><strong>Similar transaction record found:</strong></p>
            <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; border-left: 4px solid #ffc107;">
                <p><strong>Company ID:</strong> ${duplicate.cid || 'N/A'}</p>
                <p><strong>Purpose:</strong> ${duplicate.purpose || 'N/A'}</p>
                <p><strong>Date of Payment:</strong> ${duplicate.dateofpayment || 'N/A'}</p>
                <p><strong>Amount:</strong> ${duplicate.amount || 'N/A'}</p>
                <p><strong>Bank:</strong> ${duplicate.bank || 'N/A'}</p>
            </div>
            <p style="margin-top: 10px; color: #856404;">Do you want to proceed with this duplicate entry?</p>
        </div>
    `;

    Swal.fire({
        title: 'Duplicate Transaction Found!',
        html: duplicateDetails,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Update Anyway',
        cancelButtonText: 'No, Cancel',
        width: '600px'
    }).then((result) => {
        if (result.isConfirmed) {
            // User confirmed, proceed with update
            console.log('User confirmed duplicate update');
            submitTransactionUpdate();
        } else {
            // User cancelled, show info message
            console.log('User cancelled duplicate update');
            Swal.fire({
                title: 'Cancelled',
                text: 'Transaction update was cancelled.',
                icon: 'info',
                confirmButtonText: 'OK',
                timer: 2000
            });
        }
    });
}

// Function to submit transaction update
function submitTransactionUpdate() {
    var payid = $('#payidedit').val().trim();
    var co = $('#coedit').val();
    var purpose = $('#editpurpose').val();
    var rawDate = $('#editdatepicker').val();
    var mysqlDate = convertDateToMySQL(rawDate);
    var ctype = $('#editctype').val();
    var amount = $('#editamount').val();

    // Validate once more before sending
    if (!co || !purpose || !amount || !ctype || !mysqlDate) {
        Swal.fire({
            title: "Validation Error!",
            text: "Please fill all required fields",
            icon: "error",
            confirmButtonText: "OK"
        });
        return;
    }

    var fd = new FormData();
    fd.append("payidedit", payid);
    fd.append("coedit", co);
    fd.append("editpurpose", purpose);
    fd.append("editamount", amount);
    fd.append("editctype", ctype);
    fd.append("editdateofpayment", mysqlDate);

    console.log("Updating transaction data:");
    for (var pair of fd.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    // Show loading indicator
    Swal.fire({
        title: 'Updating...',
        text: 'Please wait while we update your transaction',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        type: "post",
        url: base_url + "/transaction/update",
        data: fd,
        processData: false,
        contentType: false,
        dataType: "json",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            console.log('Update Response:', response);
            
            Swal.close();
            
            if (response.res === "success") {
                Swal.fire({
                    title: "Success!",
                    text: response.message || "Transaction updated successfully!",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 3000,
                }).then(function() {
                    $("#modal-default1").modal("hide");
                    $("#form1")[0].reset();
                    $(".select2").val(null).trigger('change');
                    $("#example").DataTable().clear().destroy();
                    fetch();
                    
                    // Reset duplicate flag
                    hasDuplicateRecordEdit = false;
                    $('#duplicateWarningEdit').html('');
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message || "Failed to update transaction",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.close();
            console.error("AJAX Error: ", status, error);
            console.error("Response text: ", xhr.responseText);
            
            Swal.fire({
                title: "Server Error!",
                text: "Failed to connect to server: " + error,
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    });
}

// Updated Update button handler
$(document).on("click", "#update", function(e) {
    e.preventDefault();

    let isValid = true;

    // Clear previous error messages
    $('#coedit_error').text('');
    $('#editpurpose_error').text('');
    $('#editamount_error').text('');
    $('#editdtp_error').text('');
    $('#editctype_error').text('');

    $('#coedit, #editpurpose, #editamount, #editdatepicker, #editctype').removeClass('is-invalid');

    // Validate Purpose
    if ($('#editpurpose').val().trim() === '') {
        $('#editpurpose_error').text('Purpose is required.');
        $('#editpurpose').addClass('is-invalid');
        isValid = false;
    }

    // Validate Amount
    if ($('#editamount').val().trim() === '') {
        $('#editamount_error').text('Amount is required.');
        $('#editamount').addClass('is-invalid');
        isValid = false;
    }

    // Validate Date
    if ($('#editdatepicker').val().trim() === '') {
        $('#editdtp_error').text('Date of payment is required.');
        $('#editdatepicker').addClass('is-invalid');
        isValid = false;
    }

    // Validate Select2 fields - FIXED: using correct field IDs
    if ($('#editctype').val() === '' || $('#editctype').val() === null) {
        $('#editctype_error').text('Bank name is required.');
        $('#editctype').next('.select2-container').find('.select2-selection').addClass('is-invalid');
        isValid = false;
    } else {
        $('#editctype').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
    }

    if ($('#coedit').val() === '' || $('#coedit').val() === null) {
        $('#coedit_error').text('Company name is required.');
        $('#coedit').next('.select2-container').find('.select2-selection').addClass('is-invalid');
        isValid = false;
    } else {
        $('#coedit').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
    }

    // Prevent form submission if validation fails
    if (!isValid) {
        return;
    }

    // If duplicate record exists, show confirmation alert
    if (hasDuplicateRecordEdit && window.duplicateRecordDetailsEdit) {
        console.log('Duplicate found in edit, showing confirmation');
        showDuplicateConfirmationEdit();
    } else {
        // No duplicates found, proceed with update
        console.log('No duplicates found in edit, proceeding with update');
        submitTransactionUpdate();
    }
});