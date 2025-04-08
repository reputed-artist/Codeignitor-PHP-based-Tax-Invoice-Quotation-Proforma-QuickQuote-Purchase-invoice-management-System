<?php
// session_start();
// include'dbconnection.php';
// include("checklogin.php");
// include 'inc/getState.php';

//  check_login();

// $current_page="manage-paidhistory";
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>



 <?= $this->include('include/links.php');?>

 <link rel="stylesheet" href="<?= base_url(); ?>/public/script/daterangepicker/daterangepicker-bs3.css">

 <script type="text/javascript" src="<?= base_url(); ?>/public/script/dataTables.export.js"></script> 

    <script src="<?= base_url(); ?>/public/script/daterangepicker/moment.min.js"></script>
    <script src="<?= base_url(); ?>/public/script/daterangepicker/daterangepicker.js"></script>

<!-- <script type="text/javascript" src="/script/script.js"></script> -->
<style type="text/css">
  .cancelBtn {
      background-color:#dc3545;
  }

  select {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    width: 100%;
    border: 1px solid #ccc;
    height: 34px;
  }


 
 .floating-btn {
    position: fixed;
    bottom: 20px;   /* Distance from the bottom of the screen */
    right: 50px;    /* Distance from the right of the screen */
    width: 60px;
    height: 60px;
    background-color: #28a745;  /* Green background */
    color: white;
    font-size: 30px;
    border: none;
    border-radius: 50%;   /* Circular shape */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: background-color 0.3s;
    z-index: 1000; 
}

/* Hover effect */
.floating-btn:hover {
    background-color: #218838;  /* Darker green on hover */
}

/* Responsive styling for mobile and smaller screens */
@media (max-width: 768px) {
    .floating-btn {
        width: 50px;       /* Smaller button for tablets */
        height: 50px;
        font-size: 25px;    /* Smaller icon for tablets */
        bottom: 15px;       /* Adjust position */
        right: 15px;
    }
}

@media (max-width: 480px) {
    .floating-btn {
        width: 40px;       /* Even smaller button for mobile */
        height: 40px;
        font-size: 20px;    /* Smaller icon for mobile */
        bottom: 10px;       /* Adjust position further */
        right: 10px;
    }
}
 

 @media print {
    a[href]:after {
        content: none !important;
    }
}

</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">


<!-- <div id="loader"></div>
 -->

<div class="wrapper">

  <?= $this->include('include/header.php');?>


  <?= $this->include('include/sidebar.php');?>



  <!-- Content Wrapper. Contains page content -->
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Manage Accounts
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Manage Accounts</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">         
          <div class="box box-info" style="overflow: auto;">
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
                
               <div class="col-md-3">
                  <div class="form-group">
                      <label>Select Type:</label>                    
                      <select name="ctype" id="ctype" class="form-control select234" style="height: 35px !important;width:100% !important;" >
                          <option value=""></option>
                          <option value="1"> Suppliers </option>
                          <option value="2"> Customers</option>
                          <option value="2"> Dual (Cust / Sup)</option>                             
                        </select>       
                  </div>
               </div> 
                
             <div class="col-md-3">
               <div class="form-group">
                  <label>Date range:</label>                    
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                         <input type="text" class="form-control pull-left" id="daterange-btn" name="date_range">
                    </div><!-- /.input group -->                  
               </div><!-- /.form group -->
             </div>
                <!-- Submit Button -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label></label></br>
                        <input type="submit" class="btn btn-success" name="submit">
                    </div>
                </div>
                </form>
            </div>
 
         </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>

            <!-- <div class="row">
              <div class="col-md-12">
                <div class="box box-success">
                  <div class="box-header" style="text-align:center">
                  </br>
                      <h3 class="box-title" id="item"></h3>
                      </br>
                      
                
                          </br>
                        <div>
                          <h2 class="box-title">Accounts of </h2>
                          <h2 class="box-title pull-right" style="margin-top: 10px; margin-right: 20px;"><b></b> </h2>
                          </br>
                          <h2 class="box-title" style="padding-top: 10px;"><b>Location : </b></h2></br>
                                    

                      </div>
                    </div> 
               </div> -->
            
            <div class="row">
              <div class="col-md-6">
                <div class="box box-info">
                  <div class="box-header">
                      <h3 class="box-title">Credited</h3>
                    </div>
                     <section class="content">
                  <div class="row">
                 <div class="col-xs-12">
                      <div class="box">
                        <div class="box-body" id="colvis">                                                 
                               <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                            <th>Credit From</th>
                                            <th>Amount</th>
                                            <th>Details</th>
                                     </tr>
                                    </thead>
                                    <tbody>
                    <?php 
                                            // $credit_sub = 0;
                                            // $debit_sub = 0;
                                            // foreach($credits as $credit):
                                            //     $credit_sub += $credit->amount;
                                        ?>
                                        <tr>
                                            <td><?php //echo $credit->account_title.'('.$credit->account_type.')';?></td>
                                            <td><?php //echo $credit->amount?></td>
                                            <td><?php //echo $credit->detail?></td>
                                        </tr>
                                        <?php //endforeach?>
                                     </tbody>
                                     <tfoot>
                                        <tr>
                                            <td class="text-right"><b>Sub Total:</b></td>
                                            <td><strong><?php //echo $credit_sub;?></strong></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                              </table>
                              </div>
                            </div>
                        </div>
                    </div>
                 </section>
               </div>
           </div>
              <div class="col-md-6">
                <div class="box box-info">
                  <div class="box-header">
                      <h3 class="box-title">Debited</h3>
                    </div>
                     <section class="content">
                  <div class="row">
                 <div class="col-xs-12">
                      <div class="box">
                        <div class="box-body" id="colvis1">                                                 
                               <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                        <tr>
                                            <th>Debit From</th>
                                            <th>Amount</th>
                                            <th>Details</th>
                                        </tr>
                                     </thead>
                                     <tbody>
                                        <?php 
                                            // foreach($debits as $debit):
                                            //     $debit_sub += $debit->amount;
                                        ?>
                                        <tr>
                                            <td><?php// echo $debit->account_title.'('.$credit->account_type.')';?></td>
                                            <td><?php //echo $debit->amount?></td>
                                            <td><?php //echo $debit->detail?></td>
                                        </tr>
                                        <?php //endforeach?>
                                      </tbody>
                                      <tfoot>
                                         <tr>
                                            <td class="text-right"><b>Sub Total:</b></td>
                                            <td><strong><?php //echo $debit_sub;?></strong></td>
                                            <td></td>
                                        </tr>
                                     </tfoot>                                        
                              </table>
                              </div>
                            </div>
                        </div>
                    </div>
                  </section>
                </div>
           </div>
     </div>




          
           
            <!-- /.box-body -->
         
      <hr>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <?= $this->include('include/settings.php');?>
    <?= $this->include('include/footer.php');?>
   <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<script>
   $(document).ready(function() {
            $('#examplez').DataTable();
});

    
</script>

<script>
 
      

    $('#daterange-btn').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),

    });

    $('#form').on('submit', function(event) {
        event.preventDefault();

        var startDate = $('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD');
        
        var endDate = $('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD');
        //$('#date').text(startDate+ " to " +endDate );

        var supplier=$('#supplier').val();
        //$('#item').text("Supply Of : "+item_name);
        var customer=$('#customer').val();
        var ctype=$('#ctype').val();
       // console.log(ctype);
        //console.log(customer);
        //console.log(supplier);

        if(ctype == 1)
        {
          $('#item').text("Supplier");
        }
        else
        {
          $('#item').text("Customer");
        }

        //$('#company').text(customer);

        // $.ajax({
        //     url: 'ajax/transection-data.php',
        //     method: 'GET',
        //     data: { startDate: startDate, endDate: endDate,customer: customer, supplier: supplier, ctype:ctype},
        //     dataType: 'json',
        //     contentType: false,
        //     success: function(response) {
        //         console.log(response);
        //         //console.log(response.taxamt);
        //         //console.log(response.totalamount);

        //         table.clear();

        //         $('#date').text("Date Range: "+startDate +" To "+endDate);
        //         if (response && response.aaData && Array.isArray(response.aaData)) {
        //             response.aaData.forEach(function(row) {
        //                 table.row.add(row);
        //             });
        //         } else {
        //             console.error("Invalid response format:", response);
        //         }
        //         table.draw();

        //         // $('#subtotal').text(response.subtotal + ".00");
        //         // $('#taxamt').text(response.taxamt + ".00");
        //         $('#totalamt').text(response.totalamount + ".00");
        //     },
        //     error: function(xhr, status, error) {
        //         console.error(error);
        //     }
        // });
    });

    $('.select2').select2({ placeholder: "Select a Client", allowClear: true });
    $('.select23').select2({ placeholder: "Select Item", allowClear: true });
    $('.select234').select2({ placeholder: "Select Type", allowClear: true });

</script>

 
<script>
   $(document).ready(function(){
    

    $('#client').select2({
        placeholder: "Select a Person or Company",
        allowClear: true,
        ajax: {
            url: "<?= base_url();?>/transaction/getclient",
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

    //readProducts(); /* it will load products when document loads */
    
    $(document).on('click', '#delete_product', function(e){
      
      var productId = $(this).data('id');
      
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
    // Perform the deletion operation using AJAX
    $.ajax({
      url: 'ajax/delete payhis.php',
      type: 'POST',
      data: { delete: parseInt(productId) },
      dataType: 'json'
    })
    .done(function(response){
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
      console.log(parseInt(productId));
    });
    
  });
  

  function readProducts(){
    setTimeout(function(){
            window.location.href = 'paid-his.php';
         }, 3000);
    //$('#load-products').load('manage-clients.php'); 
  }
  
</script>
<script type="text/javascript">var base_url = "<?= base_url(); ?>";</script>
 <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/account.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/getExportButtons.js"></script>
</body>
</html>
