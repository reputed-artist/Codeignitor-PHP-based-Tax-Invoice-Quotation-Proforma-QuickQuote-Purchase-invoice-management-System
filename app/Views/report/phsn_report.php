

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
      Purchase HSN Report
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">     Purchase HSN Report</li>
      </ol>
    </section>



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

                </form>
            </div>


      
            <div class="row">
              <div class="col-md-12">
                <div class="box box-success">
                  <div class="box-header" style="text-align:center">
                  </br>
                      <h3 class="box-title" id="item"></h3>
                     
                      </br></br>
                      
                      <h4 id="date"> </h4>
                      </br>
                        <div id="hide">
                        <h3 class="box-title" id="company"></h3></br>
                        

                      </div>
                    </div>
                    <h3>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ' '." CodeTech Engineers";?></h3>
               <section class="content">
                  <div class="row">
                 <div class="col-xs-12">
                      <div class="box">
                        <div class="box-body">                                                 
                               <table id="example" class="table table-bordered table-striped">

                                     <thead>
                                        <tr>
                                            <th > ID </th>
                                            
                                              <th>Client Type</th>
                                              <th>HSN</th>
                                              <th>Product Name</th>
                                              <th>Total Qty</th>
                                              <th>Subtotal</th>
                                              <th>Total GST</th>
                                              <th>Total Amount</th>
                                        </tr>
                                    </thead>

                                     <tbody>                                                                     
                  
                                     
                                         </tbody>
                                         <tfoot>
                                      <tr>
                                                <th>ID</th>
                                                <th>Client Type</th>
                                                <th>HSN</th>
                                                <th>Product Name</th>
                                                <th>Total Qty</th>
                                                <th>Subtotal</th>
                                                <th>Total GST</th>
                                                <th>Total Amount</th>
                                            
                                    </tr>
                                        </tfoot>
                                 </table> 
                                   
                             </div>
                         </div>
                          <div  class="btn-group" data-toggle="buttons" role="group">
                          <input type="button" class="toggle-vis btn btn-primary" data-column="0" value="ID">
                                     <input type="button" class="toggle-vis btn btn-primary" data-column="1" value="Client Type">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="2" value="HSN">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="3" value="Product Name">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="4" value="Total Qty">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="5" value="Subtotal">
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="6" value="Total GST">
                                    
                                    <input type="button" class="toggle-vis btn btn-primary" data-column="7" value="Total Amount">
                          
                                    </br> 
                                  </div>  
                         </div>
                       </div>
                    </section>
                </div>
           </div>
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
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
   
    var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>

<script>
 var globalSubtotalTotal=0;
    function loadItems(date = null) {

        console.log("Loading hsn for page: " + date); // Add this line
        $.ajax({
            url: base_url + '/purchaseinv/loadhsn',
            type: 'GET',
            data: { 
                    date: date,
                  }, // Send the current page number to the server
            dataType: 'json',
            success: function(response) {

                console.log("res"+response);
                $('#example').DataTable().destroy();
        
        var table = $('#example').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'processing': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'footer': true,
        'data': response.aaData,
        dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
       buttons: getExportButtons('#example',[0,1,2,3,4,5,6]), 
        columns: [
            { 'data': 'id',
                  render: function (data, type, row, meta) {
        return meta.row + 1; // 👈 row index + 1 = serial number
            } 
          }, 
            {'data':'c_type'},
            { 'data': 'hsn' },
            
            {'data':'product_names'},
            { 'data': 'total_quantity',
                render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },

            { 'data': 'subtotal',
               render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },

            
            { 'data': 'total_gst',
               render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },
            { 'data': 'total_amount',
            render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },

        ],
        initComplete: function() {
            var btns = $('.dt-button');
            btns.addClass('btn btn-primary btn-sm btn-group');
            btns.removeClass('dt-button');
        },
        lengthMenu: [
            [10, 50, 150, -1],
            [10, 50, 150, "All"]
        ]
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
         

                }
              })
             }

 $(document).ready(function() {

  //loadItems(1);

  let selectedYear = null;
let selectedItem = null;


     $('#daterange-btn').on('apply.daterangepicker', function(ev, picker) {
    selectedYear = picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD');
    loadItems(selectedYear);
});


  // $('#product').on('select2:select', function() {
  //       selectedItem= $(this).val();
  //       loadItems(selectedYear, selectedItem);
  //   });

    var table = $('#example').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'processing': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'footer': true,
        dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
        buttons: getExportButtons('#example',[0,1,2,3,4,5,6]), 
             columns: [
              { 'data': 'id',
                    render: function (data, type, row, meta) {
        return meta.row + 1; // 👈 row index + 1 = serial number
      } 
    }, 
            {'data':'c_type'},
            { 'data': 'hsn' },
            {'data':'product_names'},
            { 'data': 'total_quantity',
                render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },

            { 'data': 'subtotal',
               render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },

            
            { 'data': 'total_gst',
               render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },
            { 'data': 'total_amount',
            render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },

        ],
        initComplete: function() {
            var btns = $('.dt-button');
            btns.addClass('btn btn-primary btn-sm btn-group');
            btns.removeClass('dt-button');
        },
        lengthMenu: [
            [10, 50, 150, -1],
            [10, 50, 150, "All"]
        ],

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

 
 $('#daterange-btn').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last Financial Year': getLastFinancialYearRange(),
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),

    });

    function getLastFinancialYearRange() {
    var today = moment();
    var lastFyStart, lastFyEnd;

    // Assuming financial year is from April 1st to March 31st
    if (today.month() < 3) { // January to March
        // Last financial year was the previous calendar year
        lastFyStart = moment().subtract(1, 'years').month(3).startOf('month'); // April 1st of previous year
        lastFyEnd = moment().subtract(1, 'years').month(2).endOf('month'); // March 31st of current year
    } else {
        // Last financial year was within this calendar year
        lastFyStart = moment().subtract(1, 'years').month(3).startOf('month'); // April 1st of previous year
        lastFyEnd = moment().month(2).endOf('month'); // March 31st of this year
    }

    return [lastFyStart, lastFyEnd];
}



    // $('.select2').select2({ placeholder: "Select a Client", allowClear: true });
    $('.select23').select2({ placeholder: "Select a Item", allowClear: true });
});


</script>
<script type="text/javascript">
  $('.btn-primary').on("click",function(){

        //$(".btn-primary").not(this).removeClass('active');
        if($(this).hasClass('active')){
            //$('.Resume-click-open').css({'height' : '100px'});
            $(this).removeClass('active');
            $(this).removeClass('btn-danger');
            //$(this).addClass("btn-primary");
        }else{
            $(this).addClass('active');
            $(this).addClass("btn-danger");
        }


    //$(".btn-success").removeClass('btn-danger');
    
});

</script>
  <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/getExportButtons.js"></script>
</body>
</html>
