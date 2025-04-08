
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
  <?= $this->include('include/links.php');?>
  <style>

    [class^='select2'] {
  border-radius: 0px !important;
  line-height: 25px !important;
    
}
/*.dropdown-menu{
  margin-top:10px;
  padding: 10px;
font-size:15px;
}*/

.form-horizontal .has-feedback .form-control-feedback {
    right: 67px;
}
body {
  font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
}
.btn{
  display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
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


/*.has-error .select2-selection {
    border-color: rgb(185, 74, 72) !important;
    min-width: 100%;
    max-width: 100%;
}*/
.has-error .select2-selection {
    border: 1px solid rgb(185, 74, 72) !important;
}

input .error{
 border: 1px solid #f00;
}
  
.error{
 border: 1px solid #f00;
}
.input-group-addon {
  padding:11px 24px 6px 11px;
}

/* Ensure there's enough space for the dropdown to open */
/*form {
    overflow: visible !important;
}

td, tr {
    position: relative;
    overflow: visible !important;
}*/
select {
  position: relative;
  z-index: 1;
}

.parent-container {
  overflow: visible !important;
}



.has-error .select2-selection {
    border-color: rgb(185, 74, 72) !important;
    min-width: 100%;
    max-width: 100%;
}

input .error{
 border: 1px solid #f00;
}
  
.error {
    border: 1px solid #f00 !important;
}

.input-group-addon {
  padding:11px 24px 6px 11px;
}

div:where(.swal2-container) div:where(.swal2-popup){
  width:50em !important;
}  

.swal2-confirm{
  background-color:#14A44D !important;
}
.swal2-title{
  padding-top: 30px;
  font-size: 20px !important;
}
.swal2-cancel{
    background-color: #DC4C64 !important;
}
.swal2-cancel,.swal2-confirm
{font-size: 15px !important;}
  
/*label{
  font-size: 15px!important;
}*/
.dropdown-menu{
  margin-top:10px;
  padding: 10px;
font-size:15px;
}

  </style>

<!-- <script type="text/javascript">
        var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
    </script>
    <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/genpurchaseinv.js"></script>
 -->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="loader"></div>
<div class="wrapper">

<?= $this->include('include/header.php');?>


  <?= $this->include('include/sidebar.php');?>
  <!-- Content Wrapper. Contains page content -->
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Tax Invoice Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Generate Tax Invoice</li>
      </ol>
    </section>

 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Generate Tax Invoice</h3>
            </div>
          </br>
           <p align="center" style="color:#F00;"></p>

                      <form class="form-horizontal style-form form" name="form" id="form"  method="post" action="<?= base_url();?>/Taxinv/insert">
                           
                           <p style="color:#F00"></p>
                         </br>

              <div class="box-body">
            
                
                <div class="form-group">
                  <label id="ccid" class="col-sm-2 control-label">Invoice ID</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="invid" id="invid" value="<?= esc($invoice_id); ?>">
                    <div id="invid_error" style="color: red;"> </div>
                  </div>
                      <label id="c_addlbl1" class="col-sm-2 control-label">Client Name <span style="color: red;">*</span></label>
    
                    <div class="col-sm-4">
              <select name="supplier" id="supplier" class="form-control select2" onchange="showCustomer(this.value)" style="height:40px !important;width: 80%;border-radius:0px; ">
                                 <option></option>
                                  
                          </select>
                        <!--   <button type="button" id="btnplus" class="btn btn-success btn-sm " style="margin: 2px 2px 2px 2px;" onclick="window.location.href = 'add-supplier.php'";><span class="glyphicon glyphicon-plus"></span></button> --><br>
                                   <div id="supplier_error" style="color: red; width: 80%"> </div>
                </div>
                </div>

                <div class="form-group">
                  <label id="c_name" class="col-sm-2 control-label">Invoice Date</label>
                  <div class="col-sm-3">

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="datepicker" class="form-control pull-right" id="datepicker" value="<?php echo date('d-m-Y'); ?>">
                                        <div id="date_error"> </div>
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

                  

                  <label id="c_addlbl" class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-4">
                   <textarea class="form-control" rows="3" id="c_add" name="c_add"></textarea>

                </div>

                </div>

<!-- <hr> --> </br>
                <div class="form-group col-sm-12 col-md-12" style="margin-left: 3px;">
                  
                  <table class="table table-bordered" id="item_table">
      <tr>
        <th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
              <th width="8%">Item No</th>
              <th width="25%">Item Name <span style="color: red;">*</span></th>
              <th width="20%">Description Name </th>
              <th width="10%">HSN <span style="color: red;">*</span></th> 
              <th width="5%">Qty <span style="color: red;">*</span></th>
              <th width="15%">Price <span style="color: red;">*</span></th>                
              <th width="25%">Total <span style="color: red;">*</span></th>
       <th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button></th>
      </tr>
      <tr class="datarow">
        <td><input class="itemRow" type="checkbox"></td>
        <td><input type="text" name="item_code[]" id="productCode_1" value="1" class="form-control" autocomplete="off"></td>
        
        <td><select name="item_name[]" id="productName_1" class="form-control item_name" style=" width: 100% !important;"
                onchange="showHsn(1,this.value)">
                
          <option value="">Select Item</option>
          </select>
        </td>
        
        <td><input type="text" name="item_desc[]" id="productDesc_1" class="form-control item_desc" ></td>
        <td><input type="text" name="hsn[]" id="hsn_1" value="8443" class="form-control item_hsn" ></td>
        <td><input type="number" name="item_quantity[]" id="quantity_1" min="1" value="1" oninput="validity.valid||(value='');" class="form-control quantity" ></td>
        
        <td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
         
              <td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
             
              <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>
  </tr>
     </table>
  
              </div>
</br></br></br>

      <div class="row"> 
       <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8" style="padding-left: 50px;padding-right: 100px;">
          <h3>Notes: </h3>
          <div class="form-group">
            <textarea class="form-control txt" rows="7" cols="8" name="notes" id="notes" placeholder="Your Notes"></textarea>
          </div>
          <br>

          <div class="form-group">
            <input type="hidden" value="<?php //echo $_SESSION['userid']; ?>" class="form-control" name="userId">
            <input data-loading-text="Saving Invoice..." type="submit" name="submit" id="submitbtn" 
            style="width: 15em;  height: 3em; font-size:20px; " class="btn btn-success submit_btn invoice-save-btm">           
          </div>
          
        </div>
      </br></br></br>





        <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4" style="padding-left:50px; ">
      
            <div class="form-group">

              <label>Subtotal <span style="color: red;">*</span></label> 
            
              <div class="input-group col-sm-10">
                <div class="input-group-addon "><i class="fa fa-fw fa-inr"></i></div>
                <input value="" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
              </div>
            </div> 
            <div class="form-group">
              <label>Tax Rate <span style="color: red;">*</span></label>
          
              <div class="input-group col-sm-10">
                <input value="" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate">
                <div class="input-group-addon">%</div>

              </div>
              <div id="taxrate_error" style="color: red; width: 83%"> </div>
            </div>

            <div class="form-group">
              <label>Tax Amount <span style="color: red;">*</span></label>
              <div class="input-group col-sm-10">
                <div class="input-group-addon currency"><i class="fa fa-fw fa-inr"></i></div>
                <input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount">
              </div>
            </div>              
            <div class="form-group">
              <label>Total <span style="color: red;">*</span></label>
              <div class="input-group col-sm-10">
                <div class="input-group-addon currency"><i class="fa fa-fw fa-inr"></i></div>
                <input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
              </div>
            </div>

           <!--  <div class="form-group">
              <label>Amount Paid: &nbsp;</label>
              <div class="input-group">
                <div class="input-group-addon currency">$</div>
                <input value="" type="number" class="form-control" name="amountPaid" id="amountPaid" placeholder="Amount Paid">
              </div>
            </div>
            <div class="form-group">
              <label>Amount Due: &nbsp;</label>
              <div class="input-group">
                <div class="input-group-addon currency">$</div>
                <input value="" type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due">
              </div>
            </div>
 -->
          </form>

              <div class="form-group">
                  
              </div>
                              
<!-- Delivery Address Modal -->
<div id="deliveryAddressModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title col-md-8">Enter Delivery Address</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 40px;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="delivery_name">Name</label>
                        <input type="text" class="form-control" id="delivery_name">
                    </div>
                    <div class="form-group">
                        <label for="delivery_address">Address</label>
                        <textarea  id="delivery_address" class="form-control" rows="5"></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="delivery_mobile">Mobile</label>
                        <input type="text" class="form-control" id="delivery_mobile">
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveDeliveryAddress">Save</button>
            </div>
        </div>
    </div>
</div>



            
          </div>
            </div>            <!-- Form Element sizes -->
          
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
 
  <?= $this->include('include/settings.php');?>
    <?= $this->include('include/footer.php');?>
 

<script type="text/javascript">
    var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>


<script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/gentaxinv.js"></script>
</body>
</html>
