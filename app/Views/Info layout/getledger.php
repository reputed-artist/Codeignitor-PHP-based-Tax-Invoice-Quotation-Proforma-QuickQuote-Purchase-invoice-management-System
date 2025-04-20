
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

.has-error .select2-selection {
    border-color: rgb(185, 74, 72) !important;
    min-width: 100%;
    max-width: 100%;
}

input .error{
 border: 1px solid #f00;
}
  
.error{
 border: 1px solid #f00;
}

.is-invalid {
    border: 1px solid red;
}

.iti2.is-invalid input,
.iti.is-invalid input {
    border: 1px solid red !important;
}


.iti2.is-invalid input {
    border: 1px solid red !important;
}

/*.iti2.is-valid input {
    border: 1px solid green !important;
}
*/
.select2-selection.is-invalid {
    border: 1px solid red !important; /* Red border on Select2 dropdown */
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
                

               <?php if (!empty($fy) && is_array($fy) && count($fy) > 0): ?>  
                
              <div class="col-md-3 col-sm-5 col-xl-3 col-lg-3 d-print-none">
               <div class="form-group">
                  <label>Select FY:</label>                    
                    
                      <!-- <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div> -->

<!-- 
                          <select id="selectFY" class="form-control">
                          <?php foreach ($fy as $year): ?>
                          <option><?= esc($year['financial_year']) ?></option>
                          <?php endforeach; ?>

                          </select> -->
                     <?php
// Extract all the financial year strings from the array
$years = array_column($fy, 'financial_year');

// Sort the years just to be safe (optional but useful)
sort($years); // Ensures chronological order

// Now get the first and last parts
$fromYear = explode('-', $years[0])[0];                         // e.g., "2020"
$toYear = explode('-', $years[count($years) - 1])[1];           // e.g., "2023"
?>

<select id="selectFY" class="form-control">
    <!-- Append All option -->
    <option value="<?= $fromYear ?>-<?= $toYear ?>">All (<?= $fromYear ?>-<?= $toYear ?>)</option>

    <!-- Regular year options -->
    <?php foreach ($fy as $year): ?>
        <option><?= esc($year['financial_year']) ?></option>
    <?php endforeach; ?>
</select>


                                  
               </div><!-- /.form group -->
             </div>

             <?php else : ?>
    <p>No FY found.</p>
<?php endif; ?>

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
                 <h3 class="box-title pull-right" style="text-align: right;padding-right: 40px;" id="opening_bal"><?= " Opening Balance: ".$dops ?? 0;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
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
                                              
                        

    <?php if (!empty($ledgerDetails) && is_array($ledgerDetails) && count($ledgerDetails) > 0) : ?>

                                     </tbody>
                                    
                                     <tfoot>
                                      <tr>
                                            <td> </td>
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td><h3> Total Bal. Credit & Debit </h3></td>
                                            
                                            <td><h3 id="totalcreditamt"></h3></td>
                                                                              
                                            <td><h3 id="totaldebitamt"></h3></td>
                                            <td></td>
                                                                                        
                                      </tr>
                                      <tr>
                                        <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><h3> Closing Balance </h3></td>
                                            <td><h3 id="totalclosingamt"> </h3></td>
                                            
                                            <td></td>


                                      </tr>
                                    </tfoot>
                                 </table> 
                          
                                 <?php else : ?>
                                <p>No ledger details found.</p>
                            <?php endif; ?>

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
    var base_url = "<?php echo base_url(); ?>";
</script>


<script>
   $(document).ready(function() {

    var fy = $("#selectFY").val();
        var cid = "<?= $cid ?>"; // Ensure this dynamically gets the correct client ID
        var u_type=parseInt("<?= $accountInfo->u_type; ?>");

        console.log(cid);
        console.log(u_type);

        let totalCredit = 0;
let totalDebit = 0;

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
                buttons: getExportButtons('#examplez',[0,1,2,3,4,5,6]),
    
     
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

});
    
</script>

<script>
 $(document).ready(function () {
    //$("#selectFY").change(function () {
        var fy = $("#selectFY").val();
        var cid = "<?= $cid ?>"; // Ensure this dynamically gets the correct client ID
        var u_type=parseInt("<?= $accountInfo->u_type; ?>");

        console.log(cid);
        console.log(u_type);

        if (fy) {
            $.ajax({
                url: base_url + "/account/getLedgerByFY/" + cid,  // Ensure correct URL
                type: "GET",
                data: { fy: fy, u_type:u_type},  // Send FY as GET parameter
                dataType: "json",
                headers: { "X-Requested-With": "XMLHttpRequest" },  // Important!
                success: function (response) {
                    console.log(response);

                    //let runningBalance =<?= $dops; ?>

                    var tableBody = $("#examplez tbody");
                    $("#examplez").DataTable().clear();
                    tableBody.empty();

                    var totalcredit = 0;
                    var totaldebit = 0;
                    var subtotal = 0;

                    var rowIndex = 1; 
                    var receiptIndex = 1; // Independent counter for receipts

                     if (response.balances && response.balances.length > 0) {
                      console.log(response.balances);
                        // Find the correct financial year in response
                        let matchingFY = response.balances.find(item => String(item.fy).trim() === String(fy).trim());

                        if (matchingFY) {
                            console.log("Matching FY Found:", matchingFY); // Debug log

                            console.log("Selected FY:", fy);
                            console.log("Available FYs:", response.balances.map(b => b.fy));

                              if(u_type==0)
                              {
                                totalcredit+=parseFloat(matchingFY.opening_balance);
                              }
                              else if(u_type==1){
                                totaldebit+=parseFloat(matchingFY.opening_balance);
                              }
                              else {
                                
                                totaldebit+=parseFloat(matchingFY.opening_balance);

                              }

                            $("#opening_bal").text("Opening Balance: " + matchingFY.opening_balance);
                        } else {
                            console.warn("FY not found in response. Selected FY:", fy);
                            $("#opening_bal").text("No data available for selected FY");
                        }
                    } 
                    else {
                        $("#opening_bal").text("No balance data available");
                    }

                    if(u_type === 0){

                    // Process Ledger Transactions
                    if (response.ledger.length > 0) {
                        $.each(response.ledger, function (index, item) {
                            var invoiceParts = item.invoice_details ? item.invoice_details.split("+") : ["0.00", ""];

                            // Parse values
                            credit = parseFloat(item.credit) || 0.00;
                            debit = parseFloat(item.debit) || 0.00;

                            // Accumulate totals
                            totalcredit += credit;
                            totaldebit += debit;

                            console.log("Total Credit:", totalcredit);
                            console.log("Total Debit:", totaldebit);

                            console.log("Closing Balance", totalcredit-totaldebit);

                            // Update subtotal correctly
                            subtotal = totalcredit - totaldebit;

                            // Check if it's a receipt
                            let isReceipt = item.voucher_type === "Receipt";

                            // Assign the correct index
                            let displayIndex = rowIndex;
                            if (isReceipt) {
                                displayIndex = receiptIndex; // Use receipt index for receipts
                                receiptIndex++; // Increment only for receipts
                            }

                            tableBody.append(`
                                <tr>
                                    <td>${rowIndex}</td> <!-- Always increments for all rows -->
                                    <td>${item.created || 'N/A'}</td>
                                    <td>${item.voucher_type || 'N/A'}</td>
                                    <td>          
                                        ${invoiceParts[1] ?  
                                            `<a href="${base_url}/taxinv/printtaxinv?orderid=${invoiceParts[1]}" target="_blank">
                                                ------${isReceipt ? displayIndex : invoiceParts[0]}
                                            </a>` : (isReceipt ? displayIndex : rowIndex)}
                                    </td>
                                    <td>${item.formatted_credit || '0.00'}</td>
                                    <td>${item.formatted_debit || '0.00'}</td>
                                    <td>${subtotal.toFixed(2)}</td>
                                </tr>
                            `);

                            rowIndex++; // Always increment for table row numbering
                        });

                      }
                    } else if(u_type === 1)
                      {
                        // Process Ledger Transactions
                       if (response.ledger.length > 0) {
                        $.each(response.ledger, function (index, item) {
                            var invoiceParts = item.invoice_details ? item.invoice_details.split("+") : ["0.00", ""];

                            // Parse values
                            credit = parseFloat(item.credit) || 0.00;
                            debit = parseFloat(item.debit) || 0.00;

                            // Accumulate totals
                            totalcredit += credit;
                            totaldebit += debit;

                            console.log("Total Credit:", totalcredit);
                            console.log("Total Debit:", totaldebit);
                            console.log("Closing Balance", totalcredit-totaldebit);

                            // Update subtotal correctly
                            subtotal = totaldebit - totalcredit;

                            // Check if it's a receipt
                            let isReceipt = item.voucher_type === "Receipt";

                            // Assign the correct index
                            let displayIndex = rowIndex;
                            if (isReceipt) {
                                displayIndex = receiptIndex; // Use receipt index for receipts
                                receiptIndex++; // Increment only for receipts
                            }

                            tableBody.append(`
                                <tr>
                                    <td>${rowIndex}</td> <!-- Always increments for all rows -->
                                    <td>${item.created || 'N/A'}</td>
                                    <td>${item.voucher_type || 'N/A'}</td>
                                    <td>          
                                        ${invoiceParts[1] ?  
                                            `<a href="${base_url}/purchaseinv/printpurchaseinv?orderid=${invoiceParts[1]}" target="_blank">
                                                ------${isReceipt ? displayIndex : invoiceParts[0]}
                                            </a>` : (isReceipt ? displayIndex : rowIndex)}
                                    </td>
                                    <td>${item.formatted_credit || '0.00'}</td>
                                    <td>${item.formatted_debit || '0.00'}</td>
                                    <td>${subtotal.toFixed(2)}</td>
                                </tr>
                            `);

                            rowIndex++; // Always increment for table row numbering
                        });
                      }
                    }
                    else if(u_type===2)
                    {
                        // Process Ledger Transactions
                       if (response.ledger.length > 0) {
                        $.each(response.ledger, function (index, item) {
                            var invoiceParts = item.invoice_details ? item.invoice_details.split("+") : ["0.00", ""];

                            // Parse values
                            credit = parseFloat(item.credit) || 0.00;
                            debit = parseFloat(item.debit) || 0.00;

                                                        // Adjust logic for Supplier (invert logic)
                              if (item.voucher_type === "Purchase") {
                                  totaldebit += debit;
                              } else if (item.voucher_type === "Sales") {
                                  totalcredit += credit;
                              } else if (item.voucher_type === "Receipt") {
                                  totalcredit += credit;
                              }


                           console.log("Total Credit:", totalcredit);
                            console.log("Total Debit:", totaldebit);
                            console.log("Closing Balance", totaldebit-totalcredit);
                            // Update subtotal correctly
                            //subtotal = totaldebit - totalcredit;
                            //if()
                            subtotal = totaldebit - totalcredit;

                            // Check if it's a receipt
                            let isReceipt = item.voucher_type === "Receipt";

                            // Assign the correct index
                            let displayIndex = rowIndex;
                            if (isReceipt) {
                                displayIndex = receiptIndex; // Use receipt index for receipts
                                receiptIndex++; // Increment only for receipts
                            }

                            tableBody.append(`
                                <tr>
                                    <td>${rowIndex}</td> <!-- Always increments for all rows -->
                                    <td>${item.created || 'N/A'}</td>
                                    <td>${item.voucher_type || 'N/A'}</td>
                                    <td>          
                                        ${invoiceParts[1] ?  
                                            `<a href="${base_url}/${item.voucher_type === 'Sales' ? 'taxinv/printtaxinv' : 'purchaseinv/printpurchaseinv'}?orderid=${invoiceParts[1]}" target="_blank">
                                                ------${isReceipt ? displayIndex : invoiceParts[0]}
                                            </a>` : (isReceipt ? displayIndex : rowIndex)}
                                    </td>

                                    <td>${item.formatted_credit || '0.00'}</td>
                                    <td>${item.formatted_debit || '0.00'}</td>
                                    <td>${subtotal.toFixed(2)}</td>
                                </tr>
                            `);

                            rowIndex++; // Always increment for table row numbering
                        });
                      }
                    } 

                        $("#totalcreditamt").text(totalcredit.toFixed(2));
                        $("#totaldebitamt").text(totaldebit.toFixed(2));
                        $("#totalclosingamt").text(subtotal.toFixed(2));

                    //    else {
                    //     tableBody.append('<tr><td colspan="6">No records found.</td></tr>');
                    // }

                    
                },
                error: function (xhr, status, error) {
                    console.log("AJAX Error:", error);
                }
            });
        }
    });
//});



 $("#selectFY").change(function () {
        var fy = $("#selectFY").val();
        var cid = "<?= $cid ?>"; // Ensure this dynamically gets the correct client ID
        var u_type=parseInt("<?= $accountInfo->u_type; ?>");

        console.log(cid);
        console.log(u_type);

        if (fy) {
            $.ajax({
                url: base_url + "/account/getLedgerByFY/" + cid,  // Ensure correct URL
                type: "GET",
                data: { fy: fy, u_type:u_type},  // Send FY as GET parameter
                dataType: "json",
                headers: { "X-Requested-With": "XMLHttpRequest" },  // Important!
                success: function (response) {
                    console.log(response);

                    //let runningBalance =<?= $dops; ?>

                    var tableBody = $("#examplez tbody");
                    $("#examplez").DataTable().clear();
                    tableBody.empty();

                    var totalcredit = 0;
                    var totaldebit = 0;
                    var subtotal = 0;

                    var rowIndex = 1; 
                    var receiptIndex = 1; // Independent counter for receipts

                     if (response.balances && response.balances.length > 0) {
                      console.log(response.balances);
                        // Find the correct financial year in response
                        let matchingFY = response.balances.find(item => String(item.fy).trim() === String(fy).trim());

                        if (matchingFY) {
                            console.log("Matching FY Found:", matchingFY); // Debug log

                            console.log("Selected FY:", fy);
                            console.log("Available FYs:", response.balances.map(b => b.fy));

                              if(u_type==0)
                              {
                                totalcredit+=parseFloat(matchingFY.opening_balance);
                              }
                              else if(u_type==1){
                                totaldebit+=parseFloat(matchingFY.opening_balance);
                              }
                              else {
                                
                                totaldebit+=parseFloat(matchingFY.opening_balance);

                              }

                            $("#opening_bal").text("Opening Balance: " + matchingFY.opening_balance);
                        } else {
                            console.warn("FY not found in response. Selected FY:", fy);
                            $("#opening_bal").text("No data available for selected FY");
                        }
                    } 
                    else {
                        $("#opening_bal").text("No balance data available");
                    }

                    if(u_type === 0){

                    // Process Ledger Transactions
                    if (response.ledger.length > 0) {
                        $.each(response.ledger, function (index, item) {
                            var invoiceParts = item.invoice_details ? item.invoice_details.split("+") : ["0.00", ""];

                            // Parse values
                            credit = parseFloat(item.credit) || 0;
                            debit = parseFloat(item.debit) || 0;

                            // Accumulate totals
                            totalcredit += credit;
                            totaldebit += debit;

                            console.log("Total Credit:", totalcredit);
                            console.log("Total Debit:", totaldebit);

                            console.log("Closing Balance", totalcredit-totaldebit);

                            // Update subtotal correctly
                            subtotal = totalcredit - totaldebit;

                            // Check if it's a receipt
                            let isReceipt = item.voucher_type === "Receipt";

                            // Assign the correct index
                            let displayIndex = rowIndex;
                            if (isReceipt) {
                                displayIndex = receiptIndex; // Use receipt index for receipts
                                receiptIndex++; // Increment only for receipts
                            }

                            tableBody.append(`
                                <tr>
                                    <td>${rowIndex}</td> <!-- Always increments for all rows -->
                                    <td>${item.created || 'N/A'}</td>
                                    <td>${item.voucher_type || 'N/A'}</td>
                                    <td>          
                                        ${invoiceParts[1] ?  
                                            `<a href="${base_url}/taxinv/printtaxinv?orderid=${invoiceParts[1]}" target="_blank">
                                                ------${isReceipt ? displayIndex : invoiceParts[0]}
                                            </a>` : (isReceipt ? displayIndex : rowIndex)}
                                    </td>
                                    <td>${item.formatted_credit || '0.00'}</td>
                                    <td>${item.formatted_debit || '0.00'}</td>
                                    <td>${subtotal.toFixed(2)}</td>
                                </tr>
                            `);

                            rowIndex++; // Always increment for table row numbering
                        });

                      }
                    } else if(u_type === 1)
                      {
                        // Process Ledger Transactions
                       if (response.ledger.length > 0) {
                        $.each(response.ledger, function (index, item) {
                            var invoiceParts = item.invoice_details ? item.invoice_details.split("+") : ["0.00", ""];

                            // Parse values
                            credit = parseFloat(item.credit) || 0;
                            debit = parseFloat(item.debit) || 0;

                            // Accumulate totals
                            totalcredit += credit;
                            totaldebit += debit;

                            console.log("Total Credit:", totalcredit);
                            console.log("Total Debit:", totaldebit);
                            console.log("Closing Balance", totalcredit-totaldebit);

                            // Update subtotal correctly
                            subtotal = totaldebit - totalcredit;

                            // Check if it's a receipt
                            let isReceipt = item.voucher_type === "Receipt";

                            // Assign the correct index
                            let displayIndex = rowIndex;
                            if (isReceipt) {
                                displayIndex = receiptIndex; // Use receipt index for receipts
                                receiptIndex++; // Increment only for receipts
                            }

                            tableBody.append(`
                                <tr>
                                    <td>${rowIndex}</td> <!-- Always increments for all rows -->
                                    <td>${item.created || 'N/A'}</td>
                                    <td>${item.voucher_type || 'N/A'}</td>
                                    <td>          
                                        ${invoiceParts[1] ?  
                                            `<a href="${base_url}/purchaseinv/printpurchaseinv?orderid=${invoiceParts[1]}" target="_blank">
                                                ------${isReceipt ? displayIndex : invoiceParts[0]}
                                            </a>` : (isReceipt ? displayIndex : rowIndex)}
                                    </td>
                                    <td>${item.formatted_credit || '0.00'}</td>
                                    <td>${item.formatted_debit || '0.00'}</td>
                                    <td>${subtotal.toFixed(2)}</td>
                                </tr>
                            `);

                            rowIndex++; // Always increment for table row numbering
                        });
                      }
                    }
                    else if(u_type===2)
                    {
                        // Process Ledger Transactions
                       if (response.ledger.length > 0) {
                        $.each(response.ledger, function (index, item) {
                            var invoiceParts = item.invoice_details ? item.invoice_details.split("+") : ["0.00", ""];

                            // Parse values
                            credit = parseFloat(item.credit) || 0.00;
                            debit = parseFloat(item.debit) || 0.00;

                                                        // Adjust logic for Supplier (invert logic)
                              if (item.voucher_type === "Purchase") {
                                  totaldebit += debit;
                              } else if (item.voucher_type === "Sales") {
                                  totalcredit += credit;
                              } else if (item.voucher_type === "Receipt") {
                                  totalcredit += credit;
                              }


                           console.log("Total Credit:", totalcredit);
                            console.log("Total Debit:", totaldebit);
                            console.log("Closing Balance", totaldebit-totalcredit);
                            // Update subtotal correctly
                            //subtotal = totaldebit - totalcredit;
                            //if()
                            subtotal = totaldebit - totalcredit;

                            // Check if it's a receipt
                            let isReceipt = item.voucher_type === "Receipt";

                            // Assign the correct index
                            let displayIndex = rowIndex;
                            if (isReceipt) {
                                displayIndex = receiptIndex; // Use receipt index for receipts
                                receiptIndex++; // Increment only for receipts
                            }

                            tableBody.append(`
                                <tr>
                                    <td>${rowIndex}</td> <!-- Always increments for all rows -->
                                    <td>${item.created || 'N/A'}</td>
                                    <td>${item.voucher_type || 'N/A'}</td>
                                    <td>          
                                        ${invoiceParts[1] ?  
                                            `<a href="${base_url}/${item.voucher_type === 'Sales' ? 'taxinv/printtaxinv' : 'purchaseinv/printpurchaseinv'}?orderid=${invoiceParts[1]}" target="_blank">
                                                ------${isReceipt ? displayIndex : invoiceParts[0]}
                                            </a>` : (isReceipt ? displayIndex : rowIndex)}
                                    </td>

                                    <td>${item.formatted_credit || '0.00'}</td>
                                    <td>${item.formatted_debit || '0.00'}</td>
                                    <td>${subtotal.toFixed(2)}</td>
                                </tr>
                            `);

                            rowIndex++; // Always increment for table row numbering
                        });
                      }
                    } 

                        $("#totalcreditamt").text(totalcredit.toFixed(2));
                        $("#totaldebitamt").text(totaldebit.toFixed(2));
                        $("#totalclosingamt").text(subtotal.toFixed(2));

                    //    else {
                    //     tableBody.append('<tr><td colspan="6">No records found.</td></tr>');
                    // }

                    
                },
                error: function (xhr, status, error) {
                            console.error("Detailed Error:", {
            status: xhr.status,
            statusText: xhr.statusText,
            responseText: xhr.responseText
        });
                }
            });
        }
    });
//});


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



    $('.select2').select2({ placeholder: "Select a Client", allowClear: true });
    $('#ctype').select2({ placeholder: "Select Bank", allowClear: true });
    //$('.select234').select2({ placeholder: "Select Type", allowClear: true });

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
    // if ($('#co').val().trim() === '') {
    //     $('#co_error').text('Company name is required.');
    //     $('#co').addClass('is-invalid'); // Highlight the field
    //     isValid = false;
    // }

    // Validate Address
    if ($('#purpose').val().trim() === '') {
        $('#purpose_error').text('Purpose is required.');
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
        $('#dtp_error').text('Date Of Payment is required.');
        $('#datepicker').addClass('is-invalid'); // Highlight the field
        isValid = false;
    }

   if ($('#ctype').val() === '' || $('#ctype').val() === null) {
    $('#ctype_error').text('Bank name is required.');

    $('#ctype').next('.select2-container').find('.select2-selection').addClass('is-invalid');
    isValid = false;
} else {
    $('#ctype').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
}

// Second Select2
if ($('#co').val() === '' || $('#co').val() === null) {
  $('#co_error').text('Company name is required.');

    $('#co').next('.select2-container').find('.select2-selection').addClass('is-invalid');
    isValid = false;
} else {
    $('#co').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
}




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
                    text: "Transaction Data Inserted!",
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
