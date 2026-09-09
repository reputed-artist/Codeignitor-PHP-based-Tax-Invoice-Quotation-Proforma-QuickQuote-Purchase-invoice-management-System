<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | User Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= $this->include('include/links_profile.php');?>
  

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
        <input type="button" class="btn btn-primary" name="One Click Backup" value="One Click Backup" id="one-click-backup">
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
        <input type="button" class="btn btn-danger" name="Restore" value="Restore" id="restore-backup">
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

      </section>
            <!-- /.box -->
        
      <!-- /.content -->
       

            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-line-chart"></i> Monthly Sales Trend (Static)</h3>
                </div>
                <div class="box-body chart-responsive">
                  <div class="chart" id="line_chart" style="height: 300px;"></div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
             
         
          <!-- /.row -->

      </div>
<!-- 
<div class="box box-primary" style="width: 100%; overflow: hidden;">
  <div class="box-header with-border">
    <h3 class="box-title">Business Overview</h3>
  </div>
  <div class="box-body">
<div class="row" style="margin-left: 0; margin-right: 0;">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <div class="info-box bg-green">
                        <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Business Snapshot</span>
                          <span class="info-box-number"><?= isset($sm[2]['value']) ? moneyFormatIndia($sm[2]['value']) : '0'; ?></span>
                          <span class="progress-description">Sales total</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="fa fa-building"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Company Profile</span>
                          <span class="info-box-number"><?= esc($cozDetails->name); ?></span>
                          <span class="progress-description"><?= esc($cozDetails->email); ?></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <div class="info-box bg-yellow">
                        <span class="info-box-icon"><i class="fa fa-bank"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Bank Accounts</span>
                          <span class="info-box-number"><?= is_array($bz) ? count($bz) : 0; ?></span>
                          <span class="progress-description">Configured accounts</span>
                        </div>
                      </div>
                    </div>
                  </div>
  </div>
</div> -->
      

        <?= $this->include('include/settings.php');?>
      <?= $this->include('include/footer.php');?>

      <!-- <?php //include_once"footer.php"; ?>
        <?php //include_once"settings.php"; ?>
         -->
      <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div>


    <!-- Page config passed from PHP to JS -->
    <script>
        window.C4PageConfig = {
            base_url: "<?= base_url(); ?>",
            bankCount: <?= (int) $bankCount; ?>
        };
    </script>
    <!-- Consolidated page logic (external, cacheable) -->
    <script src="<?= base_url(); ?>/public/js/profileinfo.js"></script>


    
  </body>
</html>
