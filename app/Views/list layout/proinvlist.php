
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
        Proforma Invoice List
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Proforma Invoice List</li>
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
<!--                         <input type="submit" class="btn btn-success" name="submit"> -->
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

  
</script> -->

<script>
   
    var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>

<script>
  

  // Global variables to store current filter selections
let selectedYear = '';
let selectedClient = '';
let selectedProduct = '';

// Function to load invoices based on current filters and page
function loadInvoices(page = 1) {

        console.log("Loading invoices for page: " + page); // Add this line
        $.ajax({
            url: base_url + '/proinv/showprodata',
            type: 'GET',
            data: { 
              page: page,
              year: selectedYear,
              client: selectedClient,
              product: selectedProduct
            },

            dataType: 'json',
            success: function(response) {
                console.log("res"+response);
                //console.log(response.debug); // Inspect the response structure

                if (response.invoices && Array.isArray(response.invoices)) {
                    $('#tinvoices').empty(); // Clear previous data

                    response.invoices.forEach(function(invoice) {
                        var html = `
                           <a href="printproinv?orderid=${invoice.orderid}" target="_blank">
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
                                                <a href="editproinv?orderid=${invoice.orderid}">
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
            } else {
                $('#tinvoices').html('<p>No data found.</p>');
                $('#pagination').empty();
            }
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
            console.log(xhr.responseText);
        } 
    });
}
function updatePagination(totalRecords, resultsPerPage, currentPage) {
    const totalPages = Math.max(1, Math.ceil(totalRecords / resultsPerPage)); // Ensure at least 1 page
    const pagination = $('#pagination');
    pagination.empty();

    // Always show Prev (disabled if on first page)
    if (currentPage > 1) {
        pagination.append(`
            <li class="page-item">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(${currentPage - 1});">Prev</a>
            </li>
        `);
    } else {
        pagination.append(`
            <li class="page-item disabled">
                <span class="page-link">Prev</span>
            </li>
        `);
    }

    // Show page numbers (at least one page)
    for (let i = 1; i <= totalPages; i++) {
        let active = (i === currentPage) ? 'active' : '';
        pagination.append(`
            <li class="page-item ${active}">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(${i});">${i}</a>
            </li>
        `);
    }

    // Always show Next (disabled if on last page)
    if (currentPage < totalPages) {
        pagination.append(`
            <li class="page-item">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(${currentPage + 1});">Next</a>
            </li>
        `);
    } else {
        pagination.append(`
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        `);
    }
}



    $(document).ready(function() {
    // Call this function when the page is loaded to load the first page
    loadInvoices(1);

         $('#client').select2({
            placeholder: "Select a Person or Company",
            allowClear: true,
            ajax: {
            url: "<?= base_url();?>/proinv/getclient", // Controller method
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
            url: "<?= base_url();?>/proinv/getproducts", // Controller method
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
        url: "<?= base_url();?>/proinv/getyear", // Controller method
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
                    url: base_url + '/proinv/delete/' + productId, // Include productId in the URL
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
