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
                   return parseFloat(data).toFixed(2);
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
    

                $('#totalamt').text(parseFloat(totalAmount).toFixed(2));


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

    // Validate Bill Type
    // if ($('#ctype').val().trim() === '') {
    //     $('#ctype_error').text('Please select a Bill Type.');
    //  $('#ctype').addClass('is-invalid');  // Add to the hidden select (optional for form data)
    // $('#ctype').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add class to Select2 container
    // isValid = false;
    // }

//    if ($('#ctype').val().trim() === '') {
//     $('#ctype_error').text('Please select a Bank.');
//     $('#ctype').addClass('is-invalid');  // For the original select (good for fallback)
    
//     // Add 'is-invalid' to the rendered Select2 container
//     $('#ctype').next('.select2-container').find('.select2-selection').addClass('is-invalid');

//     isValid = false;
// } else {
//     $('#ctype').removeClass('is-invalid');
//     $('#ctype').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
//     $('#ctype_error').text('');
// }

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



    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        return;
    } else {
        // Get form data

        var payid=$('#payid').val().trim();
        var co=$('#co').val();
        //$('#item').text("Supply Of : "+item_name);
        var purpose=$('#purpose').val();
        var dateofpayment = $('#datepicker').val();
        var ctype=$('#ctype').val();
        var amount = $('#amount').val();
    
        var u_type = 0; // Assuming you want this value
        var fd = new FormData();
        fd.append("payid", payid);
        fd.append("co", co);
        fd.append("purpose", purpose);
        fd.append("amount", amount);
        fd.append("ctype", ctype);

        fd.append("dateofpayment", dateofpayment);


        //fd.append("u_type", u_type); // Ensure this is included

        console.log("cid: ", payid);
        console.log("c_name: ", co);
        console.log("c_add: ", purpose);
        console.log("fullno: ", amount);
        //console.log("country: ", countr);
        //console.log("gst: ", gst);
        console.log("email: ", dateofpayment);
        console.log("ctype: ", ctype);
        console.log("u_type: ", u_type);


        console.log(fd);    

        $.ajax({
            type: "post",  // Change this to "post" if using POST
            url: base_url + "/transaction/insert",
            data: fd,
            processData: false,
            contentType: false,
            dataType:"json",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
            },
            success: function(response) {
                
                        try {
            // Parse JSON response
            const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
            console.log('Parsed Response:', jsonResponse);

            $("#modal-default").modal("hide");
            $("#form")[0].reset();
            $(".select2").val(null).trigger('change');
            $("#example").DataTable().clear().destroy();
                fetch();
        } catch (error) {
            console.error('Invalid JSON Response:', error);
        }

            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    }
  }) 






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



$(document).on("click", "#update", function(e) {
    e.preventDefault();

  
     isValid = true;

    // Clear previous error messages
    $('#coedit_error').text('');
    $('#editpurpose_error').text('');
    $('#editamount_error').text('');
    $('#editdtp_error').text('');
    $('#editctype_error').text('');
    //$('#bank_error').text('');
    // // Validate Company Name
    // if ($('#c_nameedit').val().trim() === '') {
    //     $('#c_name_error').text('Company name is required.');
    //     isValid = false;
    // }

    $('#coedit, #editpurpose, #editamount, #editdatepicker, #editctype').removeClass('is-invalid');

    // Validate Company Name
    // if ($('#coedit').val().trim() === '') {
    //     $('#coedit_error').text('Company name is required.');
    //     $('#coedit').addClass('is-invalid'); // Highlight the field
    //     isValid = false;
    // }

    // Validate Address
    if ($('#editpurpose').val().trim() === '') {
        $('#editpurpose_error').text('Purpose is required.');
        $('#editpurpose').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Mobile Number
    if ($('#editamount').val().trim() === '') {
        $('#editamount_error').text('Amount is required.');
        $('#editamount').addClass('is-invalid'); // Highlight the field
            //$('#phoneedit').addClass('is-invalid');  // Adding class to input
    //$('.iti').addClass('is-invalid');        // Adding class to intl-tel-input wrapper
    isValid = false;
        //isValid = false;
    }

    // Validate GST
    if ($('#editdatepicker').val().trim() === '') {
        $('#editdtp_error').text('dateofpayment is required.');
        $('#editdatepicker').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }



if ($('#editctype').val() === '' || $('#ctype').val() === null) {
    $('#editctype_error').text('Bank name is required.');
    $('#editctype').next('.select2-container').find('.select2-selection').addClass('is-invalid');
    isValid = false;
} else {
    $('#editctype').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
}

// Second Select2
if ($('#coedit').val() === '' || $('#co').val() === null) {
    $('#coedit_error').text('Company name is required.');
    $('#coedit').next('.select2-container').find('.select2-selection').addClass('is-invalid');
    isValid = false;
} else {
    $('#coedit').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
}





    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        return;
    } else {
        // Get form data
        var payid=$('#payidedit').val().trim();
        var co=$('#coedit').val();
        //$('#item').text("Supply Of : "+item_name);
        var purpose=$('#editpurpose').val();
        var dateofpayment = $('#editdatepicker').val();
        var ctype=$('#editctype').val();
        var amount = $('#editamount').val();
    
        var u_type = 0; // Assuming you want this value
        var fd = new FormData();
        fd.append("payidedit", payid);
        fd.append("coedit", co);
        fd.append("editpurpose", purpose);
        fd.append("editamount", amount);
        fd.append("editctype", ctype);

        fd.append("editdateofpayment", dateofpayment);

        console.log(fd);

        $.ajax({
            type: "post",
            url: base_url + "/transaction/update",
            data: fd,
            processData: false,
            contentType: false,
            headers: {
                 'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
             },
            dataType: "json",
            success: function(response) {
                if (response.res == "success") {
                //console.log(response);
                    //toastr["success"](response.message);
                    $("#modal-default1").modal("hide");
                     $("#example").DataTable().clear().destroy();
                       fetch();  // Refetch the data

                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }
 });
