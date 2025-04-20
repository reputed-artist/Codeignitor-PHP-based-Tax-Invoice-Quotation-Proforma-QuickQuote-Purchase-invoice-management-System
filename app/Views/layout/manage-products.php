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
  #uploadimg, #uploadimg1{
    margin-top: 20px;
    margin-bottom: 20px;

  }

  /*#uploadimg{
    margin-top: 20px;
    margin-bottom: 20px;

  }*/
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
        Manage-Products
<!--         <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<!--         <li><a href="#">Tables</a></li> -->
        <li class="active">Manage-Products</li>
      </ol>
    </section>

   <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-info" style="overflow: auto;">
            <div class="box-header">
              <h3 class="box-title" style="padding-top: 10px;"> All Product Details</h3>
            </div>
            <!-- /.box-header
                  onclick="window.location.href = 'add-client.php'";
             -->

             <button type="button" id="btnplus add" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#modal-default" style="margin: 2px 20px 2px 2px;" ><span class="glyphicon glyphicon-plus"></span>&nbsp; Add Product</button><br><br>


   
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Hsn</th>

                  <th>Product Type</th>
                  <th>Creation Date </th>
                  
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
                  <th>Name</th>
                  <th>Description</th>
                  <th>Hsn</th>

                  <th>Product Type</th>
                  <th>Creation Date </th>
                  
                  <th>Edit</th>
                  <th>View</th>
                  <th>Delete</th>
                  <!-- <th>Action</th> -->
                </tr>
                </tfoot>
              </table>

                <div  class="btn-group" data-toggle="buttons" role="group">
                <input type="button" class="toggle-vis btn btn-primary" data-column="0" value="Sr. No.">
                <input type="button" class="toggle-vis btn btn-primary" data-column="1" value="Name">
                <input type="button" class="toggle-vis btn btn-primary" data-column="2" value="Description">
                <input type="button" class="toggle-vis btn btn-primary" data-column="3" value="HSN">
                <input type="button" class="toggle-vis btn btn-primary" data-column="4" value="Product Type">
                <input type="button" class="toggle-vis btn btn-primary" data-column="5" value="Creation Date">
                

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      

       <div class="modal fade" id="modal-default">
          <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Product</h4>
              </div>
        
            
                       
            <div class="modal-body">

              <div class="row">
                  
                <div class="col-md-6">
                      
              <form class="form-horizontal style-form" name="form" id="form" method="post" action="<?=base_url()?>/product/insert">
                <p style="color:#F00"><?php //echo $_SESSION['msg'];?><?php //echo $_SESSION['msg']="";?></p>
                  
            <!-- /box-header -->
            <!-- form start -->
            
              <div class="box-body">  
                <div class="form-group">
                  <label id="cid" class="col-sm-3 control-label">Product Id</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="pid" id="pid" value="<?= isset($next_cid) ? $next_cid : ''; ?>"  readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label id="c_name" class="col-sm-3 control-label">Product Name <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="pname" name="pname" placeholder="Product Name">
                    <div id="pname_error" style="color: red;"> </div>
                  </div>
                </div>

                <div class="form-group">
                  <label id="c_add" class="col-sm-3 control-label">Description <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="pdesc" id="pdesc" placeholder="Description" rows="8" cols="5"></textarea>
                                  <div id="pdesc_error" style="color: red;"> </div>
                </div>
              </div>

              <div class="form-group">
                  <label id="c_add" class="col-sm-3 control-label">HSN Code<span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <input type="text" class="form-control" name="hsn" id="hsn"  placeholder="HSN Code">
                                  <div id="hsn_error" style="color: red;"> </div>
                </div>
              </div>

               <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">Product Type <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <select name="ptype" class="form-control select2" style=" height: 34px;width:100%" id="ptype">
                    <option value=""></option>
                    <option value="Machine">Machine</option>
                    <option value="Consumables">Consumables</option>
                    
                    <option value="Freight">Freight</option>
                     </select>
                                  <div id="ptype_error" style="color: red;">  </div>
                </div>
              </div>


                <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">Category</label>
                  <div class="col-sm-8">
                   <select name="cattype" class="form-control select2" style=" height: 34px;width:100%" id="cattype">
                    <option value=""></option>
                    <option value="Manual">Manual</option>
                    <option value="Semi-Automatic">Semi-Automatic</option>
                    
                    <option value="Automatic">Automatic</option>
                     </select>
                                  <div id="cattype_error" style="color: red;">  </div>
                </div>
              </div>




              <div class="form-group">
                  <label id="c_add" class="col-sm-3 control-label">Creation Date</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="created" value="<?php  $c=date("d-M-Y");
                                        echo $c; ?>" readonly/>
                </div>
              </div>


              </div>
              </form>
             </div>


<div class="row" style="margin-top: 5px">                
<div class="col-md-6">
    <form action="" method="post" id="imgform" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label id="ftype" class="col-sm-3 control-label" style="padding-top: 5px">File input</label>
            <div class="col-sm-8">
                <div class="input-group">
                    <div class="input-group-btn">
                        <label class="btn btn-primary" for="file_input">Choose File</label>
                        <input type="file" id="file_input" style="display:none;">
                    </div>
                    <input type="text" class="form-control" id="file_name" placeholder="No file chosen" readonly>
                </div>
                <div id="file_input_error" style="color: red;"></div>
            </div>
        </div>

        <div class="form-group mb-4"> <!-- Increased margin-bottom -->
            <label id="xftype" class="col-sm-3 control-label" style="padding-top: 20px"> Display uploaded Image:</label>
            <div class="col-sm-8">
                <img class="img-thumbnail" alt="Uploaded Image" id="uploadimg" src="<?= base_url(); ?>/public/dist/img/default.jpg"
                data-default="<?= base_url(); ?>/public/dist/img/default.jpg" height="200px" width="350px">
            </div>
        </div>

        <div class="form-group mb-4">
            <label id="techslbl" class="col-sm-3 control-label" style="padding-top: 5px">Technical Description</label>
            <div class="col-sm-8">
                <textarea class="form-control" name="techs" id="techs" placeholder="Technical Description" rows="6" cols="5"></textarea>
                <div id="techs_error" style="color: red;"> </div>
            </div>
        </div>

        
    </form>

              
              <br>
             
              
             

              </div> <!-- /.box-body --> 

            </div>

              <div class="modal-footer" style="padding-right: 40px">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                <input type="submit" class="btn btn-primary" value="Save changes" id="submit">
              </div>



             </div> 

          </div>
                    <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
     
     </div>       
</div>


         <div class="modal fade" id="modal-default1">
          <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Product</h4>
              </div>
            

            
            <div class="modal-body">

              
               <div class="row">
                  
                <div class="col-md-6">

                      
              <form class="form-horizontal style-form" name="form1" id="form1" method="post" action="<?=base_url()?>/product/update">
                <p style="color:#F00"><?php //echo $_SESSION['msg'];?><?php //echo $_SESSION['msg']="";?></p>
                  
            <!-- /box-header -->
            <!-- form start -->
            
              <div class="box-body">  
                <div class="form-group">
                  <label id="cid" class="col-sm-3 control-label">Product Id</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="pidedit" id="pidedit" value="<?= isset($next_cid) ? $next_cid : ''; ?>"  readonly>

                  </div>
                </div>

                <div class="form-group">
                  <label id="c_name" class="col-sm-3 control-label">Product Name <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="pnameedit" name="pnameedit" placeholder="Product Name">
                    <div id="pname_error1" style="color: red;"> </div>
                  </div>
                </div>

                <div class="form-group">
                  <label id="c_add" class="col-sm-3 control-label">Description <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="pdescedit" id="pdescedit" placeholder="Description" rows="5" cols="5"></textarea>
                                  <div id="pdesc_error1" style="color: red;"> </div>
                </div>
              </div>

              <div class="form-group">
                  <label id="c_add" class="col-sm-3 control-label">HSN Code<span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <input type="text" class="form-control" name="hsnedit" id="hsnedit"  placeholder="HSN Code">
                                  <div id="hsn_error1" style="color: red;"> </div>
                </div>
              </div>

               <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">Product Type <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                   <select name="ptypeedit" class="form-control select2" style=" height: 34px;width:100%" id="ptypeedit">
                    <option value=""></option>
                    <option value="Machine">Machine</option>
                    <option value="Consumables">Consumables</option>
                    
                    <option value="Freight">Freight</option>
                     </select>
                                  <div id="ptype_error1" style="color: red;">  </div>
                </div>
              </div>


              <div class="form-group">
                  <label id="type" class="col-sm-3 control-label">Category</label>
                  <div class="col-sm-8">
                   <select name="cattypeedit" class="form-control select2" style=" height: 34px;width:100%" id="cattypeedit">
                    <option value=""></option>
                    <option value="Manual">Manual</option>
                    <option value="Semi-Automatic">Semi-Automatic</option>
                    
                    <option value="Automatic">Automatic</option>
                     </select>
                                  <div id="cattype_error1" style="color: red;">  </div>
                </div>
              </div>

               <div class="form-group">
                  <label id="c_add" class="col-sm-3 control-label">Creation Date</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="created" value="<?php  $c=date("d-M-Y");
                                        echo $c; ?>" readonly/>
                </div>
              </div>


              </div>
                     </form>
              </div>


              <div class="row" style="margin-top: 20px">                
                 <div class="col-md-6">


               <form action="" method="post" id="imgform1" enctype="multipart/form-data">
                 <div class="form-group">
                  <label id="ftype" class="col-sm-3 control-label" style="padding-top: 5px" >File input</label>
                  <div class="col-sm-8">
                      <div class="input-group">
                          <div class="input-group-btn">
                              <label class="btn btn-primary" for="file_input1">Choose File</label>
                              <input type="file" id="file_input1" style="display:none;">
                          </div>
                          <input type="text" class="form-control" id="file_name1" placeholder="No file chosen" readonly>
                      </div>
                      <div id="file_input1_error" style="color: red;"></div>
                   </div>
                  </div>
                </form>
               

              

                
                <div class="form-group">
              <label id="xftype" class="col-sm-3 control-label" style="padding-top: 20px"> Display uploaded Image:</label>
              <div class="col-sm-8">
                

                    <img class="img-thumbnail" alt="Uploaded Image" id="uploadimg1" src="" height="200px" width="350px">
                </div>
                </div>


                <div class="form-group">
                  <label id="techslbl" class="col-sm-3 control-label" style="padding-top: 5px">Technical Description</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="techs1" id="techs1" placeholder="Technical Description" cols="6" rows="5"></textarea>
                                  <div id="techs_error" style="color: red;"> </div>
                </div>
              </div>
      

             


              <br>
      
              


              </div>
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
$('#ptype').select2({
    placeholder: "Select Product Type",
    allowClear: true
});
$('#cattype').select2({
    placeholder: "Select Product Category",
    allowClear: true
});
$('#cattypeedit').select2({
    placeholder: "Select Product Category",
    allowClear: true
});
$('#ptypeedit').select2({
    placeholder: "Select Product Type",
    allowClear: true
});

 </script>
  <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/product.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/getExportButtons.js"></script>
</body>
</html>
