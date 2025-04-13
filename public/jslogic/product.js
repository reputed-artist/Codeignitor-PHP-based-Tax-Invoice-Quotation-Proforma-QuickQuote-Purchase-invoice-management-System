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

$(document).on("click", "#viewproduct", function(e) {
    var infoid = $(this).data("id");
    console.log(infoid);
    window.location.href = `viewproductinfo/${infoid}`;
});


$('#ptype').on('change', function() {
    var selectedType = $(this).val();
    if (selectedType === 'Freight') {
      $('#cattype').prop('disabled', true).val('').trigger('change'); // reset & disable
    } else {
      $('#cattype').prop('disabled', false); // enable if not Freight
    }
  });

$('#ptypeedit').on('change', function() {
    var selectedType = $(this).val();
    if (selectedType === 'Freight') {
      $('#cattypeedit').prop('disabled', true).val('').trigger('change'); // reset & disable
    } else {
      $('#cattypeedit').prop('disabled', false); // enable if not Freight
    }
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


// $('#modal-default1').on('hidden.bs.modal', function () {
//     // Reset all input validations
//     $('#modal-default1').find('input, select, textarea').removeClass('is-invalid is-valid');

//     // Reset Select2 styling
//     $('#modal-default1').find('.select2').each(function() {
//         $(this).val(null).trigger('change'); // Clear selection
//         $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid is-valid');
//     });

//     // Reset form fields (assuming a form exists inside the modal)
//     $('#modal-default1').find('form')[0].reset();

//     // Optionally hide custom error messages
//     // $('#modal-default').find('.error, .text-danger').text('').hide();
//     $('#modal-default1').find('[id$="_error"]').text('').hide();

// });



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
        url: base_url + "/product/edit/"+ parseInt(edit_id),
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
            $('#pidedit').val(response.post.p_id);
            // Populate modal fields (assuming response contains these fields)

            $('#pnameedit').val(response.post.name);
            $('#pdescedit').val(response.post.description);
            $('#hsnedit').val(response.post.hsn);
            //$('#ptypeedit').val(response.post.ptype);
                       
            $('#ptypeedit').val(response.post.p_type).trigger('change'); // for Select2
            $('#cattypeedit').val(response.post.cattype).trigger('change'); // for Select2
           
               var imageUrl = base_url + "/public/dist/img/" + encodeURIComponent(response.post.img_loc || "default.jpg");
              $('#uploadimg1').attr('src', imageUrl);
              console.log(imageUrl);

              $('#techs1').val(response.post.techs);


            //var countryCode = response.post.country; // e.g., 'in' for India
            // $('#address_countryedit').val(countryCode).trigger('change');    
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
        url: base_url + "/product/manageproducts", // Using base_url defined in the view
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
        //     { width: '18%', targets: 4 }, // gst  
        //     { width: '50%', targets: 5 }, //email
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
                    { 'data': 'name',defaultContent: ''},

                    { 'data': 'description',defaultContent: ''  },
                    { 'data': 'hsn',defaultContent: ''  },

                    { 'data': 'p_type' ,render: function (data, type, row, meta) {
                                if(data == "Machine")
                                {
                                  return '<span class="label label-success">' + data + '</span>';
                                }else if(data == "Consumables") {
                                  return  '<span class="label label-warning">' + data + '</span>'; 
                                }
                                else {
                                        return  '<span class="label label-danger">' + data + '</span>';    
                                }
                            }
                        },

                    { 'data': 'created',defaultContent: '' },

                    {
                      'data': 'editaction',
                         render: function (data, type, row, meta) {
                             return '<a class="btn btn-primary btn-xs" id="edit_product" data-id="' + row.p_id + '"><i class="fa fa-pencil" style="width:15px;height:10px"></i></a>';
                         }
                      },

                    {
                      'data': 'viewaction',
                         render: function (data, type, row, meta) {
                            return `<a href="viewproductinfo/${row.p_id}" class="btn btn-warning btn-xs" id="viewproduct" data-id="${row.p_id}">
                    <i class="fa fa-fw fa-eye" style="width:15px;height:10px"></i></a>`;

                                //return '<a href="get-info.php?infoid=' + row.p_id + '"><button class="btn btn-warning btn-xs"><i class="fa fa-fw fa-eye"></i></button></a>';
                         }
                      },
                       
                    {
                      'data': 'deleteaction',
                         render: function (data, type, row, meta) {
                                return '<a class="btn btn-danger btn-xs" id="delete_product" data-id="' + row.p_id + '" ><i class="fa fa-trash-o"  style="width:15px;height:10px"></i></a>';
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
$('#file_input').change(function () {
    var formData = new FormData();
    var file = $('#file_input')[0].files[0];
    
    if (file) {
        formData.append('uploadimg', file); // Change to match controller key

        $.ajax({
    url: base_url + "/product/uploadproductimage",  // Ensure correct route
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',  // Expect JSON response from the server
    success: function(response) {
        if (response.success) {
            console.log('Image uploaded successfully: ' + response.filename);
            imgname = response.filename;  // Save the uploaded image name
            // You can also update the image preview here
            $('#uploadimg').attr('src',base_url + '/public/dist/img/' + response.filename);
            formData.append('imgname', response.filename);  
        } else {
            console.log('Error: ' + response.message);
        }
    },
    error: function(xhr, status, error) {
        console.log('Error uploading image: ' + error);
       }
     });


    }
});

$('#file_input1').change(function () {
    var formData1 = new FormData();
    var file = $('#file_input1')[0].files[0];
    
    if (file) {
        formData1.append('uploadimg1', file); // Change to match controller key

        $.ajax({
    url: base_url + "/product/updateuploadproductimage",  // Ensure correct route
    type: 'POST',
    data: formData1,
    processData: false,
    contentType: false,
    dataType: 'json',  // Expect JSON response from the server
    success: function(response) {
        if (response.success) {
            console.log('Image uploaded successfully: ' + response.filename);
            imgname = response.filename;  // Save the uploaded image name
            // You can also update the image preview here
            $('#uploadimg1').attr('src',base_url + '/public/dist/img/' + response.filename);
        } else {
            console.log('Error: ' + response.message);
        }
    },
    error: function(xhr, status, error) {
        console.log('Error uploading image: ' + error);
       }
     });


    }
});


$(document).on("click", "#submit", function(e) {
    e.preventDefault();

     isValid = true;

    // Clear previous error messages
    $('#pname_error').text('');
    $('#pdesc_error').text('');
    $('#hsn_error').text('');
    $('#ptype_error').text('');
    //$('#file_input_error').text('');

    

    $('#pname, #pdesc, #hsn, #ptype').removeClass('is-invalid');

    // Validate Company Name
    if ($('#pname').val().trim() === '') {
        $('#pname_error').text('Product name is required.').show();
        $('#pname').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Address
    if ($('#pdesc').val().trim() === '') {
        $('#pdesc_error').text('Description is required.').show();
        $('#pdesc').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Mobile Number
    if ($('#hsn').val().trim() === '') {
        $('#hsn_error').text('HSN is required.').show();
        $('#hsn').addClass('is-invalid'); // Highlight the field

    isValid = false;
        
    }

    

    if ($('#ptype').val().trim() === '') {
        $('#ptype_error').text('Product Type is required.').show();
        $('#ptype').addClass('is-invalid');  // Add to the hidden select
        $('#ptype').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add to Select2 container
        isValid = false;
    } else {
        $('#ptype').removeClass('is-invalid');
        $('#ptype').next('.select2').find('.select2-selection').removeClass('is-invalid'); // Remove red border
        $('#ptype_error').text('');  // Clear error message
    }




    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        return;
    } else {
        // Get form data


    var pid = $("#pid").val();   
    var pname = $("#pname").val();
    var pdesc = $("#pdesc").val();
    var hsn = $("#hsn").val();
    var ptype = $("#ptype").val();
    var cattype=$("#cattype").val();
    var imgname=$("#imgname").val();
    
    console.log(pid);
    console.log(pname);
    console.log(pdesc);
    console.log(hsn);
    console.log(ptype);
    console.log(cattype);
    
    var fd = new FormData();
    fd.append("p_id", pid);
    fd.append("name", pname);
    fd.append("description", pdesc);
    fd.append("hsn", hsn);
    fd.append("ptype", ptype);
    fd.append("cattype",cattype);

   //fd.append('imgname', $('#file_name').val());  
    if (imgname) {
        fd.append('imgname', imgname); // Add the uploaded file name
    }

      
   var fileInput = $('#file_input')[0].files[0];
    if (fileInput) {
        fd.append('file_input', fileInput); // Append the file

    }

    // Append the technical description if available
    var techDesc = $('#techs').val().trim();
    if (techDesc !== '') {
        fd.append('techs', techDesc);  // Append the tech description
    }
  

     console.log(fd);    

       $.ajax({
            url: base_url + "/product/insert",
            type: 'post',
            data: fd,
            processData: false,
            contentType: false,
            dataType:'json',
            success: function (response) {
                console.log(response);
                //var jsonResponse = JSON.parse(response);
                $("#modal-default").modal("hide");

                $("#form")[0].reset();
                //$("#ptype").val(null).trigger('change');
                //$("#ptype").select2('destroy').val('').select2();
                $(".select2").val(null).trigger('change');  
                 
                $("#uploadimg").attr("src", $("#uploadimg").data("default")); 
                    
                if (response.success) {
                     Swal.fire({
                    title: "Good!",
                    text: "New Product Data Inserted!",
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
                
                  $(".select2").val(null).trigger('change');  

                  $("#uploadimg").attr("src", $("#uploadimg").data("default")); 

                   $.ajax({
                        url: base_url + '/product/get_next_id', // Ensure correct base_url
                        method: 'GET',
                        dataType: "json",
                        success: function(data) {
                            if (data.next_id) {
                                $('#pid').val(data.next_id); // Set the new ID value
                                console.log("New ID received: ", data.next_id);
            
            // Force update the readonly input
                                //$('#cid').prop('readonly', false).val(data.next_id).prop('readonly', true);
                                $('#pid').prop('disabled', false).val(data.next_id).prop('disabled', true);

                            } else {
                                console.log("Invalid response:", data);
                            }
                            
                            //$('#form')[0].reset();
                        },
                        error: function(xhr, status, error) {
                            console.log('Error fetching the next ID:', error);
                        }
                    });

                    //alert('Product added successfully');
                    //$('#modal-default').modal('hide');  // Hide modal
                    //location.reload();  // Reload the page
                } else {
                    //alert(response.message);
                }
            },
            error: function () {
                console.log('Error submitting the form');
            }
        });
    };
});






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
                url: base_url+"/product/delete/" + parseInt(del_id),
                data: { delete: parseInt(del_id) },  // Updated the URL with the correct format
                dataType: "json",
                success: function(response) {
                    if (response.res == "success") {

                        Swal.fire(
                            "Deleted!",
                            "Your Product has been deleted.",
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

// $(document).on("click", "#update", function(e) {
//      e.preventDefault();

//     var cid = $("#cid").val();   
//     var c_name = $("#c_name").val();
//     var c_add = $("#c_add").val();
//     var fullno = $("#fullno").val();
//     var country = $("#address_country option:selected").text();
//             console.log(country);
//     var gst = $("#gst").val();

//     var ctype = $("#ctype").val();

//     if (c_name === "" || c_add === "" || mob === "" || gst === "" || ctype === "") {
//         console.log(cid);
//         console.log(c_name);
//         console.log(c_add);
//         console.log(fullno);
//         console.log(country);
//         console.log(gst);
//         console.log(ctype);
//         //alert("All fields are required");
//     } else {
//         var fd = new FormData();
//         fd.append("cid",cid);
//         fd.append("c_name", c_name);
//         fd.append("c_add", c_add);
//         fd.append("fullno", fullno);
//         fd.append("country",country);
//         fd.append("gst", gst);
//         fd.append("ctype", ctype);

//                 // Log FormData for debugging
//         for (var pair of fd.entries()) {
//             console.log(pair[0] + ', ' + pair[1]);
//         }

//         console.log(fd);    


//         $.ajax({
//             type: "post",
//             url: base_url + "/client/update",
//             data: fd,
//             processData: false,
//             contentType: false,
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
//             },
//             dataType: "json",
//             success: function(response) {
//                 if (response.res === "success") {
//                     //toastr["success"](response.message);
//                     $("#modal-default").modal("hide");
//                     $("#form1")[0].reset();

//                     //$("#editForm")[0].reset();
//                     //$(".edit-file-label").html("Choose file");
//                     $("#example1").DataTable().clear().destroy();
//                     fetch();
//                     //$("#example1").DataTable().ajax.reload(); 
//                 } else {
//                     //toastr["error"](response.message);
//                 }
//             },
//              error: function(xhr, status, error) {
//                 console.error("AJAX Error: ", status, error);
//             }

//         });
//     }
// });

$(document).on("click", "#Update", function(e) {
    e.preventDefault();

     isValid = true;

    // Clear previous error messages
    $('#pname_error1').text('');
    $('#pdesc_error1').text('');
    $('#hsn_error1').text('');
    $('#ptype_error1').text('');
    $('#ctype_error1').text('');

    // // Validate Company Name
    // if ($('#c_nameedit').val().trim() === '') {
    //     $('#c_name_error').text('Company name is required.');
    //     isValid = false;
    // }

    //$('#c_nameedit, #c_addedit, #phoneedit, #gstedit, #ctypeedit').addClass('is-valid');

    $('#pnameedit, #pdescedit,#hsnedit, #ptypeedit').removeClass('is-invalid');


    // Validate Company Name
    if ($('#pnameedit').val().trim() === '') {
        $('#pname_error1').text('Product name is required.');
        $('#pnameedit').addClass('is-invalid'); // Highlight the field
        //$('#c_nameedit').addClass('is-invalid');
        isValid = false;
    }

    // Validate Address
    if ($('#pdescedit').val().trim() === '') {
        $('#pdesc_error1').text('Description is required.');
        $('#pdescedit').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }


    if ($('#hsnedit').val().trim() === '') {
        $('#hsn_error1').text('HSN is required.');
        $('#hsnedit').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Bill Type
    // if ($('#ctype').val().trim() === '') {
    //     $('#ctype_error').text('Please select a Bill Type.');
    //  $('#ctype').addClass('is-invalid');  // Add to the hidden select (optional for form data)
    // $('#ctype').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add class to Select2 container
    // isValid = false;
    // }

    if ($('#ptypeedit').val().trim() === '') {
    $('#ptype_error1').text('Product Type is required.');
    $('#ptypeedit').addClass('is-invalid');  // Add to the hidden select
    $('#ptypeedit').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add to Select2 container
    isValid = false;
} else {
    $('#ptypeedit').removeClass('is-invalid');
    $('#ptypeedit').next('.select2').find('.select2-selection').removeClass('is-invalid'); // Remove red border
    $('#ptype_error1').text('');  // Clear error message
}



    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        return;
    } else {
        // Get form data

var pidedit = $("#pidedit").val();   
    var pnameedit = $("#pnameedit").val();
    var pdescedit = $("#pdescedit").val();
    var hsnedit = $("#hsnedit").val();
    var ptypeedit = $("#ptypeedit").val();
    var cattypeedit = $("#cattypeedit").val();
    
    console.log(pidedit);
    console.log(pnameedit);
    console.log(pdescedit);
    console.log(hsnedit);
    console.log(ptypeedit);
    console.log(cattypeedit);
    
    var fd = new FormData();
    fd.append("p_id", pidedit);
    fd.append("name", pnameedit);
    fd.append("description", pdescedit);
    fd.append("hsn", hsnedit);
    fd.append("ptype", ptypeedit);
    fd.append("cattype",cattypeedit);

    //fd.append('imgname', $('#file_name').val());  

      
var fileInput = $('#file_input1')[0].files[0];
    if (fileInput) {
        fd.append('file_input1', fileInput); // Append the file

    }

    // Append the technical description if available
    var techDesc = $('#techs1').val().trim();
    if (techDesc !== '') {
        fd.append('techs1', techDesc);  // Append the tech description
    }
  

     console.log(fd);

        $.ajax({
            type: "post",
            url: base_url + "/product/update",
            data: fd,
            processData: false,
            contentType: false,
            headers: {
                 'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
             },
            dataType: "json",
            success: function(response) {
                if (response.res == "success") {
                    $("#modal-default1").modal("hide");
                    $("#form1")[0].reset();
                    //console.log(response);
                    //toastr["success"](response.message);
                    // $("#modal-default1").modal("hide");
                    //  $("#example1").DataTable().clear().destroy();
                    //     fetch();  // Refetch the data
                      Swal.fire({
                    title: "Good!",
                    text: "Product Data Updated!",
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
