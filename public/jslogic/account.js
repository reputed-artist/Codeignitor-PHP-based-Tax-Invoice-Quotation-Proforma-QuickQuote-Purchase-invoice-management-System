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


// $('#modal-default2').on('shown.bs.modal', function () {
//     validatePhoneField(); // Initial validation for phone field when modal is shown
// });



// function validatePhoneField() {
//     var phoneField = $('#phoneedit');
//     var fullNumber = iti2.getNumber(); // Get full international number from intl-tel-input

//     if (phoneField.val().trim()) {
//         // If phone field has valid data, set as valid
//         if (iti2.isValidNumber()) {
//             phoneField.removeClass('is-invalid').addClass('is-valid');
//             $('.iti2').removeClass('is-invalid').addClass('is-valid');
//             $('#error-msg2').hide();
//         } else {
//             // If data is invalid
//             phoneField.addClass('is-invalid');
//             $('.iti2').addClass('is-invalid');
//             var errorCode2 = iti2.getValidationError();
//             $('#error-msg2').text(errorMap2[errorCode2]).show();
//         }
//     } else {
//         // If phone field is empty, set to invalid
//         phoneField.addClass('is-invalid');
//         $('.iti2').addClass('is-invalid');
//         $('#error-msg2').text('Mobile number is required.').show();
//     }
// }

// // On input or change, validate the phone field again
// $('#phoneedit').on('keyup change', function() {
//     validatePhoneField();
// });

// Reset validation state when modal is hidden
$('#modal-default2').on('hidden.bs.modal', function () {
    $('#phoneedit').removeClass('is-invalid is-valid');
    $('.iti2').removeClass('is-invalid is-valid');
    $('#error-msg2').hide();
});
// When the "Edit" button is clicked
$(document).on("click", "#edit_product", function() {

      // e.preventDefault();
    // Get the Client ID or any other data needed
    //var clientId = $(this).data('id');

    // Hide the add modal if it's open
    $('#modal-default').modal('hide');

    // Show the edit modal (modal-default1)
    $('#modal-default1').modal('show');
    
    var edit_id = $(this).data("id");

    $.ajax({
        url: base_url + "/account/edit/"+ parseInt(edit_id),
        type: "get",
        dataType: "JSON",
        data: {
            edit_id: edit_id
        },
        headers: {
                'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
            },
        success: function(response) {
            console.log("AJAX response:", response); // Debug the response
            $('#aidedit').val(response.post.aid);
            // Populate modal fields (assuming response contains these fields)

            $('#opbaledit').val(response.post.opening_bal);
           
           // Load ctypeedit Select2 options first, then set the selected value
            $('#ctypeedit').select2({
                ajax: {
                    url: base_url + "/account/getclient",
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

            // After options are loaded, set the selected value
            $('#ctypeedit').append(new Option(response.post.c_name, response.post.cid, true, true)).trigger('change');
             
            //$('#ctypeedit').val(response.post.c_name).trigger('change'); // for Select2

            
            $('#modal-default1').modal('show');
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: ", status, error);
        }
    });
});

// When the add button is clicked (trigger modal-default)
$(document).on("click", "#btnplus.add", function() {
    // Hide the edit modal if it's open
    $('#modal-default1').modal('hide');

    // Show the add modal
    $('#modal-default').modal('show');
    
    // Optionally reset the add modal form fields
    $('#form')[0].reset();
});

// If the add modal is opened, hide the edit modal
$('#modal-default').on('show.bs.modal', function() {
    $('#modal-default1').modal('hide'); // Hide the edit modal
});

// If the edit modal is opened, hide the add modal
$('#modal-default1').on('show.bs.modal', function() {
    $('#modal-default').modal('hide'); // Hide the add modal
});




// /* ---------------------------- Add Records Modal --------------------------- */

// $("#addRecords").on("hide.bs.modal", function(e) {
//     // do something...
//     $("#addRecordForm")[0].reset();
//     $(".custom-file-label").html("Choose file");
// });

/* ---------------------------- Edit Record Modal --------------------------- */

// $("#editRecords").on("hide.bs.modal", function(e) {
//     // do something...
//     $("#editForm")[0].reset();
//     $(".custom-file-label").html("Choose file");
// });

/* --------------------------------- Baseurl -------------------------------- */
//var base_url = $("#base_url").val();

    //var base_url = "<?= base_url(); ?>";

//var base_url; 

/* -------------------------------------------------------------------------- */
/*                                Fetch Records                               */
/* -------------------------------------------------------------------------- */
function fetch() {
    console.log("fetch called from insert");

    $.ajax({
        type: "get",
        url: base_url + "/account/manageaccounts", // Using base_url defined in the view
        //'type': 'GET',
        dataSrc: 'aaData',
        dataType:'json',
        success: function(response) {
            console.log(response);  
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
                buttons: getExportButtons('#example1',[0,1,2,3,4,5,6]),  

                "columns": [
                              {

                            //custom functions for particular column
                            "data": "id",
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                                }
                              },
                              { mData: 'c_name'},
                              {
                                  mData: 'u_type',
                                  render: function (data, type, row, meta) {
                                    // Convert to integer
                                  console.log("Raw data:", data, "Type of data:", typeof data); // Debugging
                                    var u_type = parseInt(data.trim(), 10); // Convert to integer
                                    console.log("Parsed u_type:", u_type, "Type of u_type:", typeof u_type);
                                        console.log("u_type:", u_type);

                                    console.log("u_type:", u_type);
                                        switch (u_type) {
                                          case 0:
                                            return '<span class="label label-success">Client</span>';
                                          case 1:
                                            return '<span class="label label-warning">Supplier</span>';
                                          default:
                                            return '<span class="label label-primary">Dual (Cust/Sup)</span>';
                                          
                                        }

                                  }
                                },

                              { mData: 'mob' },
                              { mData: 'location' },
                              { mData: 'opening_bal' },
                              { mData: 'created',
                                  render: function (data, type, row, meta) {
                                    var parts = data.split('-');
                                    var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];

                                    // Returning the formatted date
                                    return formattedDate;
                                
                                  }
                               },

                    {
                      'data': 'editaction',
                         render: function (data, type, row, meta) {
                             return '<a class="btn btn-primary btn-xs" id="edit_product" data-id="' + row.aid + '"><i class="fa fa-pencil" style="width:15px;height:10px"></i></a>';
                         }
                      },

                    {
                      'data': 'viewaction',
                         render: function (data, type, row, meta) {
                               //return '<a class="btn btn-warning btn-xs" id="viewledger" data-id="' + row.aid +'"><i class="fa fa-fw fa-eye" style="width:15px;height:10px"></i></a>';
                                //return '<a href="getledger?infoid=${row.aid}" class="btn btn-warning btn-xs"><i class="fa fa-fw fa-eye"></i></button></a>';
                                return `<a href="getledger/${row.cid}" class="btn btn-warning btn-xs" id="viewledger" data-id="${row.cid}">
                    <i class="fa fa-fw fa-eye" style="width:15px;height:10px"></i>
                </a>`;
                         }
                      },
                       
                    {
                      'data': 'deleteaction',
                         render: function (data, type, row, meta) {
                                return '<a class="btn btn-danger btn-xs" id="delete_product" data-id="' + row.aid + '" ><i class="fa fa-trash-o"  style="width:15px;height:10px"></i></a>';
                         }
                      }
                    
                    // Add more columns as needed
                ],
                 initComplete: function () {
                    var btns = $('.dt-button');
                    btns.addClass('btn btn-primary btn-sm btn-group');
                    btns.removeClass('dt-button');

                },        
                
                   "lengthMenu": [[20, 50, 150, -1], [20, 50, 150, "All"]]
      
        }); 
    

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
    $('#ctype_error').text('');
    $('#opbal_error').text('');
    // $('#mob_error').text('');
    // $('#gst_error').text('');
    // $('#ctype_error').text('');

    

    $('#opbal, #ctype').removeClass('is-invalid');

    

    // Validate Address
    if ($('#opbal').val().trim() === '') {
        $('#opbal_error').text('Opening Balance is required.');
        $('#opbal').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    
    if ($('#ctype').val().trim() === '') {
    $('#ctype_error').text('Please select a Company.');
    $('#ctype').addClass('is-invalid');  // Add to the hidden select
    $('#ctype').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add to Select2 container
    isValid = false;
} else {
    $('#ctype').removeClass('is-invalid');
    $('#ctype').next('.select2').find('.select2-selection').removeClass('is-invalid'); // Remove red border
    $('#ctype_error').text('');  // Clear error message
}



    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        return;
    } else {
        // Get form data


    var aid = $("#aid").val();   
    var opbal = $("#opbal").val();


    var ctype = $("#ctype").val();
    

    
      //var u_type = 0; // Assuming you want this value
        var fd = new FormData();
        fd.append("aid", aid);
        fd.append("opbal", opbal);
        fd.append("ctype", ctype);
        
        console.log("aid: ", aid);
        console.log("opbal: ", opbal);
        console.log("ctype: ", ctype);
        

        console.log(fd);    

        $.ajax({
            type: "post",  // Change this to "post" if using POST
            url: base_url + "/account/insert",
            data: fd,
            processData: false,
            contentType: false,
            dataType:"json",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
            },
            success: function(response) {
                //console.log(response);
                if (response.res === "success") {
                    
                    console.log(response);
                    console.log("Executed Query: ", response.query);

                    $("#modal-default").modal("hide");
                    $("#form")[0].reset();
               
                    $("#example").DataTable().clear().destroy();
                    fetch();

                     $.ajax({
                    url:  base_url +'/account/get_next_id', // URL to get the next ID
                    method: 'get',
                    dataType: 'json',
                    success: function(data) {
                        //var result = JSON.parse(data);
                        console.log(data);
                        $('#aid').val(data.next_id); // Set the new ID valu

                        //$('#address_country').val('in'); // 
                    },
                    error: function() {
                        console.log('Error fetching the next ID.');
                    }
                });
                
                } 
                else {
                      toastr.error(response.message);
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

$(document).on("click", "#delete_product", function(e) {
    e.preventDefault();


    var del_id = $(this).data("id");

        console.log(del_id);

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "get",
                url: base_url+"/account/delete/" + parseInt(del_id),
                data: { delete: parseInt(del_id) },  // Updated the URL with the correct format
                dataType: "json",
                success: function(response) {
                    if (response.res == "success") {
                        Swal.fire(
                            "Deleted!",
                            "Your file has been deleted.",
                            "success"
                        );
                         $("#example").DataTable().clear().destroy();
                        fetch();  //  // Refetch the data
                        //$("#example").DataTable().ajax.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        }
    });
});


/* -------------------------------------------------------------------------- */
/*                                Edit Records                                */
/* -------------------------------------------------------------------------- */
$(document).on("click", "#viewledger", function(e) {
    var cid = $(this).data("id");
    window.location.href = `getledger/${cid}`;
});


// $(document).on("click", "#viewledger", function(e) {

//         var infoid = $(this).data("id");

//         console.log(infoid);

//         //const infoid = ;
        
//         // AJAX request to fetch ledger details
//         $.ajax({
//             url: `getledger?infoid=${infoid}`,
//             type: 'GET',
//             dataType: 'json',
//             success: function(data) {
//                 console.log(data);
//                 let html = '<table><tr><th>Date</th><th>Description</th><th>Amount</th></tr>';
                
//                 data.forEach((row) => {
//                     html += `<tr>
//                                 <td>${row.date}</td>
//                                 <td>${row.description}</td>
//                                 <td>${row.amount}</td>
//                              </tr>`;
//                 });
                
//                 html += '</table>';
//                 $('#example').html(html);
//             },
//             error: function() {
//                 $('#example').html('<p>Error loading ledger details.</p>');
//             }
//         });
//     });


/* -------------------------------------------------------------------------- */
/*                               Update Records                               */
/* -------------------------------------------------------------------------- */


$(document).on("click", "#Update", function(e) {
    e.preventDefault();

      isValid = true;

    // Clear previous error messages
    $('#ctypeedit_error').text('');
    $('#opbaledit_error').text('');
    

    $('#opbaledit, #ctypeedit').removeClass('is-invalid');

    // Validate Address
    if ($('#opbaledit').val().trim() === '') {
        $('#opbaledit_error').text('Opening Balance is required.');
        $('#opbaledit').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    
    if ($('#ctypeedit').val().trim() === '') {
    $('#ctypeedit_error').text('Please select a Company.');
    $('#ctypeedit').addClass('is-invalid');  // Add to the hidden select
    $('#ctypeedit').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add to Select2 container
    isValid = false;
} else {
    $('#ctypeedit').removeClass('is-invalid');
    $('#ctypeedit').next('.select2').find('.select2-selection').removeClass('is-invalid'); // Remove red border
    $('#ctypeedit_error').text('');  // Clear error message
}


    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        return;
    } else {
        // Get form data

  // Get form data
        let aidedit = $("#aidedit").val();
        let opbaledit = $("#opbaledit").val();
        let ctypeedit = $("#ctypeedit").val();

        console.log(aidedit);
        console.log(opbaledit);
        console.log(ctypeedit);

        
        var fd = new FormData();
        fd.append("aidedit", aidedit);
        fd.append("opbaledit", opbaledit);
        fd.append("ctypeedit", ctypeedit);

        console.log(fd);

        $.ajax({
            type: "post",
            url: base_url + "/account/update",
            data: {
            opening_bal: opbaledit,
            cid: ctypeedit,
            aid: aidedit
        },  
            dataType: "json",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
             },

            success: function(response) {
                if (response.res === "success") {
                    console.log(response);

                    console.log("Executed Query: ", response.query);

                    //toastr["success"](response.message);
                    $("#modal-default1").modal("hide");
                      $("#example").DataTable().clear().destroy();
                    fetch();  // Refetch the data

                } else {
                    console.log(response.message);
                }
            },
            error: function(xhr, status, error) {
            console.error(error);
          }
        });
    }
 });
