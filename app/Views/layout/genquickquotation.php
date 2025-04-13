<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | General Form Elements</title>
   <link href="<?= base_url()?>/public/bower_components/intl-tel-input/build/css/intlTelInput.min.css" rel="stylesheet"/>

  <?= $this->include('include/links.php');?>



<script src="<?= base_url()?>/public/bower_components/intl-tel-input/build/js/intlTelInput.min.js"></script>


 <style>

    [class^='select2'] {
  border-radius: 0px !important;
  line-height: 25px !important;
    
}

.dropdown-menu{
  margin-top:300px;

}
.form-horizontal .has-feedback .form-control-feedback {
    right: 67px;
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
.input-group-addon {
  padding:11px 24px 6px 11px;
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
#phone,select, textarea {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    width: 100%;
    border: 1px solid #ccc;
        height: 30px;
}
/*.form-horizontal .has-feedback .form-control-feedback {
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
    font-size: 15px !important;
}

body .iti .country-list {
  width: 100%;
  top: 100%;
}
.iti__country-list {
  width:1250%;
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
.swal2-popup {
    width: 500px; /* Adjust the width as needed */
}

label {
    font-size: medium;
}
.swal2-confirm,
.swal2-cancel {

    padding: 10px 24px; /* Adjust padding to increase button size */
    /*font-size: 30px;*/ /* Adjust font size if needed */

}
.swal2-confirm{
    background-color:#14A44D !important;
    /*font-size: medium;*/
    font-size: 15px !important;
}
.swal2-cancel{
    background-color: #DC4C64 !important;
    font-size: 15px !important;
}
.swal2-validation-message {
  font-size: 20px;
  color:red;

}

.phone{
  font-size: 15px !important;
}

.iti__selected-flag{
  font-size: 15px !important;
}

.swal2-title{
  font-size: 25px !important;
}



  </style>


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="loader"></div>
<div class="wrapper">

<?= $this->include('include/header.php');?>

    
<?= $this->include('include/sidebar.php');?> 


  <div class="content-wrapper">
    
    <section class="content-header">
      <h1>
      Quick Quotation
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Quick Quotation</li>
      </ol>
    </section>


    
    <section class="content">
      <div class="row" id="product_selection">

       
      </div>
      
    </section>

  </div>
 
<?= $this->include('include/footer.php');?>
<?= $this->include('include/settings.php');?>
 



<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
       placeholder: "Select a Person or Company",
    allowClear: true
    });

  });

  var base_url = "<?= base_url(); ?>";
</script>

<script>

$(document).ready(function () {
    // Make an AJAX request to quickquote/index on page load
    $.ajax({
        url: "quickquote/index", // Update the URL if needed
        type: "GET",
        dataType: "json", // Assuming the response is JSON
        success: function (response) {
            if (response && response.data) {
                populateProducts(response.data);
            } else {
                console.error("No data received");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
});

// Function to dynamically populate products
function populateProducts(products) {
    let productSelection = $("#product_selection");
    productSelection.empty(); // Clear any existing content

    products.forEach(product => {
        let productHTML = `
        <div class="col-md-3">
        
          <div class="box box-info">         
           
              <form class="form-horizontal style-form" name="form" id="form" method="post" action=""> </br>
                           
                  <div class="form-group center" id="product_selection">
           
                      <a class="product-link" data-product-id="${product.p_id}">
                          <img src="${product.img_loc}" height="250px" width="300px" class="col-md-12" />
                      </a>
                      <p style="font-size: 15px; text-align:center">
                          <b>${product.name}</b>
                      </p>

                  </div>

              </form>

          </div> 

      </div>         

        `;
        productSelection.append(productHTML);
    });
}

var cnt=0;
$(document).on('click', '#product_selection', function() {
    cnt++; 
    var productLinks = $('.product-link');
    productLinks.each(function() {
        $(this).on('click', function() {
            var productId = $(this).data('product-id');
            console.log(productId);
           

calculateTotal();

 $(document).on('blur', "#quantity, #price, #gst", function(){
      calculateTotal();
      });

// Call calculateTotal initially to calculate and display the total
function calculateTotal() {
    // Retrieve form values
    const quantity = parseFloat($("#quantity").val());
    const price = parseFloat($("#price").val());
    const gst = 18;

    const subtotal=parseFloat($("#subtotal").val());


    const subval=quantity*price;

    // Calculate total
    const total = quantity * price * (1 + gst / 100);
    console.log("total",total.toFixed(0));


    const gstamt=total-subtotal;

     $("#gst").val(gstamt.toFixed(0)); 

    // Display total using jQuery
    $("#subtotal").val(subval.toFixed(0));
    $("#total").val(total.toFixed(0));
}
//

Swal.fire({
    title: 'Quick Quote',
    html: `
 <div class="box-body col-md-12" style="padding-left:0px !important;">
  <table class="table table-bordered">
   


    <tr>
      <td class="col-sm-4"><label for="phone">Mobile</label></td>
      <td class="col-sm-8">
        <input id="phone" class="phone form-control" type="tel" name="phone" 
               value="<?php //if(isset($_POST['fullno'])) { echo $_POST['fullno']; } ?>" />
        <input id="fullno" class="phone" type="hidden" name="fullno" 
               value="<?php //if(isset($_POST['fullno'])) { echo $_POST['fullno']; } ?>" />
        <div id="mob_error" style="color: red;"></div>
      </td>
    </tr>
  
    <tr>
      <td><label for="quantity">Quantity</label></td>
      <td>
        <input type="number" class="form-control" name="quantity" id="quantity" 
               value="1" placeholder="Quantity" />
        <div id="mob_error" style="color: red;"></div>
      </td>
    </tr>
    
    <tr>
      <td><label for="price">Price</label></td>
      <td>
        <input type="number" class="form-control" name="price" id="price" 
               placeholder="Price" />
        <div id="mob_error" style="color: red;"></div>
      </td>
    </tr>

    <tr>
      <td><label for="subtotal">Sub-Total</label></td>
      <td>
        <input type="number" class="form-control" name="subtotal" id="subtotal" 
               placeholder="Subtotal" />
        <div id="mob_error" style="color: red;"></div>
      </td>
    </tr>
    
    <tr>
      <td><label for="gst">GST 18%</label></td>
      <td>
        <input type="number" class="form-control" name="gst" id="gst" 
               placeholder="GST Amt" />
        <div id="mob_error" style="color: red;"></div>
      </td>
    </tr>
    
    <tr>
      <td><label for="total">Total</label></td>
      <td>
        <input type="number" class="form-control" name="total" id="total" 
               placeholder="Total" />
        <div id="mob_error" style="color: red;"></div>
      </td>
    </tr>
  </table>
</div>
  `,
                      showCancelButton: true,
                      confirmButtonText: 'Submit',
                      cancelButtonText: 'Cancel',
                      focusConfirm: false,
                      preConfirm: () => {
                       

                          // Retrieve form values
                          //const q_id = $("#q_id").val();
                          const mobileNumber = $("#phone").val();
                          console.log(mobileNumber);
                          const quantity = $("#quantity").val();
                          console.log(quantity);
                          const price = $("#price").val();
                          console.log(price);
                          const subtotal = $("#subtotal").val();
                          console.log(subtotal);
                          const gst = $("#gst").val();
                          console.log(gst);
                          const total = $("#total").val();

                    
                          if (mobileNumber === "" || quantity === "" || price === "" || gst === "") {
                              Swal.showValidationMessage('All fields are required');
                          } else {
                              // Display total using jQuery
                               $("#total").val(calculateTotal());
                              

                                  const formData = {
                                    //q_id:q_id,
                                    productId:productId,
                                  mobileNumber: mobileNumber,
                                  quantity: quantity,
                                  price: price,
                                  subtotal:subtotal,
                                  gst: gst,
                                  total:total
                              };

                              // Submit form data via AJAX
                            $.ajax({
                                  url: base_url + "/quickquote/insertquickquote",
                                  type: "POST",
                                  data: formData,
                                  success: function(response) {
                                      console.log("Server Response:", response);
                                      if (response.success) {
                                          Swal.fire('Success', response.message+ " " + response.q_id, 'success');
                                          //window.location(base_url+encodeURIComponent(response.q_id));
                                        window.open(base_url + "/quickquote/printquickquote?qid=" + encodeURIComponent(response.q_id), "_blank");


                                      } else {
                                          Swal.fire('Error', response.message, 'error');
                                      }
                                  },
                                  error: function(xhr, status, error) {
                                      console.error("AJAX Error:", xhr.responseText); // Log error details
                                      Swal.fire('Error', 'An error occurred: ' + error, 'error');
                                  }
                              });

                          }
                      }
                  });
                          
                        
      
              var input = document.querySelector("#phone");
              var iti;

              iti=window.intlTelInput(input, {
                  hiddenInput: "full_number",
                  nationalMode: false,
                  formatOnDisplay: true,
                  separateDialCode: true,
                  autoHideDialCode: true,
                  autoPlaceholder: "aggressive",
                  initialCountry: "in",
                  placeholderNumberType: "MOBILE",
                  preferredCountries: ['in', 'np'],
                  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.js"
              });

        });     
    }); 
}); 


    </script>

    </body>
</html>