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
    $(this).find('form')[0].reset(); 
        $(this).find('.is-invalid').removeClass('is-invalid'); // Remove 'is-invalid' class
    $(this).find('.invalid-feedback').remove(); // Remove error message elements if any

    // Reset Select2 fields if any
    $(this).find('select').val(null).trigger('change');
        $(this).find('div[id$="_error"]').text(''); 


    $('#phone').removeClass('is-invalid is-valid');
    $('.iti').removeClass('is-invalid is-valid');
    $('#error-msg').hide();
});


$('#modal-default1').on('hidden.bs.modal', function () {
    //$(this).find('form1')[0].reset(); 
        $(this).find('.is-invalid').removeClass('is-invalid'); // Remove 'is-invalid' class
    $(this).find('.invalid-feedback').remove(); // Remove error message elements if any

    // Reset Select2 fields if any
    //$(this).find('select').val(null).trigger('change');

    $('#phoneedit').removeClass('is-invalid is-valid');
    $('.iti2').removeClass('is-invalid is-valid');
    $('#error-msg2').hide();
});


$('#modal-default2').on('shown.bs.modal', function () {
    validatePhoneField(); // Initial validation for phone field when modal is shown
});


// $(document).on("click", "#viewclient", function(e) {
//     var infoidz = $(this).data("id");
//     console.log(infoidz);
//     window.location.href = base_url+`/viewclientinfo/${infoidz}`;
//     //window.location.href = base_url.replace(/\/$/, '') + `/client/viewclientinfo/${infoidz}`;

// });
$(document).on("click", "#viewclient", function(e) {
    e.preventDefault(); // Prevent default behavior

    var infoid = $(this).data("id"); // Get the client ID from the button
    console.log("Clicked client ID:", infoid); // Debugging output

    if (!infoid || isNaN(infoid)) {
        console.error("Invalid Client ID:", infoid);
        return;
    }

    window.location.href = base_url.replace(/\/$/, '') + "/client/viewclientinfo/" + encodeURIComponent(infoid);
});


function validatePhoneField() {
    var phoneField = $('#phoneedit');
    var fullNumber = iti2.getNumber(); // Get full international number from intl-tel-input

    if (phoneField.val().trim()) {
        // If phone field has valid data, set as valid
        if (iti2.isValidNumber()) {
            phoneField.removeClass('is-invalid').addClass('is-valid');
            $('.iti2').removeClass('is-invalid').addClass('is-valid');
            $('#error-msg2').hide();
        } else {
            // If data is invalid
            phoneField.addClass('is-invalid');
            $('.iti2').addClass('is-invalid');
            var errorCode2 = iti2.getValidationError();
            $('#error-msg2').text(errorMap2[errorCode2]).show();
        }
    } else {
        // If phone field is empty, set to invalid
        phoneField.addClass('is-invalid');
        $('.iti2').addClass('is-invalid');
        $('#error-msg2').text('Mobile number is required.').show();
    }
}

// On input or change, validate the phone field again
$('#phoneedit').on('keyup change', function() {
    validatePhoneField();
});

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
        url: base_url + "/client/edit/"+ parseInt(edit_id),
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
            $('#cidedit').val(response.post.cid);
            // Populate modal fields (assuming response contains these fields)

            $('#c_nameedit').val(response.post.c_name);
            $('#c_addedit').val(response.post.c_add);
            $('#email1').val(response.post.mob);
            $('#phoneedit').val(response.post.mob);
            $('#gstedit').val(response.post.gst);
            $('#email1').val(response.post.email);
            $('#ctypeedit').val(response.post.c_type).trigger('change'); // for Select2

            $('#utype1').val(response.post.u_type).trigger('change');

            iti2.setNumber(response.post.mob);

                // Ensure consistent formatting when user interacts with the input
                input2.addEventListener('focus', function() {
                    var fullNumber = iti2.getNumber(intlTelInputUtils.numberFormat.E164); // Get the full number with country code
                    iti2.setNumber(fullNumber); // Re-set the number to ensure correct format
                });

                input2.addEventListener('blur', function() {
                    var fullNumber = iti2.getNumber(intlTelInputUtils.numberFormat.E164); // Get the full number with country code
                    iti2.setNumber(fullNumber); // Re-set the number to 
                });
   
            // Show the modal
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





/* -------------------------------------------------------------------------- */
/*                                Fetch Records                               */
/* -------------------------------------------------------------------------- */
function fetch() {
    console.log("fetch called from insert");

    $.ajax({
        type: "get",
        url: base_url + "/client/manageclients", // Using base_url defined in the view
        //'type': 'GET',
        dataSrc: 'aaData',
        dataType:'json',
        success: function(response) {
            console.log(response);  
            //$('#example1').DataTable().clear().destroy();
             var table = $("#example1").DataTable({
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
                buttons: getExportButtons('#example1',[0,1,2,3,4,5,6,7]),  
        //      columnDefs: [
        //     { width: '5%', targets: 0 },  // Set 20% width to the first column (index 0)
        //     { width: '20%', targets: 1 },  // Set 30% width to the second column (index 1)
        //     { width: '40%', targets: 2 }, //add
        //     { width: '15%', targets: 3 }, // mobile
        //     { width: '18%', targets: 4 }, // g        //     { width: '50%', targets: 5 }, //email
        //     { width: '30%', targets: 6 }, //bill type
        //     { width: '30%', targets:7 }, // u type
        //     { width: '10%', targets: 8 }, // edit
        //     { width: '10%', targets: 9 },   // view
        //     { width: '10%', targets: 10 },   // del
        // ],
        // fixedColumns: true, 
                //'data': response,
                'columns': [
                    { 'data': 'id',
                        render: function (data, type, row, meta) {
                           return meta.row + meta.settings._iDisplayStart + 1;
                      }
                    },
                    { 'data': 'c_name',defaultContent: ''},
                    { 'data': 'c_add',defaultContent: ''  },
                    { 'data': 'mob',defaultContent: ''  },
                    { 'data': 'gst' ,defaultContent: ''},
                    { 'data': 'email',defaultContent: '' },
                    { 'data': 'c_type',render: function (data, type, row, meta) {
                                if(data == "IGST")
                                {
                                  return '<span class="label label-success">' + data + '</span>';
                                }else {
                                  return  '<span class="label label-warning">' + data + '</span>'; 
                                }
                            }
                        },

                      { 'data': 'u_type',render: function (data, type, row, meta) {
                                if(data == "0")
                                {
                                  return '<span class="label bg-purple">' + 'client' + '</span>';
                                }else {
                                  return  '<span class="label bg-navy">' + 'Dual(Cust/Sup)' + '</span>'; 
                                }
                            }
                        },   


                    {
                      'data': 'editaction',
                         render: function (data, type, row, meta) {
                             return '<a class="btn btn-primary btn-xs" id="edit_product" data-id="' + row.cid + '"><i class="fa fa-pencil" style="width:15px;height:10px"></i></a>';
                         }
                      },

                    {
                      'data': 'viewaction',
                         render: function (data, type, row, meta) {
                               // return '<a href="viewclientinfo.php?infoid=' + row.cid + '"><button class="btn btn-warning btn-xs"><i class="fa fa-fw fa-eye"></i></button></a>';
                                 return `<a href="viewclientinfo/${row.cid}" class="btn btn-warning btn-xs" id="viewclient" data-id="${row.cid}">
                    <i class="fa fa-fw fa-eye" style="width:15px;height:10px"></i></a>`;
                         }
                      },
                       
                    {
                      'data': 'deleteaction',
                         render: function (data, type, row, meta) {
                                return '<a class="btn btn-danger btn-xs" id="delete_product" data-id="' + row.cid + '" ><i class="fa fa-trash-o"  style="width:15px;height:10px"></i></a>';
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
    $('#c_name_error').text('');
    $('#c_add_error').text('');
    $('#mob_error').text('');
    $('#gst_error').text('');
    $('#ctype_error').text('');
    $('#utype_error').text('');
    // // Validate Company Name
    // if ($('#c_nameedit').val().trim() === '') {
    //     $('#c_name_error').text('Company name is required.');
    //     isValid = false;
    // }

    $('#c_name, #c_add, #phone, #gst, #ctype').removeClass('is-invalid');

    // Validate Company Name
    if ($('#c_name').val().trim() === '') {
        $('#c_name_error').text('Company name is required.');
        $('#c_name').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Address
    if ($('#c_add').val().trim() === '') {
        $('#c_add_error').text('Address is required.');
        $('#c_add').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Mobile Number
    if ($('#phone').val().trim() === '') {
        $('#mob_error').text('Mobile number is required.');
        $('#phone').addClass('is-invalid'); // Highlight the field
            //$('#phoneedit').addClass('is-invalid'); 
    $('.iti').addClass('is-invalid');        // Adding class to intl-tel-input wrapper
    isValid = false;
        //isValid = false;
    }

    // Validate GST
    if ($('#gst').val().trim() === '') {
        $('#gst_error').text('GST/PAN/Adhaar is required.');
        $('#gst').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    

    if ($('#ctype').val().trim() === '') {
    $('#ctype_error').text('Please select a Bill Type.');
    $('#ctype').addClass('is-invalid');  // Add to the hidden select
    $('#ctype').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add to Select2 container
    isValid = false;
} else {
    $('#ctype').removeClass('is-invalid');
    $('#ctype').next('.select2').find('.select2-selection').removeClass('is-invalid'); // Remove red border
    $('#ctype_error').text('');  // Clear error message
}


 if ($('#utype').val().trim() === '') {
    $('#utype_error').text('Please select a User Type.');
    $('#utype').addClass('is-invalid');  // Add to the hidden select
    $('#utype').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add to Select2 container
    isValid = false;
} else {
    $('#utype').removeClass('is-invalid');
    $('#utype').next('.select2').find('.select2-selection').removeClass('is-invalid'); // Remove red border
    $('#utype_error').text('');  // Clear error message
}



    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        return;
    } else {
        // Get form data


    var cid = $("#cid").val();   
    var c_name = $("#c_name").val().trim();
    var c_add = $("#c_add").val();
    var fullno = $("#fullno").val();
    var country = $("#fulldetails").val().trim();
            console.log(country);
    var gst = $("#gst").val();

    var ctype = $("#ctype").val();
    var email = $("#email").val();
    var u_type = $("#utype").val();
    
      //var u_type = 0; // Assuming you want this value
        var fd = new FormData();
        fd.append("cid", cid);
        fd.append("c_name", c_name);
        fd.append("c_add", c_add);
        fd.append("fullno", fullno);
        fd.append("fulldetails", country);
        fd.append("gst", gst);
        fd.append("email", email); // Ensure this is included
        fd.append("ctype", ctype);
        fd.append("u_type", u_type); // Ensure this is included

        // console.log("cid: ", cid);
        // console.log("c_name: ", c_name);
        // console.log("c_add: ", c_add);
        // console.log("fullno: ", fullno);
        // console.log("country: ", country);
        // console.log("gst: ", gst);
        // console.log("email: ", email);
        // console.log("ctype: ", ctype);
        // console.log("u_type: ", u_type);


        // console.log(fd);    

        $.ajax({
            type: "post",  // Change this to "post" if using POST
            url: base_url + "/client/insert",
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
                     
                            //$('#form')[0].reset();
                    
                   // $('#address_country').val('in'); 

        // Ensure ITI instance is available and set the default country back to India
        

                 Swal.fire({
                    title: "Good!",
                    text: "New Client Data Inserted!",
                    icon: "success",
                    showConfirmButton: false, // Hide the OK button
                    timer: 3000, // Close the popup after 3 seconds (3000 milliseconds)
                  }).then(function() {
                    // This function will be called after the popup closes
                    //location.reload(); // Refresh the page
                  //window.location.href = base_url+'/client/manageclients';
                  $("#example1").DataTable().clear().destroy();
                    fetch();
                  });

                   $("#form")[0].reset();
               
                    //$("#example1").DataTable().clear().destroy();
                    //fetch();

                     $.ajax({
                        url: base_url + '/client/get_next_id', // Ensure correct base_url
                        method: 'GET',
                        dataType: "json",
                        success: function(data) {
                            if (data.next_id) {
                                $('#cid').val(data.next_id); // Set the new ID value
                                console.log("New ID received: ", data.next_id);
            
            // Force update the readonly input
                                //$('#cid').prop('readonly', false).val(data.next_id).prop('readonly', true);
                                $('#cid').prop('disabled', false).val(data.next_id).prop('disabled', true);

                            } else {
                                console.log("Invalid response:", data);
                            }
                            
                            //$('#form')[0].reset();
                        },
                        error: function(xhr, status, error) {
                            console.log('Error fetching the next ID:', error);
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
                url: base_url+"/client/delete/" + parseInt(del_id),
                data: { delete: parseInt(del_id) },  // Updated the URL with the correct format
                dataType: "json",
                success: function(response) {
                    if (response.res == "success") {
                        Swal.fire(
                            "Deleted!",
                            "Your Client has been deleted.",
                            "success"
                        );
                        $("#example1").DataTable().clear().destroy();
                        fetch();  // Refetch the data
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



/* -------------------------------------------------------------------------- */
/*                               Update Records                               */
/* -------------------------------------------------------------------------- */


$(document).on("click", "#Update", function(e) {
    e.preventDefault();

     isValid = true;

    // Clear previous error messages
    $('#c_name_error1').text('');
    $('#c_add_error1').text('');
    $('#mob_error1').text('');
    $('#gst_error1').text('');
    $('#ctype_error1').text('');
    $('#utype_error1').text('');
    // // Validate Company Name
    // if ($('#c_nameedit').val().trim() === '') {
    //     $('#c_name_error').text('Company name is required.');
    //     isValid = false;
    // }

    //$('#c_nameedit, #c_addedit, #phoneedit, #gstedit, #ctypeedit').addClass('is-valid');

    $('#c_nameedit, #c_addedit,#phoneedit, #gstedit, #ctypeedit').removeClass('is-invalid');
    //$('.iti2').addClass('is-valid');


    $('.iti2').removeClass('is-invalid');

    // Validate Company Name
    if ($('#c_nameedit').val().trim() === '') {
        $('#c_name_error1').text('Company name is required.');
        $('#c_nameedit').addClass('is-invalid'); // Highlight the field
        //$('#c_nameedit').addClass('is-invalid');
        isValid = false;
    }

    // Validate Address
    if ($('#c_addedit').val().trim() === '') {
        $('#c_add_error1').text('Address is required.');
        $('#c_addedit').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

  // Validate Mobile Number
if ($('#phoneedit').val().trim() === '') {
    $('#mob_error1').text('Mobile number is required.');
    $('#phoneedit').addClass('is-invalid'); // Highlight the field
    $('.iti2').addClass('is-invalid');      // Add class to intl-tel-input wrapper
    isValid = false;
} else {
    $('#phoneedit').removeClass('is-invalid');
    $('.iti2').removeClass('is-invalid'); //  when valid
}
// if ($('#phoneedit').val().trim() === '') {
//         $('#mob_error1').text('Mobile number is required.');
//         $('#phoneedit').addClass('is-invalid');
//         $('.iti2').addClass('is-invalid');  // Add class to intl-tel-input wrapper
//         isValid = false;
//     }

    // Validate GST
    if ($('#gstedit').val().trim() === '') {
        $('#gst_error1').text('GST/PAN/Adhaar is required.');
        $('#gstedit').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Bill Type
    // if ($('#ctype').val().trim() === '') {
    //     $('#ctype_error').text('Please select a Bill Type.');
    //  $('#ctype').addClass('is-invalid');  // Add to the hidden select (optional for form data)
    // $('#ctype').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add class to Select2 container
    // isValid = false;
    // }

    if ($('#ctypeedit').val().trim() === '') {
    $('#ctype_error1').text('Please select a Bill Type.');
    $('#ctypeedit').addClass('is-invalid');  // Add to the hidden select
    $('#ctypeedit').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add to Select2 container
    isValid = false;
} else {
    $('#ctypeedit').removeClass('is-invalid');
    $('#ctypeedit').next('.select2').find('.select2-selection').removeClass('is-invalid'); // Remove red border
    $('#ctype_error1').text('');  // Clear error message
}


if ($('#utype1').val().trim() === '') {
    $('#utype_error1').text('Please select a User Type.');
    $('#utype1').addClass('is-invalid');  // Add to the hidden select
    $('#utype1').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add to Select2 container
    isValid = false;
} else {
    $('#utype1').removeClass('is-invalid');
    $('#utype1').next('.select2').find('.select2-selection').removeClass('is-invalid'); // Remove red border
    $('#utype_error1').text('');  // Clear error message
}



    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        return;
    } else {
        // Get form data


    var cid = $("#cidedit").val();   
    var c_name = $("#c_nameedit").val();
    var c_add = $("#c_addedit").val();
    var fullno = $("#fullno2").val();
    var country = $("#fulldetails2").val().trim();
    var gst = $("#gstedit").val();
    var email1 = $("#email1").val();
    var ctype = $("#ctypeedit").val().trim();
    var u_type = $("#utype1").val();

        var fd = new FormData();
        fd.append("cid", cid);
        fd.append("c_nameedit", c_name);
        fd.append("c_addedit", c_add);
        fd.append("fullno2", fullno);
        fd.append("fulldetails2", country);
        fd.append("gstedit", gst);
        fd.append("email1",email1);
        fd.append("ctypeedit", ctype);
        fd.append("u_type", u_type);

        console.log(fullno);

        $.ajax({
            type: "post",
            url: base_url + "/client/update",
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
                    $("#form1")[0].reset();

                    // Reinitialize intl-tel-input with the default country
                    let iti2 = window.intlTelInputGlobals.getInstance(document.querySelector("#phoneedit"));
                    iti2.setCountry("in"); // Change "in" to your preferred default country code    

                     // $("#example1").DataTable().clear().destroy();
                     //    fetch();  // Refetch the data


                   Swal.fire({
                    title: "Good!",
                    text: "Client Data Updated!",
                    icon: "success",
                    showConfirmButton: false, // Hide the OK button
                    timer: 3000, // Close the popup after 3 seconds (3000 milliseconds)
                  }).then(function() {
                    // This function will be called after the popup closes
                    //location.reload(); // Refresh the page
                  //window.location.href = base_url+'/client/manageclients';
                  $("#example1").DataTable().clear().destroy();
                    fetch();

                  });



                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }
 });

$('#modal-default1').on('hidden.bs.modal', function () {
    //$(this).find('form1')[0].reset(); // Reset form
        $(this).find('.is-invalid').removeClass('is-invalid'); // Remove 'is-invalid' class
    $(this).find('.invalid-feedback').remove(); // Remove error message elements if any

    $('#address_country').val(iti.getSelectedCountryData().iso2).trigger('change');
        $('#address_countryedit').val(iti2.getSelectedCountryData().iso2).trigger('change');
    // Reset Select2 fields if any
    //$(this).find('select').val(null).trigger('change');

    //$('#ptypeedit').val(null).trigger('change'); // Reset Select2
    //$('#uploadimg').attr('src', base_url + '/public/dist/img/default.jpg'); // Reset image
});

