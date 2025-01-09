<?php


$current_page="manage-purlist";
//$current_page1="manage-invlist";
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Advanced form elements</title>

<?= $this->include('include/links.php');?>

 
<style type="text/css">
  img {
    image-rendering: -webkit-optimize-contrast !important;
  }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="loader"></div>
<div class="wrapper">


<?= $this->include('include/header.php');?>


  <?= $this->include('include/sidebar.php');?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quotation List
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Quotation List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
           <div class="box-header">
               <form action="" method="GET">

                <!-- Place the filter icon first -->
                <div class="col-md-1">
                    <h3 class="box-title">
                        <i class="fa fa-fw fa-filter fa-3x"></i>
                    </h3>
                </div>
                
                <!-- Select Client -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select Client:</label>
                        <select name="client" id="client" class="form-control select2" style="height: 35px !important;width:100% !important;">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                
                <!-- Select Product -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select Product:</label>
                        <select name="product" id="product" class="form-control select2" style="height: 35px !important;width:100% !important;">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                
                <!-- Select Year -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select Year:</label>
                        <select name="year" id="year" class="form-control select2" style="height: 35px !important;width:100% !important;">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label></label></br>
                        <!-- <input type="submit" class="btn btn-success" name="submit"> -->
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


      <div class="row">
                    
                  <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover" id="tinvoices" name="tinvoices">
                            
                                              <!-- <div align="center">
                                              <font color='red' align='center'>No Records Found </font>       
                                              </div> -->                                       
                                           
                                  
             
                            </table>
           

                            <div class="page" style="text-align: center;">
                            <nav aria-label="Page navigation example">
                            
                            <ul id="pagination" class="pagination"></ul>
                            </nav>
                            </div>
                              
                              

                              
                            </div>
                    </div>
                        
                        
                     
  </div>
</div>  
</section>


<?= $this->include('include/footer.php');?>

<?= $this->include('include/settings.php');?>


<!-- <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
       placeholder: "Select a Person or Company",
    allowClear: true
    });

  });

  
</script>
 -->
<script>
   
    var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>

<script>
    //var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS

function updatePagination(totalRecords, resultsPerPage, currentPage) {
    var totalPages = Math.ceil(totalRecords / resultsPerPage);
    var maxVisiblePages = 5; // Limit the number of visible page links
    $('#pagination').empty(); // Clear pagination

    // Calculate start and end page numbers
    var startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    var endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

    // Adjust if near the beginning or end of the range
    if (currentPage <= Math.floor(maxVisiblePages / 2)) {
        endPage = Math.min(totalPages, maxVisiblePages);
    }
    if (totalPages - currentPage < Math.floor(maxVisiblePages / 2)) {
        startPage = Math.max(1, totalPages - maxVisiblePages + 1);
    }

    // Previous button
    var prevButton = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" 
                           onclick="event.preventDefault(); 
                                    if(${currentPage} > 1) loadInvoices(${currentPage - 1});"
                           ${currentPage === 1 ? 'tabindex="-1" aria-disabled="true"' : ''}>
                           Previous
                        </a>
                      </li>`;
    $('#pagination').append(prevButton);

    // First page button if current view doesn't start with the first page
    if (startPage > 1) {
        $('#pagination').append(`<li class="page-item"><a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(1);">1</a></li>`);
        if (startPage > 2) {
            $('#pagination').append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
        }
    }

    // Page number buttons within the visible range
    for (var i = startPage; i <= endPage; i++) {
        var activeClass = (i === currentPage) ? 'active' : '';
        var pageButton = `<li class="page-item ${activeClass}">
                            <a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(${i});">${i}</a>
                          </li>`;
        $('#pagination').append(pageButton);
    }

    // Last page button if the current view doesn’t end with the last page
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            $('#pagination').append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
        }
        $('#pagination').append(`<li class="page-item"><a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(${totalPages});">${totalPages}</a></li>`);
    }

    // Next button
    var nextButton = `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" 
                           onclick="event.preventDefault(); 
                                    if(${currentPage} < ${totalPages}) loadInvoices(${currentPage + 1});"
                           ${currentPage === totalPages ? 'tabindex="-1" aria-disabled="true"' : ''}>
                           Next
                        </a>
                      </li>`;
    $('#pagination').append(nextButton);
}

    var selectedYear = null;
    var selectedClient = null;
    var selectedProduct=null;


    // Function to load invoices based on the page number
    function loadInvoices(page, year = null, client = null,product=null) {
        console.log("Loading invoices for page: " + page); // Add this line
        $.ajax({
            url: base_url + '/quote/showquotedata',
            type: 'GET',
            data: { page: page,
                    year: year,
                    client: client,
                    product:product,
                  }, // Send the current page number to the server
            dataType: 'json',
            success: function(response) {
                console.log("res"+response);
                //console.log(response.debug); // Inspect the response structure

                if (response.invoices && Array.isArray(response.invoices)) {
                    $('#tinvoices').empty(); // Clear previous data

                    response.invoices.forEach(function(invoice) {
                        var html = `
                            <a href="printquote?orderid=${invoice.orderid}" target="_blank">
                                <div class="col-md-4" id="example1">
                                    <div class="box box-info">
                                        <div class="box-header">
                                            <h3 class="box-title">${invoice.invid}</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="form-group">
                                                <strong><p align="center" style="color:black;">${invoice.c_name}</p></strong>
                                                <p align="center"><strong>Location:</strong> ${invoice.location}</p>
                                                <p align="center"><strong>Item name:</strong> ${invoice.item_name}</p>
                                                <p align="center"><strong>Total Bill:</strong> ${invoice.totalamount}</p>
                                                <p align="center"><strong>Invoice Dated:</strong> ${invoice.created}</p>
                                                <br/>
                                                <a href="editquote?orderid=${invoice.orderid}">
                                                    <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                </a>
                                                <a class="btn btn-danger btn-xs pull-right" id="delete_product" data-id="${invoice.orderid}">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </a>`;
                        $('#tinvoices').append(html);
                    });

                    // Update pagination controls
                    updatePagination(response.total_records, response.results_per_page, response.current_page);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
                console.log(xhr.responseText);
            }
        });
    }


 $(document).ready(function() {
        loadInvoices(1);
        
    var selectedYear = null;
    var selectedClient = null;
    var selectedProduct = null;

    // Initialize Select2 for each dropdown
    $('#client').select2({
        placeholder: "Select a Person or Company",
        allowClear: true,
        ajax: {
            url: "<?= base_url();?>/quote/getclient",
            type: "GET",
            dataType: "json",
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




    $('#product').select2({
    placeholder: "Select product",
    allowClear: true,
    ajax: {
        url: "<?= base_url();?>/quote/getproducts", // Controller method
        type: "GET",
        dataType: "json",
        delay: 250, // Add a delay to limit requests for better performance
        data: function(params) {
            // Send the current input value to the server as 'category_name'
            return {
                category_name: params.term || '' // params.term is the search term
            };
        },
        processResults: function(data) {
            console.log(data); // For debugging, remove this after testing
            // Process the returned data array and map it to Select2 format
            return {
                results: data.map(function(item) {
                    return {
                        id: item.name, // This will be used as the value of the option
                        text: item.name // This will be displayed in the dropdown
                    };
                })
            };
        },
        cache: true
    }
});

   $('#year').select2({
    placeholder: "Select Year",
    allowClear: true,
    ajax: {
        url: "<?= base_url();?>/quote/getyear", // Controller method
        type: "GET",
        dataType: "json",
        delay: 250, // Add a delay to limit requests for better performance
        processResults: function(data) {
            // Format the response data for Select2
            return {
                results: $.map(data, function(item) {
                    return {
                        id: item.id, // Use the financial year as the id
                        text: item.text // Display the financial year as the text
                    };
                })
            };
        }
    }
});



//     // Submit event for form
//     $('form').on('submit', function(e) {
//         e.preventDefault(); // Prevent form from submitting traditionally
//         loadInvoices(1, selectedYear, selectedClient, selectedProduct);
//     });
// });





$('#client').on('select2:select', function() {
    selectedClient = $(this).val();
    loadInvoices(1, selectedYear, selectedClient, selectedProduct);
});

$('#product').on('select2:select', function() {
    selectedProduct = $(this).val();
    loadInvoices(1, selectedYear, selectedClient, selectedProduct);
});

$('#year').on('select2:select', function() {
    selectedYear = $(this).val();
    loadInvoices(1, selectedYear, selectedClient, selectedProduct);
});


    $(document).on('click', '#delete_product', function(e) {
        e.preventDefault(); // Prevent default action

        var productId = $(this).data('id');

        swal.fire({
            title: 'Are you sure?',
            text: "It will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            allowOutsideClick: false        
        }).then((result) => {
            if (result.isConfirmed) {
                // Make the AJAX call to delete the product
                $.ajax({
                    url: base_url + '/quote/delete/' + productId, // Include productId in the URL
                    type: 'POST', // Use POST for delete action
                    dataType: 'json'
                })
                .done(function(response) {
                    // Display success message using Swal.fire
                    Swal.fire({
                        title: 'Deleted!',
                        text: response.message,
                        icon: 'success', // Assuming success status
                        showConfirmButton: true,
                        timer: 2000 // Auto close the alert after 2 seconds
                    });

                    // Refresh the product list or perform other actions as needed
                    loadInvoices(1);
                })
                .fail(function() {
                    // Display error message using Swal.fire
                    Swal.fire('Oops...', 'Something went wrong with ajax!', 'error');
                });
            }
        });

        console.log((productId));
    });

 });     
</script>


</body>
</html>
