$(document).ready(function() {
 

$('.select2').select2({
    placeholder: "Select a Person or Company",
    allowClear: true,
    //theme: 'bootstrap',
    tags: false,
    ajax: {
        url: base_url + "/quote/getclient",
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


    $('#supplier').on('select2:select', function(e) {
        var supplierData = e.params.data;
        $("#c_add").val(supplierData.c_add);
        console.log(supplierData.c_add)
    });

    $("#datepicker").datepicker({
        format: "dd-mm-yyyy",
        language: "fr",
        changeMonth: true,
        changeYear: true,
        autoclose: true
    });

    var final_total_amt = $('#final_total_amt').text();
    showProduct(1);
    var count = 1;
    var rowCount = $('#item_table tbody tr.datarow').length;

    $(document).on('click', '.add', function() {
        count++;
        rowCount++;
        var html = '';
        html += '<tr class="datarow">';
        html += '<td><input class="itemRow" type="checkbox"></td>';
        html += '<td><input type="text" name="item_code[]" id="productCode_' + count + '" value="' + count + '" class="form-control" autocomplete="off"></td>';
        html += '<td><select name="item_name[]" id="productName_' + count + '" class="form-control select2 item_name"  style="width:100% !important;"><option value="">Select Item</option></select></td>';
        // html += '<td><input type="text" name="item_desc[]" id="descName_' + count + '" class="form-control item_name" /></td>';
        // html += '<td><input type="text" name="hsn[]" id="hsn_' + count + '" value="8443" class="form-control item_hsn" /></td>';
        html += '<td><input type="number" name="item_quantity[]" id="quantity_' + count + '" min="1" value="1" class="form-control quantity" /></td>';
        html += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price" autocomplete="off"></td>';
        html += '<td><input type="number" name="total[]" id="total_' + count + '" class="form-control total" value="0" autocomplete="off"></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';

        $('#item_table').append(html);
        showProduct(count);
    });

   
    $(document).on('click', '.remove', function(){
      
      //count--;

        var removeButton = $(this);
        

        // If there's only one row, disable the remove button
        if (rowCount === 1) {
          removeButton.prop('disabled', true);
          return;
        }

        $(this).closest('tr').remove();
        // If there are more than one rows, remove the current row
        removeButton.closest('tr').remove();
            rowCount--;
     });

    $('#checkAll').prop('checked', false);
        calculateTotal();
      });


     // var productName = $('#productName_'+id).val();

     //    if(!'productName_'+id) {
     //      $(this).css({ 'background': 'red' });
     //    };


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


    function showProduct(rowId) {
        $.ajax({
            url: base_url +"/purchaseinv/getproducts",
            type: "GET",
            dataType: "json",
            success: function(response) {
                $('#productName_' + rowId).empty();
                $('#productName_' + rowId).append('<option value="">Select Item</option>');
                $.each(response, function(index, item) {
                    $('#productName_' + rowId).append('<option value="' + item.name + '">' + item.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching items: " + error);
            }
        });
    }

    window.showCustomer = function showCustomer(str) {
    if (str == "") {
        $("#c_add").html("");
        return;
    }

    $.ajax({
        url: base_url+"/Quote/getclient", // Update the controller and method
        type: "GET",
        data: { q: str }, // Pass data as an object
        dataType: "html", // Expect JSON response from the server
        success: function(response) {
            // If response is an HTML string, you can directly assign it
            $("#c_add").html(response); 
        },
        error: function(xhr, status, error) {
            console.log("Error: " + error);
        }
    });
  }


    // Attach event listener to the form submission
  $("#form").submit(function(event) {
  

  event.preventDefault();
        console.log("submit event");
        var formData = $(this).serialize();


$(".error").removeClass("error");
$(".has-error").removeClass("has-error");

var hasError = false;

// Validate each row inside the table
$(".datarow").each(function() {
    var itemName = $(this).find(".item_name"); // Select2 dropdown for items
    //var hsnCode = $(this).find(".item_hsn");
    var quantity = $(this).find(".quantity");
    var price = $(this).find(".price");
    var total = $(this).find(".total");

    // Validate Select2 (Item Name)
    if (!itemName.val()) {
        itemName.addClass("error"); // Fix for Select2
        hasError = true;
    }

    // if (!hsnCode.val()) {
    //     hsnCode.addClass("error");
    //     hasError = true;
    // }

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

 //var formData = new FormData(document.getElementById("form"));

        //console.log(formData);

        var itemNames = [];
        //var itemDescs = [];
        //var hsn = [];
        var quantities = [];
        var prices = [];
        var totals = [];

        $(".datarow").each(function() {
            itemNames.push($(this).find(".item_name").val());
            //itemDescs.push($(this).find(".item_desc").val());
            //hsn.push($(this).find(".item_hsn").val()); // Corrected from .hsn
            quantities.push($(this).find(".quantity").val());
            prices.push($(this).find(".price").val());
            totals.push($(this).find(".total").val());
        });

        console.log(formData);

        $.ajax({
            type: "POST",
            url: base_url + "/quote/insert",
            data: formData,
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
                    text: "Quotation Data Inserted!",
                    icon: "success",
                    showConfirmButton: false, // Hide the OK button
                   timer: 3000, // Close the popup after 3 seconds (3000 milliseconds)
                  }).then(function() {

                 window.location.href = base_url+'/quote/genquote';
                 window.open('printquote?orderid='+response.orderid, '_blank');

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

  
