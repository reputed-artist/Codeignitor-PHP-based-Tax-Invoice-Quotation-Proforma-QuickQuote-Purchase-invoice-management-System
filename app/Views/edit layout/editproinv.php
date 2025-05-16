
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
.dropdown-menu{
  margin-top:10px;
  padding: 10px;
font-size:15px;
}

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


.has-error .select2-selection {
    border-color: rgb(185, 74, 72) !important;
    min-width: 100%;
    max-width: 100%;
}

input .error{
 border: 1px solid #f00;
}
  
.error{
 border: 1px solid #f00 !important;
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

.select2-container .select2-selection--single {
    height: 34px !important; /* Set the height of the Select2 input */
    line-height: 27px !important; /* Center the text vertically */
    font-size: 14px !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 27px !important; /* Align text properly */
    font-size: 14px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 27px !important; /* Match the height of the arrow to the input */
    font-size: 14px !important;
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
      Proforma Invoice Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Proforma Invoice</li>
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
              <h3 class="box-title">Edit Proforma Invoice</h3>
            </div>
          </br>
           <p align="center" style="color:#F00;"><?php 
                     //if(isset($_SESSION['msg']))
                     //{
                     //echo $_SESSION['msg']; } ?><?php //echo $_SESSION['msg']=""; ?></p>

                      <form class="form-horizontal style-form form" name="form" id="form"  method="post" action="<?= base_url();?>/purchaseinv/insert">
                           
                           <p style="color:#F00"><?php //echo $_SESSION['msg'];?><?php //echo $_SESSION['msg']="";?></p>
                         </br>
            <!-- /box-header -->
            <!-- form start -->
            
              <div class="box-body">
            
                
                <div class="form-group">
                  <label id="ccid" class="col-sm-2 control-label">Invoice ID</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="invid" id="invid" value="">
                    <div id="invid_error" style="color: red;"> </div>
                  </div>
                      <label id="c_addlbl1" class="col-sm-2 control-label">Client Name <span style="color: red;">*</span></label>
    
                    <div class="col-sm-4">
              <select name="supplier" id="supplier" class="form-control select2" onchange="showCustomer(this.value)" style="height:40px !important;width: 80%;border-radius:0px; ">
                                 <option></option>
                                  
                          </select>
                          <!-- <button type="button" id="btnplus" class="btn btn-success btn-sm " style="margin: 2px 2px 2px 2px;" onclick="window.location.href = 'add-supplier.php'";><span class="glyphicon glyphicon-plus"></span></button> --><br>
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
              <th width="20%">Description Name</th>
              <th width="10%">HSN <span style="color: red;">*</span></th> 
              <th width="5%">Qty <span style="color: red;">*</span></th>
              <th width="15%">Price <span style="color: red;">*</span></th>                
              <th width="25%">Total <span style="color: red;">*</span></th>
       <th><button type="button" name="add" id="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button></th>
      </tr>
      <tbody id="datarow">
      <!-- <tr>
        <td><input class="itemRow" type="checkbox"></td>
        <td><input type="text" name="item_code[]" id="productCode_1" value="1" class="form-control" autocomplete="off"></td>
        
        <td><select name="item_name[]" id="productName_1" class="form-control item_name" style="width: 100% !important;"
        onchange="showHsn(1,this.value)">
          <option value="">Select Item</option>
          <?php //echo fill_unit_select_box($connect); ?></select>
        </td>
        
        <td><input type="text" name="item_desc[]" id="productDesc_1" class="form-control item_desc" ></td>
        <td><input type="text" name="hsn[]" id="hsn_1" value="8443" class="form-control item_hsn" ></td>
        <td><input type="number" name="item_quantity[]" id="quantity_1" min="1" value="1" oninput="validity.valid||(value='');" class="form-control quantity" ></td>
        
        <td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
         
              <td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
             
              <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>
  </tr> -->
  </tbody>
     </table>
  
              </div>
</br></br></br>

      <div class="row"> 
        <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8" style="padding-left: 50px;">
          <h3>Notes: </h3>
          <div class="form-group">
            <textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Your Notes"></textarea>
          </div>
          <br>

          <div class="form-group">
            <input type="hidden" value="<?php //echo $_SESSION['userid']; ?>" class="form-control" name="userId">
            <input data-loading-text="Saving Invoice..." type="submit" name="submit" id="submitbtn" style="width: 15em;  height: 3em; font-size:20px; " class="btn btn-success submit_btn invoice-save-btm">           
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
              <label>Tax Amount<span style="color: red;">*</span></label>
              <div class="input-group col-sm-10">
                <div class="input-group-addon currency"><i class="fa fa-fw fa-inr"></i></div>
                <input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount">
              </div>
            </div>              
            <div class="form-group">
              <label>Total<span style="color: red;">*</span></label>
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
 

<!-- <script>
  $(function () {
    //Initialize Select2 Elements
    

  });
</script> -->
<script type="text/javascript">
    var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>

<script >

  $(document).ready(function () {
    var count = 0; // Initialize row counter

     $("#datepicker").datepicker({
        format: "dd-mm-yyyy",
        language: "fr",
        changeMonth: true,
        changeYear: true,
        autoclose: true
    });


    // Function to load products into dropdown and pre-select an item

$('.select2').select2({
    placeholder: "Select a Person or Company",
    allowClear: true,
    ajax: {
        url: base_url + "/proinv/getclient",
        type: "GET",
        dataType: "json",
        delay: 250, // Delay to improve performance
        data: function (params) {
            return {
                category_name: params.term || '' // params.term is the search term
            };
        },
        processResults: function (data) {
            console.log(data); // Debug response
            return {
                results: data
            };
        },
        cache: true
    }
});

// Handle supplier selection and populate address
$('#supplier').on('select2:select', function (e) {
    var supplierData = e.params.data;
    $("#c_add").val(supplierData.c_add); // Populate address field
    console.log("Supplier Address:", supplierData.c_add);
});

 window.showCustomer = function showCustomer(str) {
    if (str === "") {
        $("#c_add").html("");
        return;
    }

    $.ajax({
        url: base_url + "/proinv/getclient", // Controller method
        type: "GET",
        data: { q: str }, // Pass data as object
        dataType: "html",
        success: function (response) {
            $("#c_add").html(response); // Set the address field
        },
        error: function (xhr, status, error) {
            console.log("Error fetching customer data:", error);
        }
    });
};

    function showProduct(rowId, selectedItemName = "") {
        $.ajax({
            url: base_url + "/proinv/getproducts",
            type: "GET",
            dataType: "json",
            success: function (response) {
                var $productDropdown = $('#productName_' + rowId);

                // Clear existing options and add a default option
                $productDropdown.empty();
                $productDropdown.append('<option value="">Select Item</option>');

                // Add all products to the dropdown and pre-select the item
                response.forEach(function (item) {
                    var isSelected = item.name === selectedItemName ? "selected" : "";
                    $productDropdown.append(`<option value="${item.name}" ${isSelected}>${item.name}</option>`);
                });

                // Reinitialize Select2 for dynamically created dropdown
                $productDropdown.select2({
                    placeholder: "Select a Product",
                    allowClear: true
                });
            },
            error: function (xhr, status, error) {
                console.error("Error fetching items: " + error);
            }
        });
    }

    function loadQuoteDetails(orderId) {
    $.ajax({
        url: base_url + "/proinv/editproinv/" + orderId,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log("EditQuote Response:", response);

            var $dataRowContainer = $("#datarow");
            $dataRowContainer.empty(); // Clear existing rows

            // Populate rows from response
            response.records.forEach(function (record, index) {
                count++; // Increment count for unique IDs
                var rowHtml = `
    <tr class="datarow">
    <td><input class="itemRow" type="checkbox"></td>
    <td><input type="text" name="item_code[]" id="productCode_${count}" 
               value="${record?.item_code || count}" class="form-control" autocomplete="off">
    </td>
    <td><select name="item_name[]" id="productName_${count}" 
                class="form-control item_name select2" style="width:100%;" 
                onchange="showHsn(${count}, this.value)">
            <option value="">Loading...</option>
        </select>
    </td>
    <td><input type="text" name="item_desc[]" id="descName_${count}" 
               class="form-control item_desc" value="${record.item_desc || ''}" />
    </td>
    <td><input type="text" name="hsn[]" id="hsn_${count}" 
               value="8443" class="form-control item_hsn" />
    </td>
    <td><input type="number" name="item_quantity[]" id="quantity_${count}" 
               min="1" value="${record?.quantity || 1}" class="form-control item_quantity">
    </td>
    <td><input type="number" name="price[]" id="price_${count}" 
               value="${record?.price || ''}" class="form-control price" autocomplete="off">
    </td>
    <td><input type="number" name="total[]" id="total_${count}" value="${record.total || ''}" class="form-control total" autocomplete="off"></td>
    <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>
                </tr>`;
                $dataRowContainer.append(rowHtml); // Append new row
                showProduct(count, record.item_name); // Populate dropdown
            });

            // Populate invoice-level details
            if (response.records2.length > 0) {
                var record2 = response.records2[0];
                $("#invid").val(record2.invid);

                // Pre-select supplier in Select2
                var supplierOption = new Option(record2.c_name, record2.cid, true, true); // Create new option
                $("#supplier").append(supplierOption).trigger("change"); // Add to Select2 and trigger change
                

                // Populate supplier address
                $("#c_add").val(record2.c_add);


                console.log(record2.created);

                
                function formatDate(inputDate) {
                      // Split the date into parts
                      const dateParts = inputDate.split("-");
                      // Rearrange the parts to dd-mm-yyyy
                      return `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                  }

                  // Example Usage
                  const formattedDate = formatDate(record2.created);
                  console.log(formattedDate); // Output: 10-01-2025

                  //$('#datepicker').val(formattedDate);
                   $("#datepicker").datepicker("setDate", formattedDate);


                $("#subTotal").val(record2.subtotal);
                $("#taxRate").val(record2.taxrate);
                $("#taxAmount").val(record2.taxamount);
                $("#totalAftertax").val(record2.totalamount);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error loading quote details:", error);
        }
    });
}


    // Event: Add a new row
    $(document).on('click', '.add', function () {
        count++; // Increment counter for unique IDs

        var html = '';
        html += '<tr class="datarow">';
        html += '<td><input class="itemRow" type="checkbox"></td>';
        html += '<td><input type="text" name="item_code[]" id="productCode_' + count + '" value="' + count + '" class="form-control" autocomplete="off"></td>';
        html +='<td><select name="item_name[]" id="productName_' + count + '" class="form-control select2 item_name" onchange="showHsn(' + count + ', this.value)" style="width:100% !important;"><option value="">Select Item</option></select></td>';

        html += '<td><input type="text" name="item_desc[]" id="descName_' + count + '" class="form-control item_desc" /></td>';
        html += '<td><input type="text" name="hsn[]" id="hsn_' + count + '" value="8443" class="form-control item_hsn" /></td>';
        html += '<td><input type="number" name="item_quantity[]" id="quantity_' + count + '" min="1" value="1" class="form-control item_quantity" /></td>';
        html += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price"  autocomplete="off"></td>';
        html += '<td><input type="number" name="total[]" id="total_' + count + '" class="form-control total" value="0" autocomplete="off"></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';

        $('#datarow').append(html);
        showProduct(count); // Populate the dropdown
    });



$(document).on('click', '.remove', function(){
      
        var removeButton = $(this);
        
        // If there's only one row, disable the remove button
        if (count === 1) {
          removeButton.prop('disabled', true);
          return;
        }

        $(this).closest('tr').remove();
        // If there are more than one rows, remove the current row
        removeButton.closest('tr').remove();
            count--;
     });

    $('#checkAll').prop('checked', false);
        calculateTotal();

     $(document).on('blur', "[id^=quantity_]", function(){
        calculateTotal();
      }); 
      $(document).on('blur', "[id^=price_]", function(){
        calculateTotal();
      }); 
      $(document).on('blur', "#taxRate", function(){    
        calculateTotal();
      }); 
      $(document).on('blur', "#amountPaid", function(){
        var amountPaid = $(this).val();
        var totalAftertax = $('#totalAftertax').val();  
        if(amountPaid && totalAftertax) {
          totalAftertax = totalAftertax-amountPaid;     
          $('#amountDue').val(totalAftertax);
        } else {
          $('#amountDue').val(totalAftertax);
        } 
      }); 
      
    function calculateTotal(){
      var totalAmount = 0; 
      $("[id^='price_']").each(function() {
        var id = $(this).attr('id');
        id = id.replace("price_",'');
        var price = $('#price_'+id).val();
        var quantity  = $('#quantity_'+id).val();
        if(!quantity) {
          quantity = 1;
        }
        var total = price*quantity;
        $('#total_'+id).val(parseFloat(total));
        totalAmount += total;     
      });

      $('#subTotal').val(parseFloat(totalAmount));  
      var taxRate = $("#taxRate").val();
      var subTotal = $('#subTotal').val();  
      
      if(subTotal) {
        var taxAmount = Math.ceil(subTotal*taxRate/100);
        $('#taxAmount').val(taxAmount);
            subTotal =Math.ceil(parseFloat(subTotal)+parseFloat(taxAmount));
        $('#totalAftertax').val(subTotal);    
        
        var amountPaid = $('#amountPaid').val();
        var totalAftertax = $('#totalAftertax').val();  
        if(amountPaid && totalAftertax) {
          totalAftertax = totalAftertax-amountPaid;     
          $('#amountDue').val(totalAftertax);
        } else {    
          $('#amountDue').val(subTotal);
        }
      }
    }    


    // Initialize editquote functionality
    var url = window.location.href;
    var orderId = url.substring(url.lastIndexOf('/') + 1); // Extract orderId
    if (orderId) {
        loadQuoteDetails(orderId); // Load details for the order
    }


window.showHsn = function showHsn(count, str) {
    // Check if a value is selected
    if (str == "") {
        return;
    }

    // Make AJAX request to get the HSN code for the selected product
    $.ajax({
        url: base_url + "/proinv/getproducthsn", // Update the controller and method
        type: "GET",
        data: { q: str }, // Pass the product ID as 'q'
        dataType: "json", // Expect JSON response from the server
        success: function(response) {
            // If the response contains the HSN code, update the corresponding HSN input field
            if (response.hsn) {
                $("#hsn_" + count).val(response.hsn); // Update the HSN field dynamically based on row count
            } else {
                // If no HSN code is found, clear the field
                $("#hsn_" + count).val('');
            }
        },
        error: function(xhr, status, error) {
            console.log("Error: " + error);
        }
    });
};



$("#form").submit(function(event) {
  
    event.preventDefault();

  var url = window.location.href;
  var urlParams = new URLSearchParams(window.location.search);
  var orderId = urlParams.get('orderid');  // Extract the orderid from the query string

        console.log("submit event");
        var formData = $(this).serialize();
            formData += '&orderid=' + orderId;

        console.log(orderId);

        //formData.append(orderId);

 //var formData = new FormData(document.getElementById("form"));

        //console.log(formData);

$(".error").removeClass("error");
$(".has-error").removeClass("has-error");

var hasError = false;

// Validate each row inside the table
$(".datarow").each(function() {
    var itemName = $(this).find(".item_name");
    var itemDesc=$(this).find(".item_desc");
    var hsnCode = $(this).find(".item_hsn");
    var quantity = $(this).find(".item_quantity");
    var price = $(this).find(".price");
    var total = $(this).find(".total");

    // Validate Select2 (Item Name)
    if (!itemName.val()) {
        itemName.next(".select2-container").find(".select2-selection").addClass("error"); // Fix for Select2
        hasError = true;
    }

    if (!hsnCode.val()) {
        hsnCode.addClass("error");
        hasError = true;
    }

    if (!quantity.val()) {
        quantity.addClass("error");
        hasError = true;
    }

    if (!price.val()) {
        price.addClass("error");
        hasError = true;
    }

    if (!total.val()) {
        total.addClass("error");
        hasError = true;
    }
});

// Validate supplier selection
var supplier = $("#supplier").val();
if (!supplier) {
    $("#supplier").next(".select2-container").find(".select2-selection").addClass("error"); // Fix for Select2
    $("#c_add").addClass("error");
    hasError = true;
}

// Validate tax rate input
var taxRate = $("#taxRate").val();
if (!taxRate) {
    $("#taxRate").addClass("error");
    hasError = true;
}

// Stop form submission if errors exist
if (hasError) {
    return;

}else{





        var itemNames = [];
        var itemDescs = [];
        var hsn = [];
        var quantities = [];
        var prices = [];
        var totals = [];

        $(".datarow").each(function() {
            itemNames.push($(this).find(".item_name").val());
            itemDescs.push($(this).find(".item_desc").val());
            hsn.push($(this).find(".item_hsn").val()); // Corrected from .hsn
            quantities.push($(this).find(".item_quantity").val());
            prices.push($(this).find(".price").val());
            totals.push($(this).find(".total").val());
        });

        console.log(formData);

        $.ajax({
            type: "POST",
            url: base_url + "/proinv/updateproinv/" + orderId,
            data:formData,
            dataType: 'json', 
            //contentType: false,           
            success: function(response) {
                // Handle success response here

                if (response.success) {

                    console.log(response.success);
                    $('.error').css('border','0px');
                    $('#message').html(response.message);
                    Swal.fire({
                    title: "Good!",
                    text: "Proforma Invoice Data Updated!",
                    icon: "success",
                    showConfirmButton: false, // Hide the OK button
                   timer: 3000, // Close the popup after 3 seconds (3000 milliseconds)
                  }).then(function() {

                 window.location.href = base_url+'/proinv/showprodata';
                 window.open('printproinv?orderid='+response.orderid, '_blank');

                  });
            }else {
                   //$('.error').html('');
               
                  $('.error').css('border','0px');

                  $.each(response.errors, function(field, errorMessage) {
                $('#' + field + '_error').removeClass('error');
            });

                   console.log(response.errors);
               $.each(response.errors, function(field, errorMessage) {
                $('#' + field + '_error').addClass('error').text(errorMessage);
            });
                }
            },

            error: function(xhr, status, error) {
                // Handle error here
                console.error(xhr.responseText);
            }
        });

        //event.preventDefault(); // Prevent default form submission
     
      }

    });

});

</script>


</body>
</html>
