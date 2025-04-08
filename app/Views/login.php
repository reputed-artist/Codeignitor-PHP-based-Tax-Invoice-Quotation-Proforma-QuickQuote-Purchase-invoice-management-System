
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url()?>/public/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url()?>/public/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url()?>/public/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
	.input-group{
		margin-left:32px;
	}
	#try
	{
		margin-left: 30%;
	}
</style>
</head>
<body class="hold-transition login-page" align="center">
<div class="login-box">
  </div>
  <!-- /.login-logo -->

 
        <div class="col-md-4" id="try">
          <!-- general form elements -->
          <div class="box box-info"  style="box-shadow: 5px 10px 8px #888888;">
            
 	</br></br>
  	<div align="center">
  	<img src ="<?= base_url()?>/public/dist/img/logo.png" class="" alt="CODETECH Logo" height="150" width="210"></div>
  </br>
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="" method="post" role="form" id="loginForm">
    <div class="box-body">
      <div class="form-group" >
        <div class="input-group col-sm-10">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="text" name="username" id="username" class="form-control col-sm-8"  required="required" placeholder="Email">
               
              </div>
              <div id="usererror"></div>
      </div>

      <div class="form-group">
        <div class="input-group col-sm-10">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" name="password" id="password" class="form-control col-sm-8" required="required" placeholder="Password">
                
              </div>
      <div id="passerror"> </div>         
      </div>
     
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck pull-left" style="margin-left: 50px;">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
    </div>
        <!-- /.col -->
        <div class="box-footer" style="margin-right: 10px; ">
              <label class="col-sm-1"></label>
              <input type="submit" name="login" value="Login" class="btn btn-info col-sm-10" id="submit"></br>
              <div id="dberror" style="color:red;"><?php if(isset($error)){
                echo "*Invalid Login credentials";
              }
              ?></br></br></br>
        </div>
    </div>
              
</div>
    </form>
</div></div>
  <!--  
<script type="text/javascript">
  function validate(){
  var username = document.getElementById("username").value;
  var password=document.getElementById("password").value;

  if(!username)
  {
    document.getElementById("usererror").innerHTML ="Enter User name";
    document.getElementById("usererror").style.color="Red";
  }
  

if(!password)
{
  document.getElementById("passerror").innerHTML="Enter Password";
  document.getElementById("passerror").style.color="Red";
}

}
</script>
 -->


<!-- jQuery 3 -->
<script src="<?= base_url()?>/public/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url()?>/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?= base_url()?>/public/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<script>
  var base_url = "<?= base_url(); ?>"; 
</script>
<script>
  $(document).ready(function() {
    // var base_url = "<?= base_url(); ?>"; 
    $("#loginForm").submit(function(e) {
      //console.log("submit works");
        e.preventDefault(); // Prevent form from submitting normally

        var username=$('#username').val();
        var password=$('#password').val();

        var formData = new FormData();
        formData.append('username',username);
        formData.append('password',password);

      $.ajax({
    url: base_url+'/login/userlogin',
    type: "POST",
    data: formData,
    dataType: "json",
    processData: false,  // Prevent jQuery from processing data
    contentType: false,  // Prevent setting contentType header
    success: function(response) {
        if (response.status == "success") {
            console.log("login success");
            $("#loginMessage").html('<span style="color: green;">' + response.message + '</span>');
            setTimeout(function() {
                window.location.href = base_url + "/dashboard";
            }, 400);
        } else {
            $("#loginMessage").html('<span style="color: red;">' + response.message + '</span>');
        }
    },
    error: function(xhr) {
        console.log("AJAX error: ", xhr.responseText); // Debugging log
        $("#loginMessage").html('<span style="color: red;">Something went wrong!</span>');
    }
});

    });
});

</script>
</body>
</html>
