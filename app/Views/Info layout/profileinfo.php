<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | User Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= $this->include('include/links.php');?>
  
    <script >
      $(document).ready(function () {
      
          //If image edit link is clicked
          $(".editLink").on('click', function(e){
              e.preventDefault();
              $("#fileInput:hidden").trigger('click');
          });
        
          //On select file to upload
          $("#fileInput").on('change', function(){
              var image = $('#fileInput').val();
              var img_ex = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
      
          var maxWidth = 160; // Max width for the image
          var maxHeight = 160;    // Max height for the image
          var ratio = 0;  // Used for aspect ratio
          var width = $(this).width();    // Current image width
          var height = $(this).height();  // Current image height
      
      
          // Check if the current width is larger than the max
          if(width > maxWidth){
              ratio = maxWidth / width;   // get ratio for scaling image
              $(this).css("width", maxWidth); // Set new width
              $(this).css("height", height * ratio);  // Scale height based on ratio
              height = height * ratio;    // Reset height to match scaled image
          }
      
          var width = $(this).width();    // Current image width
          var height = $(this).height();  // Current image height
      
      
          // Check if current height is larger than max
          if(height > maxHeight){
              ratio = maxHeight / height; // get ratio for scaling image
              $(this).css("height", maxHeight);   // Set new height
              $(this).css("width", width * ratio);    // Scale width based on ratio
              width = width * ratio;    // Reset width to match scaled image
          }
          
      
      console.log(width);
      console.log(height);
      
          //validate file type
              if(!img_ex.exec(image)){
                  alert('Please upload only .jpg/.jpeg/.png/.gif file.');
                  $('#fileInput').val('');
                  return false;
              }else{
                  console.log("enters else");
      
                  $('.uploadProcess').show();
                  $('#uploadForm').hide();
                  $( "#picUploadForm" ).submit();
              }
          });
      
      });
      
      //After completion of image upload process
function completeUpload(success, fileName) {
    if (success == 1) {
        // Add a timestamp to the image URL to prevent caching
        var timestamp = new Date().getTime();
        var newImageUrl = base_url + "/public/dist/img/uploads/" + fileName + "?t=" + timestamp;
        console.log('Image URL: ' + base_url + "/public/dist/img/uploads/" + fileName);

        // Update all image previews
        $('#imagePreview').attr("src", newImageUrl);
        $('#imagePreview2').attr("src", newImageUrl);
        $('#imagePreview3').attr("src", newImageUrl);
        $('#imagePreview4').attr("src", newImageUrl);
        $('#imagePreview5').attr("src", newImageUrl);

        $('#fileInput').attr("value", fileName);
        $('.uploadProcess').hide();
    } else {
        $('.uploadProcess').hide();
        alert('There was an error during file upload!');
    }
    return true;
}
      

    </script>      
    <script>
      $(document).ready(function () {
      
       $(".editLink2").on('click', function(e){
              e.preventDefault();
              $("#fileInput2:hidden").trigger('click');
          });
          
          //On select file to upload
          $("#fileInput2").on('change', function(){
              var image2 = $('#fileInput2').val();
              var img_ex2 = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
              
              
         console.log("fileinput2 working");
          var maxWidth = 160; // Max width for the image
          var maxHeight = 160;    // Max height for the image
          var ratio = 0;  // Used for aspect ratio
          var width = $(this).width();    // Current image width
          var height = $(this).height();  // Current image height
      
      
          // Check if the current width is larger than the max
          if(width > maxWidth){
              ratio = maxWidth / width;   // get ratio for scaling image
              $(this).css("width", maxWidth); // Set new width
              $(this).css("height", height * ratio);  // Scale height based on ratio
              height = height * ratio;    // Reset height to match scaled image
          }
      
          var width = $(this).width();    // Current image width
          var height = $(this).height();  // Current image height
      
      
          // Check if current height is larger than max
          if(height > maxHeight){
              ratio = maxHeight / height; // get ratio for scaling image
              $(this).css("height", maxHeight);   // Set new height
              $(this).css("width", width * ratio);    // Scale width based on ratio
              width = width * ratio;    // Reset width to match scaled image
          }
          
              //validate file type
              if(!img_ex2.exec(image2)){
                  alert('Please upload only .jpg/.jpeg/.png/.gif file.');
                  $('#fileInput2').val('');
                  return false;
              }else{
                  $('.uploadProcess2').show();
                  $('#uploadForm2').hide();
                  $( "#picUploadForm2" ).submit();
      
              }
          });  
      
      });
      
          function completeUploadz(success, fileName) {
          if(success == 1){
              $('#imagePreview6').attr("src", "");
              $('#imagePreview6').attr("src", fileName);
              
              $('#fileInput2').attr("value", fileName);
              $('.uploadProcess6').hide();
          }else{
              $('.uploadProcess6').hide();
              alert('There was an error during file upload 2!');
          }
          return true;
      }      
    </script>
  

  </head>
<body class="hold-transition skin-blue sidebar-mini" style="min-height: 100% !important">
<div class="wrapper">

    <?= $this->include('include/header.php');?>
    <?= $this->include('include/sidebar.php');?>


    <div class="content-wrapper" style="min-height: 100% !important">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User profile</li>
      </ol>
    </section>

<section class="content">
        <div class="row">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?= base_url();?>/public/dist/img/uploads/<?= $cozDetails->picture; ?>" 
                  style="height: 95px; width:95px;" id="imagePreview2" alt="User profile picture">

                <h3 class="profile-username text-center"><?= $cozDetails->name; ?></h3>
                <p class="text-muted text-center"><?= $cozDetails->profession; ?></p>
                <ul class="list-group list-group-unbordered">

                  <li class="list-group-item">
                    <b>Total Clients</b> <a class="pull-right"><?= isset($sm[0]['value']) ? $sm[0]['value'] : 0; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Products</b> <a class="pull-right"><?= isset($sm[3]['value']) ? $sm[3]['value'] : 0; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Sales</b> <a class="pull-right"><?= isset($sm[2]['value']) ? moneyFormatIndia($sm[2]['value']).".00" : 0; ?></a>
                  </li>
                    <li class="list-group-item">
                    <b>Purchases</b> <a class="pull-right"><?= isset($sm[1]['value']) ? moneyFormatIndia($sm[1]['value']).".00" : 0; ?></a>
                  </li>
                </ul>
                <!--    <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- About Me Box -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">About Me</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <strong><i class="fa fa-book margin-r-5"></i> Education</strong>
                <p class="text-muted">
                  <?= $cozDetails->qualification; ?>
                </p>
                <hr>
                <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                <p class="text-muted"><?= $cozDetails->location; ?></p>
                <hr>
                <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
                <p>
                  <span class="label label-danger">UI Design</span>
                  <span class="label label-success">Coding</span>
                  <span class="label label-info">C</span>
                  <span class="label label-warning">PHP</span>
                  <span class="label label-primary">Python</span>

                  <span class="label label-danger">Java</span>
                  <span class="label label-success">Ajax</span>
                  <span class="label label-info">Jquery</span>
                  <span class="label label-warning">C++</span>
                  <span class="label label-primary">ML</span>

                  <span class="label label-danger">Drawing</span>
                  <span class="label label-success">Networking</span>
                  
                  <span class="label label-warning">Blender</span>
                  <span class="label label-primary">R</span>
                  <span class="label label-danger">C#</span>
                  <span class="label label-info">Full stack development</span>

                  <span class="label label-danger">Photoshop</span>
                  <span class="label label-success">AE</span>
                  <span class="label label-info">Mysql</span>
                  <span class="label label-warning">Django</span>
                  <span class="label label-primary">Embedded Programming</span>
                </p>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- / col-md-3 finished -->
          <!-- /.col -->
          <div class="col-md-9">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                <li><a href="#paymode" data-toggle="tab">Company Details</a></li>
                <!-- <li><a href="#companydetails" data-toggle="tab">Company Details</a></li> -->
                <li><a href="#bankdetails" data-toggle="tab">Bank Details</a></li>
                <li><a href="#backup" data-toggle="tab">Backup & Restore</a></li>
                <li><a href="#settings" data-toggle="tab">Change Password</a></li>
              </ul>
              
              <!-- Hidden upload form -->
              <form method="post" action="<?=base_url();?>/profile/uploadProductImage" enctype="multipart/form-data" id="picUploadForm" target="uploadTarget">
                <input type="file" name="picture" id="fileInput"  style="display:none"/>
              </form>
              <div class="tab-content">
                <div class="active tab-pane" id="profile">
                  <form class="form-horizontal" method="POST" action="">
                    <div class="demo" style="border:0px !important; box-shadow: 0px !important;">
                      <div class="box-body box-profile">
                        <div class="overlay uploadProcess" style="display: none;">
                          <div class="overlay-content"><img src="<?= base_url();?>/public/dist/img/images/loading.gif" style="z-index: -1;padding-left: 150px; position: relative;"/></div>
                        </div>
                        <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                        <div align="center">
                          <a class="editLink" style="z-index: -1;padding-left: 150px;"><img src="<?= base_url();?>/public/dist/img/images/edit.png"/></a>
                        </div>
                        <img class="profile-user-img img-responsive img-circle" src="<?= base_url();?>/public/dist/img/uploads/<?= $cozDetails->picture; ?>" id="imagePreview"
                          style="height: 150px; width:150px; z-index: -1;" alt="User profile picture">
                      </div>
                    </div>
                    </form>
                    <br/>
                    <p align="center" style="color:#F00;"><?php 
                      if(isset($_SESSION['msg']))
                      {
                      echo $_SESSION['msg']; }?><?php echo $_SESSION['msg']=""; ?></p>
                  <form class="form-horizontal style-form" name="form1" method="post" action="" id="form1">
                    <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php //echo $_SESSION['msg']="";?></p>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputname" name="name" placeholder="Name" 
                          value="<?= $cozDetails->name; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmaillbl" class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-8">
                        <input type="email" class="form-control" id="inputemail" name="email" placeholder="Email" 
                          value="<?= $cozDetails->email; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="professionlbl" class="col-sm-2 control-label">Profession</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="profession" name="profession" placeholder="Profession"
                          value="<?= $cozDetails->profession; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="qualificationlbl" class="col-sm-2 control-label">Qualification</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Qualification"
                          value="<?= $cozDetails->qualification; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="locationlbl" class="col-sm-2 control-label">Location</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="location" name="location" placeholder="Location"
                          value="<?= $cozDetails->location; ?>">
                      </div>
                    </div>
                    <br/>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-danger" name="profilesubmit" id="profilesubmit">
                      </div>
                    </div>
                    <br/><br/>
                  </form>
                </div>


                <div class="overlay uploadProcess2" style="display: none;">
                  <div class="overlay-content" style="z-index: -1;padding-left: 150px; position: relative;"><img src="<?= base_url()?>/public/dist/img/images/loading.gif"/></div>
                </div>
              
                <form method="post" action="upload2.php" enctype="multipart/form-data" id="picUploadForm2" target="uploadTarget2">
                  <input type="file" name="picturelogo" id="fileInput2"  style="display:none"/>
                </form>
              
              

<div class="tab-pane" id="bankdetails">
  <form class="form-horizontal" action="" id="bankinfo" method="POST">
    <br> <br>
    <div class="box-body box-profile">
      <div align="center">
        <img class="img-responsive" src="<?= base_url()?>/public/dist/img/901425.png" id="imagePreviesze" 
             style="height: 150px; width:150px; z-index: -1;" alt="Company Logo">
      </div>
    </div>
    <br>

    <!-- Bank Details Wrapper -->
    <div id="bank-details-container">
      <?php $bankCount = 0; ?>
      <?php foreach ($bz as $bank): ?>
        <div class="bank-details">
          <div class="form-group">
            <label class="col-sm-2 control-label">Bank Name</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="bname" name="bname[]" value="<?= esc($bank['bname']) ?>" placeholder="Bank Name">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">A/c Number</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="ac" name="ac[]" value="<?= esc($bank['ac']) ?>" placeholder="Account number">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">IFSC Code</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="ifsc" name="ifsc[]" value="<?= esc($bank['ifsc']) ?>" placeholder="IFSC Code" style="text-transform: uppercase;">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Branch</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="branch" name="branch[]" value="<?= esc($bank['branch']) ?>" placeholder="Branch Name">
            </div>
          </div>
        </div>
        <?php $bankCount++; ?>
      <?php endforeach; ?>
    </div>

    <br/>

    <!-- Add More Button -->
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-8">
        <a href="javascript:void(0);" id="addBank" class="btn btn-success" <?= $bankCount >= 2 ? 'style="display:none;"' : '' ?>>+ Add More Bank</a>
      </div>
    </div>

    <br/>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" class="btn btn-danger" name="csubmit">
      </div>
    </div>

  </form>
</div>

            


              
<div class="tab-pane" id="backup">
  <form class="form-horizontal" action="" method="POST">
    <br> <br>
    <div class="box-body box-profile">
      <div align="center">
        <img class="img-responsive" src="<?= base_url()?>/public/dist/img/Backup-Logo.png" id="imagePreviezs" 
             style="height: 150px; width:150px; z-index: -1;" alt="Company Logo">
      </div>
    </div>

    <br>

 <div class="form-group" >
      <div class="col-sm-offset-5 col-sm-10">
        <input type="submit" class="btn btn-primary" name="One Click Backup" value="One Click Backup" id="one-click-backup">
      </div>
    </div>
    <p id="backup-message" style="text-align: center;"></p>
    <br> <br>
    <!-- Bank Details Wrapper -->
    <div id="backup-container">
      <div class="bank-details">
        <div class="form-group">
          <label class="col-sm-2 control-label">Choose Backup File</label>
          <div class="col-sm-8">
            <input type="file" class="form-control" id="backup-file-input" name="file" placeholder="file">
          </div>
        </div>
        
      </div>
    </div>

    <br/>

    <!-- Add More Button -->
<!--     <div class="form-group">
      <div class="col-sm-offset-2 col-sm-8">
        <a href="javascript:void(0);" id="addBank" class="btn btn-success">+ Add More Bank</a>
      </div>
    </div>
 -->

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" class="btn btn-danger" name="Restore" value="Restore" id="restore-backup">
      </div>
    </div>

  </form>
</div>



                <div class="tab-pane" id="paymode">
                  <form class="form-horizontal" action="" id="codetails" method="POST">
                    <div class="box-body box-profile">
                      <iframe id="uploadTarget2" name="uploadTarget2" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                      <div align="center">
                        <a class="editLink2" style="z-index: -1; padding-left: 150px;"><img src="<?= base_url();?>/public/dist/img/images/edit.png"></a>
                      </div>
                      <!-- Image update link -->
                      <div align="center">
                        <img class="profile-user-img img-responsive img-circle" src="<?= esc(session()->get('company_logo'));  ?>" id="imagePreviews" style="height: 150px; width:150px; z-index: -1;" alt="Company Logo">
                      </div>
                    </div>
                    </br> </br>
                    <div class="form-group">
                      <label for="cnamelbl" class="col-sm-2 control-label">Company Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="cname" name="cname" placeholder="Company Name"
                          value="<?= $cozDetails->c_name; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="caddlbl" class="col-sm-2 control-label">Company Address</label>
                      <div class="col-sm-8">
                        <textarea class="form-control" id="cadd" name="cadd" placeholder="Company Address"><?= trim($cozDetails->c_add); ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="cmoblbl" class="col-sm-2 control-label">Mobile</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="cmob" name="cmob" placeholder="Mobile"
                          value="<?= $cozDetails->mob; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmailcolbl" class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-8">
                        <input type="email" class="form-control" id="cemail" name="cemail" placeholder="Email" 
                          value="<?= $cozDetails->email; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputGST" class="col-sm-2 control-label">GST</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="cgst" style="text-transform: uppercase;" name="cgst" maxlength="15" minlength="10" placeholder="GST or Adhaar or Pan" value="<?= $cozDetails->gst; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPan" class="col-sm-2 control-label">PAN</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="cpan" name="cpan" maxlength="10" minlength="10" placeholder="Company Pan" style="text-transform: uppercase; " value="<?= $cozDetails->pan; ?>">
                      </div>
                    </div>
                    <br/>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-danger" name="cosubmit" id="cosubmit">
                      </div>
                    </div>
                    <br /> <br /> 
                  </form>
                </div>


                <div class="tab-pane" id="settings">
                  <form class="form-horizontal" action="" id="pass" method="POST">
                    </br> </br>
                    <div class="box-body box-profile">
                      <!--  <iframe id="uploadTarget2" name="uploadTarget2" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe> -->
                      <div align="center">
                        <!-- <a class="editLink2" style="z-index: -1; padding-left: 150px;"><img src="../dist/img/images/edit.png"/></a></div> -->
                        <!-- Image update link -->
                        <div align="center">
                          <img class="img-responsive" src="<?= base_url()?>/public/dist/img/1234 (1).png" id="imagePreviez" style="height: 150px; width:150px; z-index: -1;" alt="Company Logo">
                        </div>
                      </div>
                      </br> 
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">User Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="username" placeholder="User Name" value="<?= $cozDetails->username;//echo $row['username']; } ?>" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">New Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?= $cozDetails->password; ?>">

                          <div id="passerror"> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
                          <div id="cpasserror"> </div>
                        </div>
                      </div>
                      <br />
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <input type="submit" class="btn btn-danger" name="upsubmit" id="upsubmit">
                        </div>
                      </div>
                      <br /><br />
                  </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
      </section>
      <!-- /.content -->

      </div>

        <?= $this->include('include/settings.php');?>
      <?= $this->include('include/footer.php');?>

      <!-- <?php //include_once"footer.php"; ?>
        <?php //include_once"settings.php"; ?>
         -->
      <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div>

    <!-- <script src="<?= base_url()?>/public/dist/js/adminlte.min.js"></script> -->
    <script type="text/javascript">
    var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>

<script>
   $(document).ready(function(){

let count = 1;  // Track new field sets
 var maxBanks = 2; // Max number of bank rows allowed
    var currentBanks = <?= $bankCount ?>; // Initial count of banks

    $('#addBank').on('click', function() {
      if (currentBanks < maxBanks) {
        var bankRow = `
          <div class="bank-details">
            <div class="form-group">
              <label class="col-sm-2 control-label">Bank Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="bname[]" placeholder="Bank Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">A/c Number</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="ac[]" placeholder="Account number">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">IFSC Code</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="ifsc[]" placeholder="IFSC Code" style="text-transform: uppercase;">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Branch</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="branch[]" placeholder="Branch Name">
              </div>
            </div>
          </div>
        `;
        $('#bank-details-container').append(bankRow);
        currentBanks++;

        // If 2 banks are added, hide the "Add More" button
        if (currentBanks >= maxBanks) {
          $('#addBank').hide();
        }
      }
    });



 $("#one-click-backup").click(function () {
        $.ajax({
            url: base_url+'/profile/dbbackup',
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                $("#one-click-backup").text("Backing Up...").prop("disabled", true);
            },
            success: function (response) {
                if (response.status === "success") {
            $("#backup-message").html("✅ Backup Successful! Check C4/writeable/backups/");
                        } else {
                            $("#backup-message").html("❌ Error: " + response.message);
                }
                $("#one-click-backup").text("One Click Backup").prop("disabled", false);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", error);
                alert("An error occurred. Check the logs.");
                $("#one-click-backup").text("One Click Backup").prop("disabled", false);
            }
        });
    });


  $("#restore-backup").click(function () {
    var formData = new FormData();
    formData.append("backup_file", $("#backup-file-input")[0].files[0]); // Assuming an input field for the file with id "backup-file-input"

    $.ajax({
        url: base_url + '/profile/restoreDB',
        type: "POST",
        data: formData,
        dataType: "json",
        processData: false, // Don't process the data
        contentType: false, // Don't set content type
        beforeSend: function () {
            $("#restore-backup").text("Restoring...").prop("disabled", true);
        },
        success: function (response) {
            if (response.type === "success") {
                $("#backup-message").html("✅ " + response.message);
            } else {
                $("#backup-message").html("❌ " + response.message);
            }
            $("#restore-backup").text("Restore Backup").prop("disabled", false);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", error);
            alert("An error occurred. Check the logs.");
            $("#restore-backup").text("Restore Backup").prop("disabled", false);
        }
    });
});


  $("#codetails").on('submit', function(e) {
    e.preventDefault(); // Prevent the page from refreshing

    // Collect the form data
    var fd = new FormData(this);

    //  //e.preventDefault();
    // console.log("cosubmit clicked");

    //  isValid = true;
    var cname = $("#cname").val().trim();
    var cadd = $("#cadd").val();
    var cmob = $("#cmob").val();
    var cemail = $("#cemail").val();
            //console.log(country);
    var cgst = $("#cgst").val().trim();

    var cpan = $("#cpan").val().trim();
    
      //var u_type = 0; // Assuming you want this value
        var fd = new FormData();
        fd.append("cname", cname);
        fd.append("cadd", cadd);
        fd.append("cmob", cmob);
        fd.append("cemail", cemail);
        fd.append("cgst", cgst);
        fd.append("cpan", cpan); // Ensure this is included
        
        console.log("cname: ", cname);
        console.log("cadd: ", cadd);
        console.log("cmob: ", cmob);
        console.log("cemail: ", cemail);
        console.log("cgst: ", cgst);
        console.log("cpan: ", cpan);

        console.log(fd);    

   $.ajax({
        url: base_url + "/profile/updateData", // Ensure this is the correct endpoint
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            console.log("AJAX Success:", response);
             Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    });

            // You can show a message or update the page accordingly
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
        }
    });
});

$("#form1").on('submit', function(e) {
    e.preventDefault(); // Prevent the page from refreshing

    // Collect the form data
    var fd = new FormData(this);

    //  //e.preventDefault();
    // console.log("cosubmit clicked");

    //  isValid = true;
    var name = $("#inputname").val().trim();
    var email = $("#inputemail").val();
    var profession = $("#profession").val();
    var qualification = $("#qualification").val();
            //console.log(country);
    var location = $("#location").val();

    //var cpan = $("#cpan").val().trim();
    
      //var u_type = 0; // Assuming you want this value
        var fd = new FormData();
        fd.append("name", name);
        fd.append("email", email);
        fd.append("profession", profession);
        fd.append("qualification", qualification);
        fd.append("location", location);
        //fd.append("cpan", cpan); // Ensure this is included
        
        console.log("name: ", name);
        console.log("email: ", email);
        console.log("profession: ", profession);
        console.log("qualification: ", qualification);
        console.log("location: ", location);
        //console.log("cpan: ", cpan);

        console.log(fd);    

   $.ajax({
        url: base_url + "/profile/updateData2", // Ensure this is the correct endpoint
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            console.log("AJAX Success:", response);
             Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    });

            // You can show a message or update the page accordingly
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
        }
    });
});

$("#pass").on('upsubmit', function(e) {
    e.preventDefault(); // Prevent the page from refreshing

    // Collect the form data
    var fd = new FormData(this);

    //  //e.preventDefault();
    // console.log("cosubmit clicked");

    //  isValid = true;
    var username = $("#username").val();
    var password = $("#password").val();
    var cpassword = $("#cpassword").val();

        var fd = new FormData();
        fd.append("username", username);
        fd.append("password", password);
       // fd.append("profession", profession);
        
        console.log("name: ", username);
        console.log("email: ", password);
        //console.log("profession: ", profession);

        console.log(fd);    

   $.ajax({
        url: base_url + "/profile/updateData3", // Ensure this is the correct endpoint
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            console.log("AJAX Success:", response);
             Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    });

            // You can show a message or update the page accordingly
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
        }
    });
});


 // Intercept the form submission and send it via AJAX
    $("#bankinfo").on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission (page refresh)

        // Create a FormData object to capture all form fields
        var formData = new FormData(this);

        // For debugging, log the FormData entries
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: base_url + "/profile/updateBankDetails", // Update this with your actual endpoint URL
            type: 'POST',
            data: formData,
            contentType: false, // Important for file uploads and FormData
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log("AJAX Success:", response);
                if(response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    });
                    // Optionally, reload or update the view
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                Swal.fire('Oops...', 'Something went wrong with the AJAX request!', 'error');
            }
        });
    });


$('#fileInput').change(function () {
    var formData = new FormData();
    var productId = 1; // Ensure this is the correct product ID
    var file = $('#fileInput')[0].files[0];

    if (file) {
        formData.append('picture', file); // Change 'fileInput' to 'picture' to match the backend
        formData.append('product_id', productId); // Assuming product ID

        $.ajax({
            url: base_url + "/profile/uploadProductImage",  // Ensure this is the correct route
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log("Response received: ", response);

                if (response.success) {
                    console.log('Image uploaded successfully: ' + response.filename);

                    // Update the image preview after successful upload
                    var imageUrl = base_url + '/public/dist/img/uploads/' + response.filename;
                    $('#imagePreview').attr('src', imageUrl);
                    $('#imagePreview2').attr('src', imageUrl);
                    $('#imagePreview3').attr('src', imageUrl);
                    $('#imagePreview4').attr('src', imageUrl);
                   $('#imagePreview5').attr('src', imageUrl);
                } else {
                    console.log('Error: ' + response.message);
                    alert('Error uploading image');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error uploading image: ' + error);
                alert('Error uploading image');
            }
        });
    }
});

$('#fileInput2').change(function () {
    var formData = new FormData();
    var productId = 1; // Ensure this is the correct product ID
    var file = $('#fileInput2')[0].files[0];

    if (file) {
        formData.append('picturelogo', file); // Change 'fileInput' to 'picture' to match the backend
        formData.append('product_id', productId); // Assuming product ID

        $.ajax({
            url: base_url + "/profile/uploadProductImage2",  // Ensure this is the correct route
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log("Response received: ", response);

                if (response.success) {
                    console.log('Image uploaded successfully: ' + response.filename);

                    // Update the image preview after successful upload
                    var imageUrl = base_url + '/public/dist/img/uploads/' + response.filename;
                    $('#imagePreviews').attr('src', imageUrl);
                    //$('#imagePreview2').attr('src', imageUrl);
                    //$('#imagePreview3').attr('src', imageUrl);
                    //$('#imagePreview4').attr('src', imageUrl);
                   //$('#imagePreview5').attr('src', imageUrl);
                } else {
                    console.log('Error: ' + response.message);
                    alert('Error uploading image');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error uploading image: ' + error);
                alert('Error uploading image');
            }
        });
    }
});


});      


</script>
    
  </body>
</html>