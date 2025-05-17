

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <?= $this->include('include/links.php');?>
   

 <!-- Morris chart -->
  <link rel="stylesheet" href="<?= base_url();?>/public/bower_components/morris.js/morris.css">
 

<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url();?>/public/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Morris.js charts -->
<script src="<?= base_url();?>/public/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url();?>/public/bower_components/morris.js/morris.min.js"></script>


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
      Product Details
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Product Details</li>
      </ol>
    </section>
    </br> 
<?php     
// $cnt=0;
//  while($row=mysqli_fetch_array($cinfo))

// {

// $cnt++;


// $p_name=$row['name'];

// $techs=$row['techs'];
// $img=$row['img_loc'];
// $hsn=$row['hsn'];
// $subcat=$row['subcat'];

?>
<?php if ($productDetails): ?>
     <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username"><?= $productDetails['name'];  ?></h3>
              <h5 class="widget-user-desc">Since <?php
                    $c=date("d-M-Y",strtotime($productDetails['created']));
                      echo $c;
               //echo $row['created']; ?> </h5>
            </div>
            <div class="widget-user-image" >
          <img class="img-thumbnail" style="width: 250px !important;" src="<?= base_url(); ?>/public/dist/img/<?= $productDetails['img_loc']; ?>" 
          alt="User Avatar" height="300" width="400px">


            </div>
            </br></br></br></br></br>
            <div class="box-footer" style="padding-top: 52px;">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php
                    $test=$productDetails['total'];
                    //echo $test;
                    if($test == null || $test == 0)
                    {
                      echo "0";
                      //echo "<script>console_log('Enter if');</script>";
                      //echo "<p>0 </p>";
                    }
                    else
                    {
                     echo $test; 
                    } ?>
                      
                    </h5>
                    <span class="description-text">SALES</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php

                    $test=$productDetails['item_sold'];
                    //echo $test;

                      if($test == null || $test == 0)
                    {
                      //echo $test;
                       echo "<p>0 </p>";
                    }
                    else{
                     echo $test; 
                    } ?> </h5>
                    <span class="description-text">Products</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header"><?php echo $productDetails['invid_count']; ?> </h5>
                    <span class="description-text">Invoice</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->

              </div>
              <!-- /.row -->
              </br>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
     


                              <div class="col-md-4" id="examplez">
                                    <div class="box box-info" style="height: 360px;">
                                            
                                            <div class="box-header with-border center">
                                               <h3 class="box-title"><b> Technical Information </b> </h3> </div>

                                      <div class="box-body">
                                          <div class="form-group" style="padding-left: 6px">
                                          </br>
                                      <strong><p align="center" style="color:black;"></p></strong>
                                      <p align="left">
                                      <?php
                                          // Initialize the array to hold the tech details
                                          $dy = [];

                                          // Check if 'techs' exists in $productDetails and is not empty
                                          if (!empty($productDetails['techs'])) {
                                              $techs = $productDetails['techs'];
                                              array_push($dy, $techs);

                                              // Display the title
                                              echo "<h4 class='box-title'><b><u>" . $productDetails['name'] . "</b></u></h4><br>";

                                              // Process the 'techs' data
                                              $sanitizedTechs = str_replace("\r", ' ', $techs); // Replace carriage returns

                                              // Split the string into an array by semicolons
                                              $data = explode(';', $sanitizedTechs);

                                              // Remove extra spaces around each item
                                              $data = array_map('trim', $data);

                                              // Display the list
                                              echo "<ul>";
                                              foreach ($data as $item) {
                                                  echo "<li>" . esc(stripslashes($item)) . "</li>";
                                              }
                                              echo "</ul>";
                                          } else {
                                              // Handle the case where no tech details are available
                                              echo "<h4 class='box-title'><b><u>No technical details available</b></u></h4>";
                                          }
                                      ?>

                                         </a>
                                    
                                       <!--  <a href="edittest.php?invid=<?php //echo $row['invid'];?>"> 
                                     <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                            
                                    <a class="btn btn-danger btn-xs pull-right" id="delete_product" data-id="<?php //echo $id; ?>" ><i class="fa fa-trash-o "></i></a> -->
                                  </div> 
                                </div>

                              </div>
                              </div> 



                                <div class="col-md-4" id="examplez">
                                    <div class="box box-info" style="height: 360px;">
                                            
                                        <div class="box-header with-border center">
                                              <h3 class="box-title"><b>Yearly Sold Item Count  </b> </h3> </div>

                                      <div class="box-body" style="margin-top: -20px">
                                          <div class="form-group" style="padding-left: 6px">
                                      
                                      

                                      <div class="box-body chart-responsive">
                          <div class="chart_morris" id="chart_pie_1" style="height: 250px; margin-top: 5px !important;"></div>
                                      <div id='chart_pie_1_legend' class='text-center'></div>
                                      </br></br>
                        </div>
                                    
                                       <!--  <a href="edittest.php?invid=<?php //echo $row['invid'];?>"> 
                                     <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                            
                                    <a class="btn btn-danger btn-xs pull-right" id="delete_product" data-id="<?php //echo $id; ?>" ><i class="fa fa-trash-o "></i></a> -->
                                  </div> 
                                </div>

                              </div>
                              </div> 

 <?php else: ?>
                                      <p>No client details found.</p>
                                       <?php endif; ?>

             

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title" style="padding-top: 10px;">Sales Tax Invoice Details</h3>
            </div>
            <!-- /.box-header -->
            <!--  <button type="button" id="btnplus"class="btn btn-success btn-sm pull-right" style="margin: 2px 20px 2px 2px;" onclick="window.location.href = 'add-client.php'";><span class="glyphicon glyphicon-plus"></span></button><br> -->

            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                            
                            <hr>
                              <thead>
                              <tr>
                                  <th>Sno.</th>
                                  <th class="hidden-phone">Invoice Id</th>
                                  <th> Company Name</th>
                                  <th> Location</th>
                                  <th> Item Name </th>
                                  <th> Amount</th>
                                  <th> Created </th>
                                   <!-- <th>Reg. Date</th> -->
                                      <th>Edit</th>
                                      <th>View</th>
                                      <th>Delete</th>
                              </tr>
                              </thead>
                              <tbody>
                             
                              
                              </tbody>
                <tfoot>
                <tr>
                  <th>Sr. no.</th>
                  <th>Invoice Id</th>
                  <th>Company Name</th>
                  <th>Location</th>
                  <th> Item Name </th>
                  <th>Amount </th> 
                  <th>Created</th>
                  <th>Edit</th>
                  <th>View</th>
                  <th>Delete</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->



    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title" style="padding-top: 10px;">Proforma Invoice Details</h3>
            </div>
            <!-- /.box-header -->
            <!--  <button type="button" id="btnplus"class="btn btn-success btn-sm pull-right" style="margin: 2px 20px 2px 2px;" onclick="window.location.href = 'add-client.php'";><span class="glyphicon glyphicon-plus"></span></button><br> -->

            <div class="box-body">
              <table id="example3" class="table table-bordered table-striped">
                            
                            <hr>
                              <thead>
                              <tr>
                                  <th>Sno.</th>
                                  <th class="hidden-phone">Invoice Id</th>
                                  <th> Company Name</th>
                                  <th> Location</th>
                                  <th> Item Name </th>
                                  <th> Amount</th>
                                  <th> Created </th>
                                   <!-- <th>Reg. Date</th> -->
                                      <th>Edit</th>
                                      <th>View</th>
                                      <th>Delete</th>
                              </tr>
                              </thead>
                              <tbody>
                             
                              
                              </tbody>
                <tfoot>
                <tr>
                  <th>Sr. no.</th>
                  <th>Invoice Id</th>
                  <th>Company Name</th>
                  <th>Location</th>
                  <th> Item Name </th>
                  <th>Amount </th> 
                  <th>Created</th>
                  <th>Edit</th>
                  <th>View</th>
                  <th>Delete</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->









  </div>
  <!-- /.content-wrapper -->
 <?= $this->include('include/footer.php');?>
   <?= $this->include('include/settings.php');?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/getExportButtons.js"></script>
<script >
  var base_url = "<?= base_url(); ?>";
</script>
<!-- page script -->
<script>
  $(function () {
    const taxInvoices = <?= $taxInvoices; ?>;

    console.log(taxInvoices);

    $('#example2').DataTable({
           'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'data': taxInvoices.aaData,
  // 'dom':"<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
   //   "<'row'<'col-sm-12'tr>>" +
   //   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
 dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
    
       buttons:  getExportButtons('#example2', [0, 1, 2, 3, 4, 5]),
        columns: [
           {
                            //custom functions for particular column
                            "data": "id",
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                                }
                              },
                              { 'data': "invid" },
                    { 'data': "c_name" },
                    { 'data': "location" },
                    { 'data': "Item" },
                    { 'data': "totalamount" },
                    { 'data': "created" },
                    {
                      'data': 'editaction',
                         render: function (data, type, row, meta) {
                             // return '<a class="btn btn-primary btn-xs" id="edit_product" data-id="' + row.orderid + '"><i class="fa fa-pencil" style="width:15px;height:10px"></i></a>';
                             return `<a href="<?= base_url();?>/taxinv/edittaxinv?orderid=${row.orderid}" class="btn btn-primary btn-xs" id="viewledger" data-id="${row.orderid}" target="_blank">
                    <i class="fa fa-pencil" style="width:15px;height:10px"></i>
                </a>`;

                         }
                      },

                    {
                      'data': 'viewaction',
                         render: function (data, type, row, meta) {
                                return `<a href="<?= base_url();?>/taxinv/printtaxinv?orderid=${row.orderid}" class="btn btn-warning btn-xs" id="viewledger" data-id="${row.orderid}" target="_blank">
                    <i class="fa fa-fw fa-eye" style="width:15px;height:10px"></i>
                </a>`;

                         }
                      },
                       
                    {
                      'data': 'deleteaction',
                         render: function (data, type, row, meta) {
                                return '<a class="btn btn-danger btn-xs" id="delete_product" data-id="' + row.orderid + '" ><i class="fa fa-trash-o"  style="width:15px;height:10px"></i></a>';
                         }
                      },
     ],
   
      initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-primary btn-sm btn-group');
            btns.removeClass('dt-button');

        },        "lengthMenu": [[10, 50, 150, -1], [10, 50, 150, "All"]]
      });
 document.querySelectorAll('.toggle-vis').forEach((el) => {
    el.addEventListener('click', function (e) {
        e.preventDefault();
 
        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);
        
        // Toggle the visibility
        column.visible(!column.visible());
    });
});


    })
  
</script>

<script>

const proInvoices = <?= $proInvoices; ?>;
  $(function () {
    
    $('#example3').DataTable({
           'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
     'data': proInvoices.aaData,
  
  // 'dom':"<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
   //   "<'row'<'col-sm-12'tr>>" +
   //   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
 dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
    
       buttons:  getExportButtons('#example3', [0, 1, 2, 3, 4, 5]),
         columns: [
           {
                            //custom functions for particular column
                   "data": "id",
                    render: function (data, type, row, meta) {
                     return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                    { 'data': "invid" },
                    { 'data': "c_name" },
                    { 'data': "location" },
                    { 'data': "Item" },
                    { 'data': "totalamount" },
                    { 'data': "created" },
                    {
                      'data': 'editaction',
                         render: function (data, type, row, meta) {
                             // return '<a class="btn btn-primary btn-xs" id="edit_product" data-id="' + row.aid + '"><i class="fa fa-pencil" style="width:15px;height:10px"></i></a>';
                             return `<a href="<?= base_url();?>/proinv/editproinv?orderid=${row.orderid}" class="btn btn-primary btn-xs" id="edit_inv" data-id="${row.orderid}" target="_blank">
                    <i class="fa fa-pencil" style="width:15px;height:10px"></i>
                </a>`;

                         }
                      },

                    {
                      'data': 'viewaction',
                         render: function (data, type, row, meta) {
                               
                //                 return `<a href="getledger/${row.cid}" class="btn btn-warning btn-xs" id="viewledger" data-id="${row.cid}">
                //     <i class="fa fa-fw fa-eye" style="width:15px;height:10px"></i>
                // </a>`;
                return `<a href="<?= base_url();?>/proinv/printproinv?orderid=${row.orderid}" class="btn btn-warning btn-xs" id="view_inv" data-id="${row.orderid}" target="_blank">
                    <i class="fa fa-fw fa-eye" style="width:15px;height:10px"></i>
                </a>`;
                         }
                      },
                       
                    {
                      'data': 'deleteaction',
                         render: function (data, type, row, meta) {
                                return '<a class="btn btn-danger btn-xs" id="delete_product2" data-id="' + row.orderid + '" ><i class="fa fa-trash-o"  style="width:15px;height:10px"></i></a>';
                         }
                      },
     ],
      initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-primary btn-sm btn-group');
            btns.removeClass('dt-button');

        },        "lengthMenu": [[10, 50, 150, -1], [10, 50, 150, "All"]]
      });
 document.querySelectorAll('.toggle-vis').forEach((el) => {
    el.addEventListener('click', function (e) {
        e.preventDefault();
 
        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);
        
        // Toggle the visibility
        column.visible(!column.visible());
    });
});




    })

</script>
<script>
$(document).ready(function() {
    // Get infoid from URL parameters or from the URL path
    const urlParams = new URLSearchParams(window.location.search);
    const infoid = urlParams.get('infoid') || window.location.pathname.split('/').pop();
    console.log('infoid:', infoid);  // Verify if the infoid is correctly captured

    // AJAX request to fetch product info
    $.ajax({
        url: base_url + '/product/viewproductinfo/' + infoid, // Adjust the URL to match your route
        type: 'GET',
        data: { infoid: parseInt(infoid) }, // Pass info ID as a GET parameter
        dataType: 'html', // Expecting an HTML response
        success: function(response) {
            console.log(response);
            // Inject the response into a container, such as a div
            $('#productInfoContainer').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching product info:', error);
            alert('Failed to fetch product information. Please try again.');
        }
    });


     $(document).on('click', '#delete_product', function(e){
      
      var productId = $(this).data('id');
      SwalDelete(productId);
      e.preventDefault();
      console.log(productId);
    });
    
  });
  
  function SwalDelete(productId) {
  Swal.fire({
    title: 'Are you sure?',
    text: "It will be deleted permanently!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
    showLoaderOnConfirm: true,
    allowOutsideClick: false,

    preConfirm: () => {
      return $.ajax({
        url: base_url + '/taxinv/delete/' + productId,
        type: 'POST',
        dataType: 'json',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }).then(response => {
        if (response.res === 'success') {
          return response.message;
        } else {
          throw new Error(response.message || 'Deletion failed');
        }
      }).catch(error => {
        Swal.showValidationMessage(`Request failed: ${error}`);
      });
    }
  }).then((result) => {
    if (result.isConfirmed) {
       Swal.fire('Deleted!', result.value, 'success').then(() => {
    location.reload();
});
      //readProducts(); // Refresh or reload
    }
  });
}




$(document).on('click', '#delete_product2', function(e){
      
      var productId2 = $(this).data('id');
      SwalDelete2(productId2);
      e.preventDefault();
      console.log(productId2);
    });
    

  
  function SwalDelete2(productId2) {
  Swal.fire({
    title: 'Are you sure?',
    text: "It will be deleted permanently!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
    showLoaderOnConfirm: true,
    allowOutsideClick: false,

    preConfirm: () => {
      return $.ajax({
        url: base_url + '/proinv/delete/' + productId2,
        type: 'POST',
        dataType: 'json',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }).then(response => {
        if (response.res === 'success') {
          return response.message;
        } else {
          throw new Error(response.message || 'Deletion failed');
        }
      }).catch(error => {
        Swal.showValidationMessage(`Request failed: ${error}`);
      });
    }
  }).then((result) => {
    if (result.isConfirmed) {
       Swal.fire('Deleted!', result.value, 'success').then(() => {
    location.reload();
});
      //readProducts(); // Refresh or reload
    }
  });
}

    // Get the product name from PHP and log it for verification
    var p_name = '<?= $productDetails['name']; ?>';  // Getting the product name from PHP
    console.log(p_name);  // Logging the product name for verification

    // Assuming 'donut' is fetched from PHP and passed as a JavaScript variable
    var donut = <?php echo json_encode($donut); ?>;  // Pass the donut data from PHP to JS

    // Map donut data for Morris.js
    const chartData = donut.map(function(item) {
        return {
            label: item.FinancialYear,  // Financial Year
            value: item.TotalQuantity   // Total Quantity sold for that year
        };
    });

    // Render Morris.js donut chart
    const donutChart = new Morris.Donut({
        element: 'chart_pie_1',  // The ID of the div where the chart will be rendered
        data: chartData,         // Data to display
        resize: true,            // Make the chart responsive
        colors: ['#007bff', '#6c757d', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#343a40', '#e83e8c', '#6610f2', '#fd7e14'],
        // formatter: function(x, data) {
        //     const total = chartData.reduce((sum, item) => sum + item.value, 0);  // Total quantity sold
        //     const percentage = ((x / total) * 100).toFixed(2); // Calculate percentage
        //     return `${x} (${percentage}%)`;  // Show value and percentage
        // }
    });

    // Generate the legend
    const legendContainer = document.getElementById("chart_pie_1_legend");
    chartData.forEach(function(item, index) {
        const color = donutChart.options.colors[index];
        const legendItem = `
            <span style="display: inline-block; margin-right: 15px;">
                <i class="fas fa-square" style="color: ${color};"></i> ${item.label}
            </span>
        `;
        legendContainer.innerHTML += legendItem;
    });
//});
</script>

</body>
</html>
