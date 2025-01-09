<?php
// session_start();
// include'dbconnection.php';
// include("checklogin.php");
//  check_login();

// $current_page="manage-clients";

// include 'inc/getState.php';

// If(isset($_GET['infoid']))
// {
//   $val=$_GET['infoid'];

//   $cinfo=mysqli_query($con,"select sum(invtest2.totalitems) 'totalitems',count(invtest2.invid) 'invid', sum(invtest2.totalamount) 
//     'sales', client.c_name, client.c_add, client.mob, client.gst, client.c_type, client.country, Client.created  from invtest2 INNER JOIN client 
//     USING (cid)  where cid=$val")  or die("Error: " . mysqli_error($con));

  //print_r($data);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
 
<?= $this->include('include/links.php');?>

 <link rel="stylesheet" href="<?= base_url(); ?>/public/bower_components/morris.js/morris.css">
 

<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url(); ?>/public/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Morris.js charts -->
<script src="<?= base_url(); ?>/public/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url(); ?>/public/bower_components/morris.js/morris.min.js"></script>


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
      Client Details
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Client Details</li>
      </ol>
    </section>
    </br> 


<?php if ($clientDetails): ?>

     <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user" style="height: 300px">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username"><?= $clientDetails['c_name'];  ?></h3>
              <h5 class="widget-user-desc">Since <?=
                    $c=date("d-M-Y",strtotime($clientDetails['created']));
                      
               //echo $row['created']; ?> </h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="<?= base_url();?>/public/dist/img/avatar5.png" alt="User Avatar">
            </div>
            <div class="box-footer">
            </br></br>
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?php
                    $test=$clientDetails['sales'];
                    //echo $test;
                    if($test == null || $test == 0)
                    {
                      echo $test;
                      echo "<script>console_log('Enter if');</script>";
                      echo "<p>0 </p>";
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

                    $test=$clientDetails['totalitems'];
                    //echo $test;

                      if($test == null || $test == 0)
                    {
                      echo $test;
                                      //echo "<p>0 </p>";
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
                    <h5 class="description-header"><?php echo $clientDetails['invid']; ?> </h5>
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
     


                              <div class="col-md-4" id="examplez" >
                                    <div class="box box-info" style="height: 300px">
                                            
                                            <div class="box-header with-border center">
                                               <h3 class="box-title"> Client Information </h3> </div>

                                      <div class="box-body">
                                          <div class="form-group" style="padding-left: 6px">
                                      <strong><p align="center" style="color:black;"></p></strong>
                                      
                                      <p align="left"><strong>Name: </strong> <?= $clientDetails['c_name']; ?>  </p>
                                      <p align="left"><strong>Address: </strong><?= $clientDetails['c_add']; ?></p>
                                      <p align="left"><strong> Mob: </strong><?= $clientDetails['mob']; ?> </p>
                                      <p align="left"><strong> GST No.: </strong><?= $clientDetails['gst']; ?></p>
                                      <p align="left"><strong> Bill Type.: </strong><?= $clientDetails['c_type']; ?></p>
                                      <p align="left"><strong> User Type.: </strong><?php //$clientDetails['u_type'];
                                      if ($clientDetails['u_type'] == 0) {
                                          echo "Client";
                                        } elseif ($clientDetails['u_type'] == 1) {
                                          echo "Supplier";
                                        } elseif ($clientDetails['u_type'] == 2) {
                                          echo "Dual (Client/Supplier)";
                                        } else {
                                          echo "Unknown Type"; // In case there is an unexpected value for u_type
                                        }
                                      ?>
                                    </p>  
                                      <p align="left"><strong> Nationality: </strong><?= $clientDetails['country']; ?></p>
                                      <?php else: ?>
                                      <p>No client details found.</p>
                                       <?php endif; ?>
                                    
                                       <!--  <a href="edittest.php?invid=<?php //echo $row['invid'];?>"> 
                                     <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                            
                                    <a class="btn btn-danger btn-xs pull-right" id="delete_product" data-id="<?php //echo $id; ?>" ><i class="fa fa-trash-o "></i></a> -->
                                  </div> 
                                </div>

                              </div>
                              </div> 



                                <div class="col-md-4" id="examplez">
                                    <div class="box box-info" style="height: 300px">
                                            
                                        <div class="box-header with-border center">
                                              <h3 class="box-title"><b>Turnover as per FY </b> </h3> </div>

                                      <div class="box-body" style="margin-top: -20px;">
                                          <div class="form-group" style="padding-left: 6px">

                                      <div class="box-body chart-responsive">
                                      <div class="chart_morris" id="chart_pie_1" style="height: 210px;"></div>
                                      <div id='chart_pie_1_legend' class='text-center'></div>
                                      </br></br>
                                   </div>
                                    
                                     
                                  </div> 
                                </div>

                              </div>
                              </div> 


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
                  <th>Amount </th> <th>Created</th>
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



  </div>
  <!-- /.content-wrapper -->
   <?= $this->include('include/footer.php');?>
   <?= $this->include('include/settings.php');?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script type="text/javascript">   var base_url = "<?= base_url(); ?>";</script>

<!-- page script -->
<script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/client.js"></script>
<script>

const taxInvoices = <?= $taxInvoices; ?>;
        const proInvoices = <?= $proInvoices; ?>;

        console.log(taxInvoices);

  $(function () {
    
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
    
       buttons: [
             {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o">&nbsp; Copy </i>',
                className: "btn-sm btn btn-danger",
                titleAttr: 'Copy',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5 ]
                }
      
            },
            {
                text: '{ } &nbsp; JSON',
                className: "btn-sm btn btn-danger",
                titleAttr: 'JSON',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5 ]
                },
                action: function ( e, dt, button, config ) {
                    var data = dt.buttons.exportData();
 
                    $.fn.dataTable.fileSave(
                        new Blob( [ JSON.stringify( data ) ] ),
                        'Export.json'
                    );
                }
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o">&nbsp; Excel</i>',
                className: "btn-sm btn btn-danger",
                titleAttr: 'Excel',
                                title: 'AdminLT || Clients Data',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6 ]
                }
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o">&nbsp; CSV</i>',
                className: "btn-sm btn btn-danger",
                titleAttr: 'CSV',
                                title: 'AdminLT || Clients Data',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5 ]
                }
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o">&nbsp; PDF</i>',
                className: "btn-sm btn btn-danger",  
                orientation: 'landscape',
                pageSize: 'A3',          
                titleAttr: 'PDF',
                title: 'AdminLT || Clients Data',
                customize: function(doc) {  
                doc.pageMargins = [10,10,10,10];
                doc.defaultStyle.fontSize = 7;
                doc.styles.tableHeader.fontSize = 7;

               
                doc.styles.tableFooter.fontSize=15;
                doc.styles.title.fontSize = 15;
        // Remove spaces around page title
        doc.content[0].text = doc.content[0].text.trim();
        // Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                {
                        // This is the right column
                        alignment: 'center',
                        text: ['Clients Data from CodeTech Engineers'],
                        
                    },
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }],
                        //fontSize:10
                    }
                ],
                margin: [10, 0]
            }
        });


        // doc['header'] = (function (page, pages) {
        //         return {
        //           columns: [
        //             {
        //               // 'This is your left footer column',
        //               alignment: 'left',
        //               //fontSize: 8,
        //               text: ['test'],
        //              // margin: [0, 10]
        //             },
        //             {
        //               // This is the right column
        //               alignment: 'right',
        //               text: ['ama'],
        //               //margin: [0, 10]
        //             }
        //           ],
        //           margin: [30, 0]
        //         }
        //       });

        // Styling the table: create style object
        var objLayout = {};
        // Horizontal line thickness
        objLayout['hLineWidth'] = function(i) { return .5; };
        // Vertikal line thickness
        objLayout['vLineWidth'] = function(i) { return .5; };
        // Horizontal line color
        objLayout['hLineColor'] = function(i) { return '#aaa'; };
        // Vertical line color
        objLayout['vLineColor'] = function(i) { return '#aaa'; };
        // Left padding of the cell
        objLayout['paddingLeft'] = function(i) { return 4; };
        // Right padding of the cell
        objLayout['paddingRight'] = function(i) { return 4; };
        // Inject the object in the document
        doc.content[1].layout = objLayout;
    
                doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                doc.defaultStyle.alignment = 'center';
                doc.styles.tableHeader.alignment = 'center';
                },
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5 ]
                }
            },

            {
                extend:    'print',
                text:      '<i class="fa fa-print">&nbsp; Print</i>',
                className: "btn btn-sm  btn-danger",  
                titleAttr: 'Print',
                                                title: 'AdminLT || Clients Data',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5]
                }
            },
            {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'TXT',
       text: '<i class="fa fa-fw fa-file-text-o">&nbsp; TXT</i>',
  action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
        doExport('#example2', { type: 'txt' });
    },
  exportOptions: {
          columns: [ 0, 1, 2, 3,4,5],
    }
  },
              {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'sql',
       text: '<i class="fa fa-fw fa-database">&nbsp; SQL</i>',
  action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
        doExport('#example2', { type: 'sql' });
    },
  exportOptions: {
        modifier: {
            page: 'all'
        }
    }
  },
              {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'doc',
       text: '<i class="fa fa-fw fa-file-word-o">&nbsp; Docx</i>',
  action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
        doExport('#example2', { type: 'doc',mso: {pageOrientation: 'landscape'} });
    },
  exportOptions: {
        modifier: {
            page: 'all'
        }
    }
  },
  {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'PNG',
       text:'<i class="fa fa-fw fa-image">&nbsp; PNG</i>',
  action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
        doExport('#example2', { type: 'png'});
    },
  exportOptions: {
        modifier: {
            page: 'all'
        }
    }
  }



        ],
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
                          console.log(row.orderid);
                             //return '<a class="btn btn-primary btn-xs" id="edit_product" data-id="' + row.orderid + '"><i class="fa fa-pencil" style="width:15px;height:10px"></i></a>';
                              return `<a href="<?= base_url();?>/taxinv/edittaxinv?orderid=${row.orderid}" class="btn btn-primary btn-xs" id="viewledger" data-id="${row.orderid}" target="_blank">
                    <i class="fa fa-pencil" style="width:15px;height:10px"></i>
                </a>`;

                         }
                      },

                    {
                      'data': 'viewaction',
                         render: function (data, type, row, meta) {
                               //return '<a class="btn btn-warning btn-xs" id="viewledger" data-id="' + row.aid +'"><i class="fa fa-fw fa-eye" style="width:15px;height:10px"></i></a>';
                                //return '<a href="getledger?infoid=${row.aid}" class="btn btn-warning btn-xs"><i class="fa fa-fw fa-eye"></i></button></a>';
                                return `<a href="<?= base_url();?>/taxinv/printtaxinv?orderid=${row.orderid}" class="btn btn-warning btn-xs" id="viewledger" data-id="${row.orderid}" target="_blank">
                    <i class="fa fa-fw fa-eye" style="width:15px;height:10px"></i>
                </a>`;
                         }
                      },
                       
                    {
                      'data': 'deleteaction',
                         render: function (data, type, row, meta) {
                                return '<a class="btn btn-danger btn-xs" id="delete_product" data-id="' + row.aid + '" ><i class="fa fa-trash-o"  style="width:15px;height:10px"></i></a>';
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




 $('#example3').DataTable({
           'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'data': proInvoices.aaData,
   // 'dom':"<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
   //    "<'row'<'col-sm-12'tr>>" +
   //    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
   
     dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
    
       buttons: [
             {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o">&nbsp; Copy </i>',
                className: "btn-sm btn btn-danger",
                titleAttr: 'Copy',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5 ]
                }
      
            },
            {
                text: '{ } &nbsp; JSON',
                className: "btn-sm btn btn-danger",
                titleAttr: 'JSON',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5 ]
                },
                action: function ( e, dt, button, config ) {
                    var data = dt.buttons.exportData();
 
                    $.fn.dataTable.fileSave(
                        new Blob( [ JSON.stringify( data ) ] ),
                        'Export.json'
                    );
                }
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o">&nbsp; Excel</i>',
                className: "btn-sm btn btn-danger",
                titleAttr: 'Excel',
                                title: 'AdminLT || Clients Data',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5 ]
                }
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o">&nbsp; CSV</i>',
                className: "btn-sm btn btn-danger",
                titleAttr: 'CSV',
                                title: 'AdminLT || Clients Data',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5 ]
                }
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o">&nbsp; PDF</i>',
                className: "btn-sm btn btn-danger",  
                orientation: 'landscape',
                pageSize: 'A3',          
                titleAttr: 'PDF',
                title: 'AdminLT || Clients Data',
                customize: function(doc) {  
                doc.pageMargins = [10,10,10,10];
                doc.defaultStyle.fontSize = 7;
                doc.styles.tableHeader.fontSize = 7;

               
                doc.styles.tableFooter.fontSize=15;
                doc.styles.title.fontSize = 15;
        // Remove spaces around page title
        doc.content[0].text = doc.content[0].text.trim();
        // Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                {
                        // This is the right column
                        alignment: 'center',
                        text: ['Clients Data from CodeTech Engineers'],
                        
                    },
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }],
                        //fontSize:10
                    }
                ],
                margin: [10, 0]
            }
        });


        // doc['header'] = (function (page, pages) {
        //         return {
        //           columns: [
        //             {
        //               // 'This is your left footer column',
        //               alignment: 'left',
        //               //fontSize: 8,
        //               text: ['test'],
        //              // margin: [0, 10]
        //             },
        //             {
        //               // This is the right column
        //               alignment: 'right',
        //               text: ['ama'],
        //               //margin: [0, 10]
        //             }
        //           ],
        //           margin: [30, 0]
        //         }
        //       });

        // Styling the table: create style object
        var objLayout = {};
        // Horizontal line thickness
        objLayout['hLineWidth'] = function(i) { return .5; };
        // Vertikal line thickness
        objLayout['vLineWidth'] = function(i) { return .5; };
        // Horizontal line color
        objLayout['hLineColor'] = function(i) { return '#aaa'; };
        // Vertical line color
        objLayout['vLineColor'] = function(i) { return '#aaa'; };
        // Left padding of the cell
        objLayout['paddingLeft'] = function(i) { return 4; };
        // Right padding of the cell
        objLayout['paddingRight'] = function(i) { return 4; };
        // Inject the object in the document
        doc.content[1].layout = objLayout;
    
                doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                doc.defaultStyle.alignment = 'center';
                doc.styles.tableHeader.alignment = 'center';
                },
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5 ]
                }
            },

            {
                extend:    'print',
                text:      '<i class="fa fa-print">&nbsp; Print</i>',
                className: "btn btn-sm  btn-danger",  
                titleAttr: 'Print',
                                                title: 'AdminLT || Clients Data',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5]
                }
            },
            {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'TXT',
       text: '<i class="fa fa-fw fa-file-text-o">&nbsp; TXT</i>',
  action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
        doExport('#example3', { type: 'txt' });
    },
  exportOptions: {
          columns: [ 0, 1, 2, 3,4,5],
    }
  },
              {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'sql',
       text: '<i class="fa fa-fw fa-database">&nbsp; SQL</i>',
  action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
        doExport('#example3', { type: 'sql' });
    },
  exportOptions: {
        modifier: {
            page: 'all'
        }
    }
  },
              {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'doc',
       text: '<i class="fa fa-fw fa-file-word-o">&nbsp; Docx</i>',
  action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
        doExport('#example3', { type: 'doc',mso: {pageOrientation: 'landscape'} });
    },
  exportOptions: {
        modifier: {
            page: 'all'
        }
    }
  },
  {
                              
             className: "btn btn-sm  btn-danger",  
             titleAttr: 'PNG',
       text:'<i class="fa fa-fw fa-image">&nbsp; PNG</i>',
  action: function (e, dt, node, config) {


        // Trigger the Ultimate Export plugin to export data from the textarea
        doExport('#example3', { type: 'png'});
    },
  exportOptions: {
        modifier: {
            page: 'all'
        }
    }
  }



        ],
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
  $(function () {
  
   

    })
</script>
<script>
  $(document).ready(function(){
    
    //readProducts(); /* it will load products when document loads */
    
    $(document).on('click', '#delete_product', function(e){
      
      var productId = $(this).data('id');
      SwalDelete(productId);
      e.preventDefault();
      console.log(productId);
    });
    
  });
  
  function SwalDelete(productId){
    
    swal({
      title: 'Are you sure?',
      text: "It will be deleted permanently!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm: true,
        
      preConfirm: function() {
        return new Promise(function(resolve) {
             
           $.ajax({
            url: 'delete_inv.php',
            type: 'GET',
              data: 'delete='+productId,
              dataType: 'json'
           })
           .done(function(response){
            swal('Deleted!', response.message, response.status);
          readProducts();
           })
           .fail(function(){
            swal('Oops...', 'Something went wrong with ajax !', 'error');
           });
        });
        },
      allowOutsideClick: false        
    }); 
    
  }
  
  function readProducts(){
    setTimeout(function(){
            window.location.href = 'get-info.php?infoid='+'' <?php //echo $val; ?>;
         }, 50);


    //$('#load-products').load('manage-clients.php'); 
  }
  
</script>
<script >
  var base_url = "<?= base_url(); ?>";
</script>
<script>
 $(document).ready(function() {
    const urlSegments = window.location.pathname.split('/').filter(Boolean);
    const infoid = urlSegments[urlSegments.length - 1]; // Get last segment

    if (!/^\d+$/.test(infoid)) {
        console.error("Invalid infoid detected:", infoid);
        return;
    }

    $.ajax({
        url: base_url.replace(/\/$/, '') + "/client/viewclientinfo/" + encodeURIComponent(infoid),
        type: "GET",
        dataType: "html",
        success: function(response) {
            $("#clientInfoContainer").html(response);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching client info:", error);
            alert("Failed to fetch client information.");
        }
    });
});

    //readProducts(); /* it will load products when document loads */
    
    $(document).on('click', '#delete_product2', function(e){
      
      var productId2 = $(this).data('id');
      SwalDelete2(productId2);
      e.preventDefault();
      console.log(productId2);
    });
    
  
  
  function SwalDelete2(productId2){
    
    swal({
      title: 'Are you sure?',
      text: "It will be deleted permanently!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm: true,
        
      preConfirm: function() {
        return new Promise(function(resolve) {
             
           $.ajax({
            url: 'delete pro.php',
            type: 'GET',
              data: 'delete='+productId2,
              dataType: 'json'
           })
           .done(function(response){
            swal('Deleted!', response.message, response.status);
          readProducts();
           })
           .fail(function(){
            swal('Oops...', 'Something went wrong with ajax !', 'error');
           });
        });
        },
      allowOutsideClick: false        
    }); 
    
  }
  
  function readProducts(){
    setTimeout(function(){
            window.location.href = 'get-info.php?infoid='+'' <?php //echo $val; ?>;
         }, 50);


    //$('#load-products').load('manage-clients.php'); 
 }
  
</script>


<!-- <script>
  $(document).ready(function(){
    

    var infoid = '<?php //echo $val; ?>';
    console.log(infoid);

 var bootstrapColors = [
        '#007bff', // Primary
        // '#6c757d', // Secondary
        '#28a745', // Success
        '#dc3545', // Danger
        '#ffc107', // Warning
        '#17a2b8', // Info
        // '#343a40', // Dark
        '#e83e8c', // Pink
        '#6610f2', // Purple
        '#fd7e14', // Orange
    ];
        // var formData = $(this).serialize();
         
        //  formData += '&pname=' + encodeURIComponent(p_name);

    //readProducts(); /* it will load products when document loads */
    
     $.ajax({
        url: 'ajax/charts3.php', // Replace with the path to your PHP script
        type: 'GET',
        data: {infoid: infoid},
        dataType: 'json',
        success: function(data) {
            // Access data for each pie chart
            var pie1Data = data.pie1;

              //console.log(pie1Data);
            //var colors = generateRandomColors(pie1Data.length);
              

            Morris.Donut({
                element: 'chart_pie_1',
                data: pie1Data,
                dataLabels: true,
            showPercentage: true,
            colors:bootstrapColors.slice(0, pie1Data.length),

            }).options.colors.forEach(function(color, index) {
              if (pie1Data[index] != undefined) {
              var node = document.createElement('span');
              node.innerHTML += '<span style="color:'+color+'"><i style="margin-left: 15px;" class="fas fa-square"></i> '+pie1Data[index].label+'</span>';
              document.getElementById("chart_pie_1_legend").appendChild(node);
            }
                // Your legend generation logic here
            });

       }

    })

    // Function to generate random colors
    // function generateRandomColors(numColors) {
    //     var colors = [];
    //     for (var i = 0; i < numColors; i++) {
    //         var color = '#'+(Math.random()*0xFFFFFF<<0).toString(16); // Generate random hex color
    //         colors.push(color);
    //     }
    //     return colors;
    // }
  });
  
</script> -->
<script>
    $(document).ready(function () {
        // Convert PHP JSON to JavaScript array
        const financialYears = <?= $financialYears; ?>;

        // Prepare data for Morris.js
        const chartData = financialYears.map(year => ({
            label: year.FinancialYear,
            value: parseFloat(year.TotalAmount)
        }));

        // Initialize Morris Donut
       const donutChart= new Morris.Donut({
            element: 'chart_pie_1',
            data: chartData,
            colors: ['#007bff', // Primary
        // '#6c757d', // Secondary
        '#28a745', // Success
        '#dc3545', // Danger
        '#ffc107', // Warning
        '#17a2b8', // Info
        // '#343a40', // Dark
        '#e83e8c', // Pink
        '#6610f2', // Purple
        '#fd7e14'],
            resize: true
        });
        //Generate the legend
        const legendContainer = document.getElementById("chart_pie_1_legend");
        chartData.forEach(function (item, index) {
        const color = donutChart.options.colors[index];
        const legendItem = `
            <span style="display: inline-block; margin-right: 15px;">
                <i class="fas fa-square" style="color: ${color};"></i> ${item.label}
            </span>
        `;
        legendContainer.innerHTML += legendItem;
    });
});
</script>

</body>
</html>
