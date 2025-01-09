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

.dropdown-menu{
  margin-top:10px;
  padding: 10px;
font-size:15px;
}
.form-control{
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 0px;
    /*-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;*/
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
               <!--  <div class="col-md-3">
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
                          <option value="1"> Suppliers </option>
                          <option value="2"> Customers</option>
                          <option value="2"> Dual (Cust / Sup)</option>                             
                        </select>       
                  </div>
               </div> --> 
                
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
 
            <div class="row">
              <div class="col-md-12">
                <div class="box box-success">
                  <div class="box-header" style="text-align:center">
                  </br>
                      <h3 class="box-title" id="item"><?= $accountInfo->u_type; ?></h3>
                      </br>
                      
                          <!-- <h4 id="date"> </h4> -->
                          </br>
                        <div>
                          <h2 class="box-title">Accounts of <?= $accountInfo->c_name;?></h2><!-- <h2 class="box-title" style="padding-top: 10px;"></h2> -->
                          <h2 class="box-title pull-right" style="margin-top: 10px; margin-right: 20px;"><b></b> </h2>
                          </br>
                          <h2 class="box-title" style="padding-top: 10px;"><b>Location : <?= $accountInfo->location; ?></b></h2></br>
                                    

                      </div>
                    </div>
                  <div class="row">  
                 <h3 class="box-title pull-left" style="position: relative;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ' '." CodeTech Engineers";?></h3>
                 <h3 class="box-title pull-right" style="text-align: right;"><?= " Opening Balance: ". $accountInfo->opening_bal;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                  </div>
               <section class="content">
                <div class="row">
                 <div class="col-xs-12">
                    <div class="box">
                      <div class="box-body">                                                 
                             
                          <table id="examplez" class="table table-bordered table-striped">

                            <button type="button" id="btnplus" class="btn btn-success btn-sm pull-right" style="margin: 20px 70px 2px 2px;" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-plus"></span></button></br></br>
                                      <hr>

                                <thead>
                                       <tr>
                                          <th>Sno.</th>
                                          <th>Date</th>
                                          <th> Voucher Type </th>
                                          <th> Voucher No.</th>
                                          

                                          <th> Credit </th>
                                          <th> Dedit</th>
                                          <th> Subtotal </th>
                                          
                                      </tr>
                                  </thead>

                                     <tbody>                                                                     
                                              
                            <!--        
                                    <?php //client
                                        //echo $cid;
                                        if ($u_type == 0) {
                                        $c = 1;
                                        $subtotal = $accountInfo->opening_bal ?? 0; // Starting with the opening balance
                                        $credittotal = 0;
                                        $debittotal = 0;
                                        $close=0;
                                        foreach ($ledgerDetails as $row): ?>
                                            <tr>
                                                <td><?= $c++; ?> </td>
                                               <td><?= $row->created; ?></td> 
                                                
                                                <td><?= $row->voucher_type; ?></td>
                                                <td><?php //$row->invoice_details;

                                                  // Assuming you have a $row object with the necessary data
                                                  if ($row->voucher_type == "Sales") { 
                                                      // Extract invoice number from invoice_details if Sales
                                                      $invoice_number = $row->invoice_details; 
                                                      
                                                      //$orderid = explode('+', $invoice_number)[1];


                                                      $parts = explode('+', $invoice_number);
                                                      $invoice_id = $parts[0];  // This is the invoice part, e.g., 'INV/24-25/0008'
                                                      $orderid = $parts[1];      // This is the orderid part, e.g., '660fd53993598'


                                                        echo '<a href="' . base_url() . '/taxinv/printtaxinv?orderid=' . urlencode($orderid) . '" target="_blank">' ."-----".$invoice_id. '</a>';


                                                      // Display invoice number with anchor tag
                                                     // echo '<a href="' . base_url() . '/taxinv/printtaxinv?orderid=' . urlencode($invoice_number) . '" target="_blank">' . $invoice_number . '</a>';

                                                  } else { 
                                                      // For other voucher types (like Receipt), just display invoice_details
                                                      echo $row->invoice_details; 
                                                  }
                                                 ?></td>
                                                

                                                 <td>
                                                  <?= $row->credit ?? 0; ?>
                                                  <?php $credittotal += $row->credit ?? 0; ?>
                                                 </td>

                                                 <td>
                                                  <?= $row->debit ?? 0; ?>
                                                  <?php $debittotal += $row->debit ?? 0; ?>
                                                  </td> 
                                  

                                          
                                                <td><?= $subtotal += ($row->debit - $row->credit); ?></td>
                                                
                                            </tr>
                                        <?php endforeach; }?>



                                         <?php  
                                          if ($u_type == 1 || $u_type == 2) {
                                              $c = 1;
                                              $subtotal = $accountInfo->opening_bal;
                                              $credittotal = 0;
                                              $debittotal = 0;

                                              foreach ($ledgerDetails as $row): ?>
                                                  <tr>
                                                      <td><?= $c++; ?> </td>
                                                      <td><?= $row->created; ?></td>
                                                      <td><?= $row->voucher_type; ?></td>
                                                      <td><?php

                                                                                     
                                                    // Assuming you have a $row object with the necessary data
                                                    $invoice_details = $row->invoice_details;
                                                    $orderid = '';
                                                    $invoice_id = '';

                                                    // Check if invoice details contain a '+' symbol and split them
                                                    if (strpos($invoice_details, '+') !== false) {
                                                        $parts = explode('+', $invoice_details);
                                                        $invoice_id = $parts[0]; // Invoice part, e.g., 'INV/24-25/0008'
                                                        $orderid = $parts[1];    // Order ID part, e.g., '660fd53993598'
                                                    } else {
                                                        // If no '+' is found, treat the entire string as invoice_id
                                                        $invoice_id = $invoice_details;
                                                    }

                                                    // Generate the appropriate anchor tag based on the voucher type
                                                    if ($row->voucher_type == "Sales") {
                                                        echo '<a href="' . base_url() . '/taxinv/printtaxinv?orderid=' . urlencode($orderid) . '" target="_blank">-----' . $invoice_id . '</a>';
                                                    } elseif ($row->voucher_type == "Purchase") {
                                                        echo '<a href="' . base_url() . '/purchaseinv/printpurchaseinv?orderid=' . urlencode($orderid) . '" target="_blank">-----' . $invoice_id . '</a>';
                                                    } else {
                                                        // Default behavior for other voucher types
                                                        echo $invoice_details;
                                                    }



                                                       ?></td>
                                                      
                                                      <td>
                                                          <?= $row->credit ?? 0; ?>
                                                          <?php $credittotal += $row->credit ?? 0; ?>
                                                      </td>
                                                      
                                                      <td>
                                                          <?= $row->debit ?? 0; ?>
                                                          <?php $debittotal += $row->debit ?? 0; ?>
                                                      </td>
                                                      
                                                      <td>
                                                          <?= $subtotal += ($row->credit ?? 0) - ($row->debit ?? 0); ?>
                                                      </td>
                                                  </tr>
                                              <?php endforeach; } ?>
                                         


 -->                             
                                      <?php 
                                      // Default setup for opening balance
                                      $subtotal = $accountInfo->opening_bal ?? 0; // Starting with the opening balance
                                      $credittotal = 0;
                                      $debittotal = 0;
                                      $c = 1; // Counter for ledger

                                      foreach ($ledgerDetails as $row) {
                                          // Define voucher type and handle accordingly
                                          if ($u_type == 0) { // Client (Sales -> Credit, Receipt -> Debit)
                                              // Sales: Credit
                                              if ($row->voucher_type == "Sales") {
                                                  $credit = $row->credit ?? 0;
                                                  $subtotal += $credit;
                                                  $credittotal += $credit;
                                              }
                                              // Receipt: Debit
                                              elseif ($row->voucher_type == "Receipt") {
                                                  $debit = $row->debit ?? 0;
                                                  $subtotal -= $debit;
                                                  $debittotal += $debit;
                                              }
                                          }
                                          elseif ($u_type == 1) { // Supplier (Receipt -> Credit, Purchase -> Debit)
                                              // Receipt (Payment): Credit (Increase the balance)
                                              if ($row->voucher_type == "Receipt") {
                                                  $credit = $row->credit ?? 0;
                                                  $subtotal -= $credit;  // Increase the balance for the supplier
                                                  $credittotal += $credit;
                                              }
                                              // Purchase: Debit (Increase the amount owed)
                                              elseif ($row->voucher_type == "Purchase") {
                                                  $debit = $row->debit ?? 0;
                                                  $subtotal += $debit;  // Decrease the balance for the supplier (increase amount owed)
                                                  $debittotal += $debit;
                                              }
                                          }
                                          elseif ($u_type == 2) { // Dual (Payment and Sales -> Credit, Purchase -> Debit)
                                              // Payment: Credit (Increase the balance)
                                              if ($row->voucher_type == "Receipt") {
                                                  $credit = $row->credit ?? 0;
                                                  $subtotal += $credit;
                                                  $credittotal += $credit;
                                              }
                                              // Sales: Credit (Increase the balance)
                                              elseif ($row->voucher_type == "Sales") {
                                                  $credit = $row->credit ?? 0;
                                                  $subtotal += $credit;
                                                  $credittotal += $credit;
                                              }
                                              // Purchase: Debit (Increase the amount owed)
                                              elseif ($row->voucher_type == "Purchase") {
                                                  $debit = $row->debit ?? 0;
                                                  $subtotal -= $debit;
                                                  $debittotal += $debit;
                                              }
                                          }

                                          // Display the transaction details in the table (client, supplier, or dual)
                                          ?>
                                          <tr>
                                              <td><?= $c++; ?></td>
                                              <td><?= $row->created; ?></td>
                                              <td><?= $row->voucher_type; ?></td>
                                              <td>
                                                  <?php 
                                                      $invoice_details = $row->invoice_details;
                                                      $orderid = '';
                                                      $invoice_id = '';
                                                      
                                                      // Check if invoice details contain a '+' symbol and split them
                                                      if (strpos($invoice_details, '+') !== false) {
                                                          $parts = explode('+', $invoice_details);
                                                          $invoice_id = $parts[0]; // Invoice part
                                                          $orderid = $parts[1];    // Order ID part
                                                      } else {
                                                          $invoice_id = $invoice_details;
                                                      }

                                                      // Generate the appropriate anchor tag based on the voucher type
                                                      if ($row->voucher_type == "Sales") {
                                                          echo '<a href="' . base_url() . '/taxinv/printtaxinv?orderid=' . urlencode($orderid) . '" target="_blank">-----' . $invoice_id . '</a>';
                                                      } elseif ($row->voucher_type == "Purchase") {
                                                          echo '<a href="' . base_url() . '/purchaseinv/printpurchaseinv?orderid=' . urlencode($orderid) . '" target="_blank">-----' . $invoice_id . '</a>';
                                                      } else {
                                                          echo $invoice_details;
                                                      }
                                                  ?>
                                              </td>
                                              <td>
                                                  <?= $row->formatted_credit ?? 0; ?>
                                              </td>
                                              <td>
                                                  <?= $row->formatted_debit ?? 0; ?>
                                              </td>
                                              <td>
                                                  <?= number_format($subtotal).".00"; ?>
                                              </td>
                                          </tr>
                                      <?php } ?>

        
                                     </tbody>
                                    
                                     <tfoot>
                                      <tr>
                                            <td> </td>
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td><h3> Total Bal. Credit & Debit </h3></td>
                                            
                                            <td><h3 id="totalamt"><?= number_format($credittotal).".00"; ?></h3></td>
                                                                              
                                            <td><h3 id="totalamt"><?=number_format($debittotal).".00"; ?></h3></td>
                                            <td></td>
                                                                                        
                                      </tr>
                                      <tr>
                                        <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><h3> Closing Balance </h3></td>
                                            <td><h3 id="totalamt"><?= number_format($subtotal).".00"; ?> </h3></td>
                                            
                                            <td></td>


                                      </tr>
                                    </tfoot>
                                 </table> 
                          
                                </div>
                            </div>
                                
                                 <div  class="btn-group" data-toggle="buttons" role="group">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="0" value="Sr. No.">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="1" value="Date">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="2" value="voucher_type">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="3" value="Voucher no">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="4" value="credit">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="5" value="debit">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="6" value="subtotal">
                                
                              
                                  
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
                        
              <form class="form-horizontal style-form" name="form" id="form" method="post" action="<?=base_url()?>/client/insert">
                <p style="color:#F00"><?php //echo $_SESSION['msg'];?><?php //echo $_SESSION['msg']="";?></p>
                  
            <!-- /box-header -->
            <!-- form start -->
            
              <div class="box-body">  
                <div class="form-group">
                  <label id="cidlbl" class="col-sm-3 control-label">Transaction ID</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="payid" id="payid" required="required" value="<?= isset($pay_id) ? $pay_id : ''; ?>"   readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label id="cnamelbl" class="col-sm-3 control-label">Company Name <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <!--  <input type="text" class="form-control" name="c_name"  value="<?php //if(isset($_POST['c_name'])){ echo $_POST['c_name'];} ?>" id="c_name" placeholder="Company Name"> -->
                   <select name="client2" id="co" class="form-control select2" style="height: 35px !important;width:100% !important;">
                    <?php if ($cid) { ?>
                        <option value="<?= $cid; ?>" selected="selected"><?= $accountInfo->c_name; ?></option>
                    <?php } else { ?>
                        <option value="<?= $cid; ?>"><?= $accountInfo->c_name; ?></option>
                    <?php } ?>

                        </select>
                    <div id="c_name_error" style="color:red;"> </div>
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
                     <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount"data-action="convert-to-words" data-target="price-someId">
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
                    <option value="YES BANK">YES BANK</option>
                    <option value="ICICI BANK">ICICI BANK</option>

                   </select>
                    <div id="bank_error" style="color: red;">  </div>
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
   $(document).ready(function() {
            $('#examplez').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'processing' :true,
                'info': true,
                'autoWidth': false,
                'footer':true,
                dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
                buttons: getExportButtons('#examplez'),
                initComplete: function () {
                    var btns = $('.dt-button');
                    btns.addClass('btn btn-primary btn-sm btn-group');
                    btns.removeClass('dt-button');

                },        
                
                   "lengthMenu": [[20, 50, 150, -1], [20, 50, 150, "All"]]
      
      

});
});
    
</script>

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

    // $('#form').on('submit', function(event) {
    //     event.preventDefault();

    //     var startDate = $('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD');
        
    //     var endDate = $('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD');
    //     //$('#date').text(startDate+ " to " +endDate );

    //     var supplier=$('#supplier').val();
    //     //$('#item').text("Supply Of : "+item_name);
    //     var customer=$('#customer').val();
    //     var ctype=$('#ctype').val();
    //    // console.log(ctype);
    //     //console.log(customer);
    //     //console.log(supplier);

    //     if(ctype == 1)
    //     {
    //       $('#item').text("Supplier");
    //     }
    //     else
    //     {
    //       $('#item').text("Customer");
    //     }

    //     //$('#company').text(customer);

    //     // $.ajax({
    //     //     url: 'ajax/transection-data.php',
    //     //     method: 'GET',
    //     //     data: { startDate: startDate, endDate: endDate,customer: customer, supplier: supplier, ctype:ctype},
    //     //     dataType: 'json',
    //     //     contentType: false,
    //     //     success: function(response) {
    //     //         console.log(response);
    //     //         //console.log(response.taxamt);
    //     //         //console.log(response.totalamount);

    //     //         table.clear();

    //     //         $('#date').text("Date Range: "+startDate +" To "+endDate);
    //     //         if (response && response.aaData && Array.isArray(response.aaData)) {
    //     //             response.aaData.forEach(function(row) {
    //     //                 table.row.add(row);
    //     //             });
    //     //         } else {
    //     //             console.error("Invalid response format:", response);
    //     //         }
    //     //         table.draw();

    //     //         // $('#subtotal').text(response.subtotal + ".00");
    //     //         // $('#taxamt').text(response.taxamt + ".00");
    //     //         $('#totalamt').text(response.totalamount + ".00");
    //     //     },
    //     //     error: function(xhr, status, error) {
    //     //         console.error(error);
    //     //     }
    //     // });
    // });

    $('.select2').select2({ placeholder: "Select a Client", allowClear: true });
    $('.select23').select2({ placeholder: "Select Item", allowClear: true });
    $('.select234').select2({ placeholder: "Select Type", allowClear: true });

</script>

 
<script>
   $(document).ready(function(){
    
    $(document).on("click", "#submit", function(e) {
    e.preventDefault();

     isValid = true;

    // Clear previous error messages
    $('#co_error').text('');
    $('#purpose_error').text('');
    $('#amount_error').text('');
    $('#dtp_error').text('');
    $('#ctype_error').text('');
    $('#bank_error').text('');
    // // Validate Company Name
    // if ($('#c_nameedit').val().trim() === '') {
    //     $('#c_name_error').text('Company name is required.');
    //     isValid = false;
    // }

    $('#co, #purpose, #amount, #datepicker, #ctype').removeClass('is-invalid');

    // Validate Company Name
    if ($('#co').val().trim() === '') {
        $('#co_error').text('Company name is required.');
        $('#co').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Address
    if ($('#purpose').val().trim() === '') {
        $('#purpose_error').text('purpose is required.');
        $('#purpose').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Mobile Number
    if ($('#amount').val().trim() === '') {
        $('#amount_error').text('Amount is required.');
        $('#amount').addClass('is-invalid'); // Highlight the field
            //$('#phoneedit').addClass('is-invalid');  // Adding class to input
    //$('.iti').addClass('is-invalid');        // Adding class to intl-tel-input wrapper
    isValid = false;
        //isValid = false;
    }

    // Validate GST
    if ($('#datepicker').val().trim() === '') {
        $('#dtp_error').text('dateofpayment is required.');
        $('#datepicker').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

    // Validate Bill Type
    // if ($('#ctype').val().trim() === '') {
    //     $('#ctype_error').text('Please select a Bill Type.');
    //  $('#ctype').addClass('is-invalid');  // Add to the hidden select (optional for form data)
    // $('#ctype').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add class to Select2 container
    // isValid = false;
    // }

//     if ($('#ctype').val().trim() === '') {
//     $('#ctype_error').text('Please select a Bill Type.');
//     $('#ctype').addClass('is-invalid');  // Add to the hidden select
//     $('#ctype').next('.select2').find('.select2-selection').addClass('is-invalid');  // Add to Select2 container
//     isValid = false;
// } else {
//     $('#ctype').removeClass('is-invalid');
//     $('#ctype').next('.select2').find('.select2-selection').removeClass('is-invalid'); // Remove red border
//     $('#ctype_error').text('');  // Clear error message
// }



    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
        return;
    } else {
        // Get form data

        var payid=$('#payid').val().trim();
        var co=$('#co').val();
        //$('#item').text("Supply Of : "+item_name);
        var purpose=$('#purpose').val();
        var dateofpayment = $('#datepicker').val();
        var ctype=$('#ctype').val();
        var amount = $('#amount').val();
    
        var u_type = 0; // Assuming you want this value
        var fd = new FormData();
        fd.append("payid", payid);
        fd.append("co", co);
        fd.append("purpose", purpose);
        fd.append("amount", amount);
        fd.append("ctype", ctype);

        fd.append("dateofpayment", dateofpayment);


        //fd.append("u_type", u_type); // Ensure this is included

        console.log("cid: ", payid);
        console.log("c_name: ", co);
        console.log("c_add: ", purpose);
        console.log("fullno: ", amount);
        //console.log("country: ", countr);
        //console.log("gst: ", gst);
        console.log("email: ", dateofpayment);
        console.log("ctype: ", ctype);
        console.log("u_type: ", u_type);


        console.log(fd);    

        $.ajax({
            type: "post",  // Change this to "post" if using POST
            url: base_url + "/transaction/insert",
            data: fd,
            processData: false,
            contentType: false,
            dataType:"json",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'  // Important for AJAX detection
            },
            success: function(response) {
                //console.log(response);
                // if (response.res === "success") {
                    
                //     console.log(response);
                //     console.log("Executed Query: ", response.query);

                //     $("#modal-default").modal("hide");
                //     $("#form")[0].reset();
               
                //     $("#example1").DataTable().clear().destroy();
                //     fetch();

                //      $.ajax({
                //     url:  base_url +'/client/get_next_id', // URL to get the next ID
                //     method: 'GET',
                //     success: function(data) {
                //         var result = JSON.parse(data);
                //         $('#cid').val(result.next_id); // Set the new ID valu

                //         $('#address_country').val('in'); // 
                //     },
                //     error: function() {
                //         console.log('Error fetching the next ID.');
                //     }
                // });
                
                // } 
                // else {
                //       toastr.error(response.message);
                // }
                        try {
            // Parse JSON response
            const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
            console.log('Parsed Response:', jsonResponse);

            $("#modal-default").modal("hide");
            $("#form")[0].reset();
            //$("#examplez").DataTable().clear().destroy();
              //  fetch();
                Swal.fire({
                    title: "Good!",
                    text: "New Client Data Inserted!",
                    icon: "success",
                    showConfirmButton: false, // Hide the OK button
                    timer: 3000, // Close the popup after 3 seconds (3000 milliseconds)
                  }).then(function() {
                    // This function will be called after the popup closes
                    //location.reload(); // Refresh the page
                  window.location.href = base_url+'/account/getledger/'+co;
                  //$("#example1").DataTable().clear().destroy();
                    //fetch();
                  });
        } catch (error) {
            console.error('Invalid JSON Response:', error);
        }

            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    }
  })

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

    $('#client2').select2({
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
<script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/convertNumberToWords.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/getExportButtons.js"></script>
 <!-- <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/account.js"></script> -->
  
</body>
</html>
