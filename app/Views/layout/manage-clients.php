<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link href="<?= base_url()?>/public/bower_components/intl-tel-input/build/css/intlTelInput.min.css" rel="stylesheet"/>

  <?= $this->include('include/links.php');?>

<!-- <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">   </script> -->

<script src="<?= base_url()?>/public/bower_components/intl-tel-input/build/js/intlTelInput.min.js"></script>



  <style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
    #phone,#phoneedit   {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    width: 100%;
    border: 1px solid #ccc;
        height: 34px;
}
/* {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    width: 100%;
    border: 1px solid #ccc;
        height: 34px;
}
*//*.form-horizontal .has-feedback .form-control-feedback {
    right: 57px;
}*/
  .iti {
  width: 100%;
  min-width: 100%;
    max-width: 100%;
}

.iti-flag {
  background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.2/img/flags.png");
}

body .intl-tel-input .flag-container {
  position: static;
  min-width: 100%;
    max-width: 100%;

}

body .intl-tel-input .selected-flag {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  height: 100%;
  min-width: 100%;
    max-width: 100%;
}

body .iti .country-list {
  width: 100%;
  top: 100%;
}
.iti__country-list {
  /*width:10%;*/
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

<div class="wrapper">
<?= $this->include('include/header.php');?>


  <?= $this->include('include/sidebar.php');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage-Clients
<!--         <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<!--         <li><a href="#">Tables</a></li> -->
        <li class="active">Manage-Clients</li>
      </ol>
    </section>

   <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-info" style="overflow: auto;">
            <div class="box-header">
              <h3 class="box-title" style="padding-top: 10px;"> All Client Details</h3>
            </div>
            <!-- /.box-header
                  onclick="window.location.href = 'add-client.php'";
             -->

             <button type="button" id="btnplus add" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#modal-default" style="margin: 2px 20px 2px 2px;" ><span class="glyphicon glyphicon-plus"></span>&nbsp; Add Client</button><br><br>


   
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Company name</th>
                  <th>Address</th>
                  <th>Mobile</th>

                  <th>GST No.</th>
                  <th>Email </th>
                  <th>Bill - Type</th>
                  <th>User - Type</th>
                  <th>Edit</th>
                  <th>View</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                              
                </tbody>
                <tfoot>
                <tr>
                  <th>Sr. No.</th>
                  <th>Company name</th>
                  <th>Address</th>
                  <th>Mobile</th>
                  <th>GST No.</th>
                  <th>Email </th>
                  <th>Bill - Type</th>
                  <th>User - Type</th>
                  <th>Edit</th>
                  <th>View</th>
                  <th>Delete</th>
                  <!-- <th>Action</th> -->
                </tr>
                </tfoot>
              </table>

                <div  class="btn-group" data-toggle="buttons" role="group">
                <input type="button" class="toggle-vis btn btn-primary" data-column="0" value="Sr. No.">
                <input type="button" class="toggle-vis btn btn-primary" data-column="1" value="Company Name">
                <input type="button" class="toggle-vis btn btn-primary" data-column="2" value="Address">
                <input type="button" class="toggle-vis btn btn-primary" data-column="3" value="Mob">
                <input type="button" class="toggle-vis btn btn-primary" data-column="4" value="Gst No.">
                <input type="button" class="toggle-vis btn btn-primary" data-column="5" value="Email">
                <input type="button" class="toggle-vis btn btn-primary" data-column="6" value="Bill-Type">
                <input type="button" class="toggle-vis btn btn-primary" data-column="7" value="User-Type">

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      

       <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Clients</h4>
              </div>
        
            <div class="modal-body">
                        
              <form class="form-horizontal style-form" name="form" id="form" method="post" action="<?=base_url()?>/client/insert">
                <p style="color:#F00"><?php //echo $_SESSION['msg'];?><?php //echo $_SESSION['msg']="";?></p>
                  
            <!-- /box-header -->
            <!-- form start -->
            
              <div class="box-body">  
                <div class="form-group">
                  <label id="cidlbl" class="col-sm-3 control-label">Client ID</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="cid" id="cid" required="required" value="<?= isset($next_cid) ? $next_cid : ''; ?>"  readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label id="cnamelbl" class="col-sm-3 control-label">Company Name <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="c_name"  value="<?php //if(isset($_POST['c_name'])){ echo $_POST['c_name'];} ?>" id="c_name" placeholder="Company Name">
                    <div id="c_name_error" style="color:red;"> </div>
                  </div>
                </div>

                <div class="form-group">
                  <label id="caddlbl" class="col-sm-3 control-label">Address <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="c_add" id="c_add" rows="4" 
                      placeholder="Address"><?php //if(isset($_POST['c_add'])){ echo $_POST['c_add'];} ?></textarea>
                                  <div id="c_add_error" style="color: red;"> </div>
                </div>
              </div>

              
              <div class="form-group">
                  <label id="emaillbl" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="email"  value="<?php //if(isset($_POST['c_name'])){ echo $_POST['c_name'];} ?>" id="email" placeholder="Email">
                    <div id="email_error" style="color:red;"> </div>
                  </div>
                </div>






                <div class="form-group has-danger">
                  <label id="mob" class="col-sm-3 control-label">Mobile <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                      <input id="phone" class="phone" type="tel" name="phone" value="<?php //if(isset($_POST['fullno'])){ echo $_POST['fullno'];} ?>" style="{min-width: 100%; max-width: 100%;}" />

                      <input id="fullno" class="phone" type="hidden" name="fullno" style="{min-width: 100%;
                      max-width: 100%;}" value="<?php //if(isset($_POST['fullno']))
                                                        //{ echo $_POST['fullno'];   } ?>" />
                      <br>
                      <span id="error-msg" class="hide"></span>
                      <div id="mob_error" style="color: red;"> </div>

                      <p id="result" name="result"></p> 
                    </div>       
                </div>


                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Select Country</label>
                    <div class="col-sm-8 col">
                      <select  id="address_country" name="address_country" class="form-control">
                  
                    </select>
                  
                   <input id="fulldetails" class="phone" type="hidden" name="fulldetails" style="{min-width: 100%;max-width: 100%;}" />
                  </div>
                </div>
                
                 <div class="form-group">
                  <label id="cgstlbl" class="col-sm-3 control-label">GST <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                      <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php //if(isset($_POST['gst'])){ echo $_POST['gst'];} ?>" id="gst" name="gst"  placeholder="GST / PAN or Adhaar">
                      <div id="gst_error" style="color: red;">  </div>
                    </div>
                  </div>


                 <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">Bill Type <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <select name="ctype" class="form-control select2" style=" height: 34px;width:100%" id="ctype">
                    <option value=""></option>
                    <option value="IGST">IGST</option>
                    <option value="Loc">Loc</option>

                   </select>
                    <div id="ctype_error" style="color: red;">  </div>
                </div>
              </div>


              <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">User Type <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <select name="utype" class="form-control select2" style=" height: 34px;width:100%" id="utype">
                    <option value=""></option>
                    <option value="0">Client</option>
                    <option value="1">Supplier</option>
                    <option value="2">Dual(Cust/Sup)</option>
                   </select>
                    <div id="utype_error" style="color: red;">  </div>
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
                    <h4 class="modal-title">Edit Clients</h4>
              </div>
            <div class="modal-body">
                        
              <form class="form-horizontal style-form" name="form1" id="form1" method="post" action="<?=base_url()?>/client/update">
                <p style="color:#F00"><?php //echo $_SESSION['msg'];?><?php //echo $_SESSION['msg']="";?></p>
                  
            <!-- /box-header -->
            <!-- form start -->
            
              <div class="box-body">  
                <div class="form-group">
                  <label id="cidlbl" class="col-sm-3 control-label">Client ID</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="cidedit" id="cidedit" required="required" readonly>
                    <input type="hidden" id="edit_id" name="edit_id" value="">

                  </div>
                </div>

                <div class="form-group">
                  <label id="cnamelbl" class="col-sm-3 control-label">Company Name <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="c_nameedit"  value="<?php //if(isset($_POST['c_name'])){ echo $_POST['c_name'];} ?>" id="c_nameedit" placeholder="Company Name">
                    <div id="c_name_error1" style="color:red;"> </div>
                  </div>
                </div>

                <div class="form-group">
                  <label id="caddlbl" class="col-sm-3 control-label">Address <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="c_addedit" id="c_addedit" rows="4" 
                      placeholder="Address"><?php //if(isset($_POST['c_add'])){ echo $_POST['c_add'];} ?></textarea>
                                  <div id="c_add_error1" style="color: red;"> </div>
                </div>
              </div>


               <div class="form-group">
                  <label id="emaillbl1" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="email1" id="email1" placeholder="Email">
                    <div id="email_error1" style="color:red;"> </div>
                  </div>
                </div>




             
                <div class="form-group has-danger">
                  <label id="mob" class="col-sm-3 control-label">Mobile <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                      <input id="phoneedit" class="phoneedit" type="tel" name="phoneedit" style="{min-width: 100%; max-width: 100%;}" />

                      <input id="fullno2" class="phone" type="hidden" name="fullno2" style="{min-width: 100%;
                      max-width: 100%;}" value="<?php //if(isset($_POST['fullno']))
                                                        //{ echo $_POST['fullno'];   } ?>" />
                      <br>
                      <span id="error-msg2" class="hide"></span>
                      <div id="mob_error1" style="color: red;"> </div>

                      <p id="result2" name="result2"></p> 
                    </div>       
                </div>


                <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Select Country</label>
                    <div class="col-sm-8 col">
                      <select  id="address_countryedit" name="address_countryedit" class="form-control">
                  <!-- <?php //if(isset($country) && isset($sp)){
                    ?> <option value="<?php //echo $sp; ?>"> <?php //echo $country; ?> </option>
                 <?php //} ?> -->
                    </select>
                  
                   <input id="fulldetails2" class="phone" type="hidden" name="fulldetails2" style="{min-width: 100%;max-width: 100%;}" />
                  </div>
                </div>
                
                 <div class="form-group">
                  <label id="cgstlbl" class="col-sm-3 control-label">GST <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                      <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php //if(isset($_POST['gst'])){ echo $_POST['gst'];} ?>" id="gstedit" name="gstedit"  placeholder="GST / PAN or Adhaar">
                      <div id="gst_error1" style="color: red;">  </div>
                    </div>
                  </div>


                 <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">Bill Type <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <select name="ctypeedit" class="form-control select2" style=" height: 34px;width:100%" id="ctypeedit">
                    <option value=""></option>
                    <option value="IGST">IGST</option>
                    <option value="Loc">Loc</option>

                   </select>
                      <div id="ctype_error1" style="color: red;">  </div>
                </div>
              </div>

              <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">User Type <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <select name="utype1" class="form-control select2" style=" height: 34px;width:100%" id="utype1">
                    <option value=""></option>
                    <option value="0">Client</option>
                    <option value="1">Supplier</option>
                    <option value="2">Dual(Cust/Sup)</option>
                   </select>
                    <div id="utype_error1" style="color: red;">  </div>
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
          </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                <input type="submit" class="btn btn-primary" value="Update changes" id="Update">
              </div>

          </div>
                    <!-- /.modal-content -->
        </div>

      </div>

    </section>
    <!-- /.content -->
  </div>
 
  <?= $this->include('include/footer.php');?>

  <?= $this->include('include/settings.php');?> 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- page script -->
<!-- <script>
  $(document).ready(function(){
      fetch();
  })

</script> -->
<script>
    var tableData = <?= $results; ?>  // JSON object for DataTables
    console.log(tableData);  // Check if the data is correctly passed
</script>

 <script type="text/javascript">
    var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>

  
  <script>
     
var input = document.querySelector("#phone"),
    errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"],
    result = document.querySelector("#result"),
    iti;

window.addEventListener("load", function () {
    var countryData = window.intlTelInputGlobals.getCountryData(),
        addressDropdown = document.querySelector("#address_country"),
        errorMsg = document.querySelector("#error-msg");

    // Initialize intl-tel-input
    iti = window.intlTelInput(input, {
        hiddenInput: "full_number",
        nationalMode: false,
        formatOnDisplay: true,
        separateDialCode: true,
        autoHideDialCode: true,
        autoPlaceholder: "aggressive",
        initialCountry: "in", // Default country
        placeholderNumberType: "MOBILE",
        preferredCountries: ['in', 'np'],
        utilsScript: "<?=base_url()?>/public/bower_components/intl-tel-input/build/js/utils.js",
    });

    input.addEventListener('countrychange', function() {
        let selectedCountry = iti.getSelectedCountryData();
        addressDropdown.value = selectedCountry.iso2;

        // Force "India" instead of "India (Bharat)"
        let countryName = selectedCountry.iso2 === "in" ? "India" : selectedCountry.name;
        $('#fulldetails').val(countryName);
    });

    // Populate country dropdown with corrected names
    for (var i = 0; i < countryData.length; i++) {
        var country = countryData[i];
        var optionNode = document.createElement("option");

        optionNode.setAttribute("data-city", country.name.replace(/(\(.+\))/g, ''));
        optionNode.value = country.iso2;

        // Force "India" instead of "India (Bharat)"
        let countryName = country.iso2 === "in" ? "India" : country.name;
        var textNode = document.createTextNode(countryName);

        optionNode.appendChild(textNode);
        addressDropdown.appendChild(optionNode);
    }

    // Set initial country correctly
    addressDropdown.value = iti.getSelectedCountryData().iso2;
    let initialCountryName = iti.getSelectedCountryData().iso2 === "in" ? "India" : iti.getSelectedCountryData().name;
    $('#fulldetails').val(initialCountryName);

    //     // Set initial dropdown values
    // let initialCountry = iti.getSelectedCountryData();
    // addressDropdown.value = initialCountry.iso2;
    // $('#fulldetails').val(initialCountry.name);

    function validatePhoneNumber() {
        resetValidationState();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                $(input).removeClass('form-control is-invalid').addClass('form-control is-valid');
                $('.iti').removeClass('is-invalid').addClass('is-valid');
                $("#submitbtn").attr('disabled', false);
            } else {
                $(input).addClass('form-control is-invalid');
                $('.iti').addClass('is-invalid');
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                $(errorMsg).show();
                $("#submitbtn").attr('disabled', true);
            }
        }
    }

    function resetValidationState() {
        $(input).removeClass('form-control is-invalid is-valid');
        $('.iti').removeClass('is-invalid is-valid');
        errorMsg.innerHTML = "";
        $(errorMsg).hide();
    }

    input.addEventListener('focus', function () {
        result.textContent = "";
    }, false);

    $(input).on("focusout", function () {
        var intlNumber = iti.getNumber();
        $("#fullno").val(intlNumber);
        console.log(intlNumber);
    });
});

// ✅ **Fix for Form Reset: Reinitialize intl-tel-input & Set Country**
$("#form").on("reset", function () {
    setTimeout(function () {
        iti.setCountry("in"); // Reset country to India (or your preferred default)
        $('#address_country').val("in").trigger('change'); // Update dropdown
        $('#fulldetails').val("India"); // Update hidden input
        $("#phone").val(""); // Clear phone number input
        console.log("IntlTelInput Reset to India 🇮🇳");
    }, 100);
});


input.addEventListener('countrychange', function () {
    let selectedCountry = iti.getSelectedCountryData();
    $('#address_country').val(selectedCountry.iso2);
    $('#fulldetails').val(selectedCountry.name.replace(/\s*\(.*\)/, '')); // Remove (Bharat)
});

// Select2 Initialization
$('#ctype').select2({
    placeholder: "Select Bill Type",
    allowClear: true
});

$('#utype').select2({
    placeholder: "Select User Type",
    allowClear: true
});

  </script>

 <script>
   var input2 = document.querySelector("#phoneedit"),
    errorMap2 = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"],
    result2 = document.querySelector("#result2");

var iti2;
window.addEventListener("load", function ($form, event) {
    var countryData2 = window.intlTelInputGlobals.getCountryData(),
        addressDropdown2 = document.querySelector("#address_countryedit"),
        errorMsg2 = document.querySelector("#error-msg2");

    iti2 = window.intlTelInput(input2, {
        hiddenInput: "full_number",
        nationalMode: false,
        formatOnDisplay: true,
        separateDialCode: true,
        autoHideDialCode: true,
        autoPlaceholder: "aggressive",
        initialCountry: "in",
        placeholderNumberType: "MOBILE",
        preferredCountries: ['in', 'np'],
        utilsScript: "<?=base_url()?>/public/bower_components/intl-tel-input/build/js/utils.js",
    });

    input2.addEventListener('keyup', function() {
        validatePhoneNumber2();
    });

    input2.addEventListener('change', resetValidationState2);
    input2.addEventListener('countrychange', function() {
        addressDropdown2.value = iti2.getSelectedCountryData().iso2.replace(/(\(.+\))/g, '');
        $('#fulldetails2').val(iti2.getSelectedCountryData().name.replace(/(\(.+\))/g, ''));
    });

    // Populate country dropdown
    for (var i = 0; i < countryData2.length; i++) {
        var country2 = countryData2[i];
        var optionNode = document.createElement("option");
        optionNode.setAttribute("data-city", country2.name.replace(/(\(.+\))/g, ''));
        optionNode.value = country2.iso2.replace(/(\(.+\))/g, '');
        var textNode = document.createTextNode(country2.name.replace(/(\(.+\))/g, ''));
        optionNode.appendChild(textNode);
        addressDropdown2.appendChild(optionNode);
    }

    addressDropdown2.value = iti2.getSelectedCountryData().iso2.replace(/(\(.+\))/g, '');
    $('#fulldetails2').val(iti2.getSelectedCountryData().name.replace(/(\(.+\))/g, ''));

    function validatePhoneNumber2() {
        resetValidationState2();
        if (input2.value.trim()) {
            if (iti2.isValidNumber()) {
                $(input2).removeClass('form-control is-invalid').addClass('form-control is-valid');
                $('.iti2').removeClass('is-invalid').addClass('is-valid'); // Change wrapper state
                $("#submitbtn").attr('disabled', false);
            } else {
                $(input2).addClass('form-control is-invalid');
                $('.iti2').addClass('is-invalid'); // Highlight the wrapper
                var errorCode2 = iti2.getValidationError();
                errorMsg2.innerHTML = errorMap2[errorCode2];
                $(errorMsg2).show();
                $("#submitbtn").attr('disabled', true);
            }
        }
    }

    function resetValidationState2() {
        $(input2).removeClass('form-control is-invalid').removeClass('form-control is-valid');
        $('.iti2').removeClass('is-invalid').removeClass('is-valid'); // Reset wrapper state
        errorMsg2.innerHTML = ""; // Clear error message
        $(errorMsg2).hide(); // Hide error message
    }

    input2.addEventListener('focus', function() {
        result2.textContent = "";
    }, false);

    $(input2).on("focusout", function() {
        var intlNumber2 = iti2.getNumber();
        $("#fullno2").val(intlNumber2);
        console.log(intlNumber2);
    });
});

$('#ctypeedit').select2({
    placeholder: "Select Bill Type",
    allowClear: true
});

$('#utype1').select2({
    placeholder: "Select User Type",
    allowClear: true
});

 </script>
  <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/client.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/getExportButtons.js"></script>
</body>
</html>
