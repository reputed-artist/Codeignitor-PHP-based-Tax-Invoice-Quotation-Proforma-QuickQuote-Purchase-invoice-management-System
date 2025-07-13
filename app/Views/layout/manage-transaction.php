
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
/* Handle error state on Select2 */
.has-error .select2-selection,
.select2-selection.is-invalid {
    border-color: red !important;
    width: 100% !important;
}

/* Standard error styles */
.error,
input.error,
.is-invalid,
.iti.is-invalid input,
.iti2.is-invalid input {
    border: 1px solid red !important;
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
      Transaction Report
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Transaction Report</li>
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
                      <select name="ctype1" id="ctype1" class="form-control select234" style="height: 35px !important;width:100% !important;" >
                          <option value=""></option>
                          <option value="0"> Clients  </option>
                          <option value="1"> Suppliers</option>
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
                    </div>                 
               </div>
             </div>
      
                <!-- <div class="col-md-2">
                    <div class="form-group">
                        <label></label></br>
                        <input type="submit" class="btn btn-success" name="submit">
                    </div>
                </div> -->
                </form>
            </div>
 
            <div class="row">
              <div class="col-md-12">
                <div class="box box-success">
                  <div class="box-header" style="text-align:center">
                  </br>
                      <h3 class="box-title" id="item"></h3>
                      </br>
                      
                      <h4 id="date"> </h4>
                      </br>
                        <div id="hide">
                        <h3 class="box-title" id="company"></h3></br>
                        
                      <!--   <h3 class="box-title" id="stn"> STN:<?php //echo $config->s_t_r_no; ?></h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3 class="box-title" id="ntn">NTN:<?php //echo $config->ntn_no; ?></h3> -->
                      </div>
                    </div>
                 <h3>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ' '." CodeTech Engineers";?></h3>
               <section class="content">
                <div class="row">
                 <div class="col-xs-12">
                    <div class="box">
                      <div class="box-body">                                                 
                             
                          <table id="example" class="table table-bordered table-striped">

                            <button type="button" id="btnplus" class="btn btn-success btn-sm pull-right" style="margin: 20px 70px 2px 2px;" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-plus"></span> &nbsp; Add Transaction</button></br></br>
                                      <hr>

                                <thead>
                                        <tr>
                                            <th>Sr. no.</th>
                                            <th class="hidden-phone">Per/Com</th>
                                            <th> Location </th>
                                            <th> Date of Payment
                                            <th> User-Type </th> 
                                            <th> Purpose</th>

                                            <th> Mode Of Payment</th>
                                            <th> Amount </th>
                                            <th>Created</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                  </thead>

                                     <tbody>                                                                     
                  
                                     
                                     </tbody>
                                    
                                     <tfoot>
                                      <tr>
                                            <td> </td>
                                            <td>&nbsp;</td>
                                            <td><h3>Total </h3></td>
                                            <td></td>
                                            <td>&nbsp;</td>
                                                                              
                                            <td></td>
                                            <td></td>
                                            <td><h3 id="totalamt">0</h3></td>
                                            <td></td>
                                            <td></td>
                                            
                                            <td></td>
                                            
                                      </tr>
                                    </tfoot>
                                 </table> 
                          
                                </div>
                            </div>
                                
                                 <div  class="btn-group" data-toggle="buttons" role="group">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="0" value="Sr. No.">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="1" value="Per/Com">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="2" value="Location">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="3" value="Date of payment">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="4" value="User-Type">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="5" value="Purpose">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="6" value="Mode of payment">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="7" value="Amount">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="8" value="Created">
                                  
                                  </br>

                                </div>  
                         </div>
                       </div>
                     </section>
                   </div>

                   <button class="floating-btn" data-toggle="modal" data-target="#modal-default">+</button>   

        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Transaction</h4>
              </div>
        
            <div class="modal-body">
                        
              <form class="form-horizontal style-form" name="form" id="form" method="post" action="<?=base_url()?>/transaction/insert">
                <p style="color:#F00"><?php //echo $_SESSION['msg'];?><?php //echo $_SESSION['msg']="";?></p>
                  
            <!-- /box-header -->
            <!-- form start -->
            
                <div class="box-body">  
                <div class="form-group">
                  <label id="cidlbl" class="col-sm-3 control-label">Transaction ID</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="payid" id="payid" required="required" value="<?= isset($pay_id) ? $pay_id : ''; ?>"  readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label id="cnamelbl" class="col-sm-3 control-label">Company Name <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <!--  <input type="text" class="form-control" name="c_name"  value="<?php //if(isset($_POST['c_name'])){ echo $_POST['c_name'];} ?>" id="c_name" placeholder="Company Name"> -->
                   <select name="clientz" id="co" class="form-control select2" style="height: 35px !important;width:100% !important;">
                            <option value=""></option>
                        </select>
                    <div id="co_error" style="color:red;"> </div>
                  </div>
                </div>

                <div class="form-group">
                  <label id="caddlbl" class="col-sm-3 control-label">Purpose <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="purpose" id="purpose" rows="4" 
                      placeholder="Purpose"><?php //if(isset($_POST['c_add'])){ echo $_POST['c_add'];} ?></textarea>
                                  <div id="purpose_error" style="color: red;"> </div>
                </div>
              </div>

              
              <div class="form-group">
                  <label id="emaillbl" class="col-sm-3 control-label">Amount<span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount" data-action="convert-to-words" data-target="price-someId">
                    <div class="" data-attrib="price-someId"></div>
                    <div id="amtwords" class="words"></div>
                    <div id="amount_error" style="color:red;"> </div>
                  </div>
                </div>


                <div class="form-group">
                  <label id="emaillbl" class="col-sm-3 control-label">Date of Payment<span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control pull-right" name="datepicker" id="datepicker" value="<?php echo date('d-m-Y'); ?>">
                    <div id="dtp_error" style="color:red;"> </div>
                  </div>
                </div>

                <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">Bank <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <select name="ctype" class="form-control select2" style=" height: 34px;width:100%" id="ctype">
                    <option value=""></option>
                    <!-- <option value="YES BANK">YES BANK</option>
                    <option value="ICICI BANK">ICICI BANK</option> -->

                   </select>
                    <div id="ctype_error" style="color: red;">  </div>
                </div>
              </div>

              <div class="form-group">
                <label id="c_datelbl" class="col-sm-3 control-label">Creation Date</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="created" value="<?php $c=date("d-M-Y");
                                        echo $c; ?>" readonly/>
                  </div>
              </div>

              <br>
             
              
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                <input type="submit" class="btn btn-primary" value="Save changes" id="submit">
              </div>

             </div> <!-- /.box-body --> 

             </form>

             </div> 

          </div>
                    <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
     </div>





      <div class="modal fade" id="modal-default1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Transaction</h4>
              </div>
        
            <div class="modal-body">
                        
              <form class="form-horizontal style-form" name="form1" id="form1" method="post" action="<?=base_url()?>/transaction/update">
                <p style="color:#F00"><?php //echo $_SESSION['msg'];?><?php //echo $_SESSION['msg']="";?></p>
                  
            <!-- /box-header -->
            <!-- form start -->
            
                <div class="box-body">  
                <div class="form-group">
                  <label id="cidlbl" class="col-sm-3 control-label">Transaction ID</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="payidedit" id="payidedit" required="required" 
                    value=""  readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label id="cnamelbl" class="col-sm-3 control-label">Company Name <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <!--  <input type="text" class="form-control" name="c_name"  value="<?php //if(isset($_POST['c_name'])){ echo $_POST['c_name'];} ?>" id="c_name" placeholder="Company Name"> -->
                   <select name="coedit" id="coedit" class="form-control select2" style="height: 35px !important;width:100% !important;">
                            <option value=""></option>
                        </select>
                    <div id="coedit_error" style="color:red;"> </div>
                  </div>
                </div>

                <div class="form-group">
                  <label id="caddlbl" class="col-sm-3 control-label">Purpose <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="editpurpose" id="editpurpose" rows="4" 
                      placeholder="Purpose"><?php //if(isset($_POST['c_add'])){ echo $_POST['c_add'];} ?></textarea>
                                  <div id="editpurpose_error" style="color: red;"> </div>
                </div>
              </div>

              
              <div class="form-group">
                  <label id="emaillbl" class="col-sm-3 control-label">Amount<span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                     <input type="number" class="form-control" name="editamount" id="editamount" placeholder="Amount" data-action="convert-to-words" data-target="price-someId">
                    <div class="" data-attrib="price-someId"></div>
                    <div id="amtwords" class="words"></div>
                     <div id="editamount_error" style="color:red;"> </div>
                  </div>
                </div>


                <div class="form-group">
                  <label id="emaillbl" class="col-sm-3 control-label">Date of Payment<span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control pull-right" name="editdatepicker" id="editdatepicker" value="<?php echo date('d-m-Y'); ?>">
                    <div id="editdtp_error" style="color:red;"> </div>
                  </div>
                </div>

                <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">Bank <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <select name="editctype" class="form-control select2" style=" height: 34px;width:100%" id="editctype">
                    <option value=""></option>
                    <!-- <option value="YES BANK">YES BANK</option>
                    <option value="ICICI BANK">ICICI BANK</option> -->

                   </select>
                    <div id="editctype_error" style="color: red;">  </div>
                </div>
              </div>

              <div class="form-group">
                <label id="c_datelbl" class="col-sm-3 control-label">Creation Date</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="editcreated" value="<?php $c=date("d-M-Y");
                                        echo $c; ?>" readonly/>
                  </div>
              </div>

              <br>
             
              
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                <input type="submit" class="btn btn-primary" value="Save changes" id="update">
              </div>

             </div> <!-- /.box-body --> 

             </form>

             </div> 

          </div>
                    <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
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
 
        $("#datepicker").datepicker({
                format: "dd-mm-yyyy",
                language: "fr",
                changeMonth: true,
                changeYear: true,
                autoclose: true
    });

    

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


    $('.select234').select2({ placeholder: "Select Type", allowClear: true });

</script>

 <script>

  //var globalSubtotalTotal=0;
 
 let totalAmount = 0;

    function loadTransactions(date = null, client = null, clienttype=null) {

//        


// // Set total after loop
//        $('#totalamt').text(totalAmount.toFixed(2));

        console.log("Loading invoices for page: " + date + client + clienttype); // Add this line
       
        $.ajax({
            url: base_url + '/transaction/loadTransactions',
            type: 'GET',
            data: { 
                    date: date,
                    client: client,
                    clienttype:clienttype

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
        buttons: getExportButtons('#example',[0,1,2,3,4,5,6,7,8,9,10,11]),  
        columns: [
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
            },
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
            }, 
            
            { 'data': 'purpose' },
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
                                        

                          //$('#subtotal').text(response.totalSubtotal + ".00");
                          //$('#taxamt').text(response.totalTaxAmount + ".00");
                          $('#totalamt').text(response.totalAmount + ".00");
                          console.log(response);


                }
              })
             }


  $(document).ready(function () {

    let selectedYear = null;
let selectedClient = null;



 $('#client').select2({
    placeholder: "Select a Person or Company",
    allowClear: true,
            ajax: {
            url: base_url + "/taxinv/getclient", // Controller method
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
    $('#co').select2({
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

    // $('#ctype').select2({ placeholder: "Select Bank", allowClear: true });

               // Now update #editctype select2 with Bank Details
                $('#ctype').select2({
                  placeholder: "Select Bank",
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



$('#daterange-btn').on('apply.daterangepicker', function(ev, picker) {
    selectedYear = picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD');
    loadTransactions(selectedYear, selectedClient);
});


  $('#client').on('select2:select', function() {
        selectedClient = $(this).val();
        loadTransactions(selectedYear, selectedClient);
    });

  $('#ctype1').on('select2:select', function() {
        selectedClientType = $(this).val();
        loadTransactions(selectedYear, selectedClient,selectedClientType);
    });

});

</script>
<script type="text/javascript">var base_url = "<?= base_url(); ?>";</script>
<script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/convertNumberToWords.js"></script>
 <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/transaction.js"></script> 
  <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/getExportButtons.js"></script>
</body>
</html>
