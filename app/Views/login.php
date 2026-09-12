
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

	/* --- UI polish: same structure, same logo — look & feel only --- */
	/* Gradient lives on the root/canvas: it always paints the ENTIRE viewport,
	   so no strip, margin gap or overflow area can ever show another colour. */
	html{
		margin: 0;
		background: linear-gradient(135deg, #667eea 0%, #3c8dbc 55%, #00c0ef 100%) center/cover no-repeat fixed !important;
	}
	body.login-page{
		margin: 0;
		min-height: 100vh;
		background: transparent !important;
		-webkit-font-smoothing: antialiased;
	}
	#try .box{
		border-radius: 10px;
		border-top-width: 4px;
		overflow: hidden;
		box-shadow: 0 12px 30px rgba(0,0,0,.18), 0 4px 10px rgba(0,0,0,.12) !important;
		transition: transform .18s ease, box-shadow .18s ease;
	}
	#try .box:hover{
		transform: translateY(-3px);
		box-shadow: 0 18px 40px rgba(0,0,0,.24), 0 6px 14px rgba(0,0,0,.14) !important;
	}
	.login-box-msg{
		font-size: 16px;
		color: #555;
		letter-spacing: .3px;
		margin-bottom: 20px;
	}
	#try .form-group{ margin-bottom: 18px; }
	#try .input-group{ position: relative; }
	#try .input-group-addon{
		background: #fbfcfe;
		color: #8fa3bf;
		border-color: #e3e9f2;
		border-right: none;
		width: 46px;
		font-size: 15px;
		border-radius: 12px 0 0 12px;
		transition: color .18s ease;
	}
	#try .input-group:focus-within .input-group-addon{ color: #00b5d8; }
	#try .form-control{
		height: 44px;
		font-size: 15px;
		color: #22314a;
		background: #fbfcfe;
		box-shadow: none;
		border: 1px solid #e3e9f2;
		border-left: none;
		border-radius: 0 12px 12px 0;
		transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
	}
	#try .form-control::placeholder{
		color: #a7b4c4;
		opacity: 1;
		letter-spacing: .2px;
	}
	#try .form-control:hover{
		border-color: #cfd9e6;
		background: #fff;
	}
	#try .form-control:focus{
		background: #fff;
		border-color: #00c0ef;
		box-shadow: 0 0 0 4px rgba(0,192,239,.14);
	}
	/* Remember Me row: kill the uneven offset, align with the fields */
	#try .row{ margin-left: 0; margin-right: 0; }
	#try .row .col-xs-8{ padding-left: 0; padding-right: 0; }
	#try .checkbox.icheck{
		margin: 2px 0 14px 24px !important;
		padding-left: 0 !important;
		float: none;
	}
	#try .checkbox label{
		color: #555;
		display: inline-flex;
		align-items: center;
		font-size: 14px;
		padding: 0;
		cursor: pointer;
	}
	#try .checkbox .icheckbox_square-blue{ margin-right: 8px; }
	/* Wider inputs: span the card instead of the old 83% col-sm-10 width */
	#try .input-group.col-sm-10{
		float: none;
		width: calc(100% - 34px);
		margin-left: 24px;
		margin-right: 10px;
	}
	/* Show-password eye button */
	/* Show-password eye (Material style, like Android apps) — inside the field */
	#try .toggle-password{
		position: absolute;
		right: 12px;
		top: 50%;
		transform: translateY(-50%);
		width: 26px;
		height: 26px;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #9aa7b4;
		cursor: pointer;
		z-index: 3;
		border-radius: 50%;
		transition: color .15s ease, background .15s ease;
	}
	#try .toggle-password:hover{
		color: #00b5d8;
		background: rgba(0,192,239,.08);
	}
	#try .toggle-password svg{
		width: 20px;
		height: 20px;
		display: block;
	}
	#try .toggle-password .svg-eye-off{ display: none; }
	#try .toggle-password.showing .svg-eye{ display: none; }
	#try .toggle-password.showing .svg-eye-off{ display: block; }
	#password{ padding-right: 44px; }
	#submit{
		background: linear-gradient(135deg, #00c0ef, #3c8dbc);
		border: none;
		height: 44px;
		font-weight: 600;
		letter-spacing: .5px;
		border-radius: 12px;
		float: none;
		display: block;
		width: calc(100% - 24px);
		margin-left: 24px;
		margin-right: 0;
		box-shadow: 0 6px 14px rgba(0,192,239,.35);
		transition: filter .18s ease, box-shadow .18s ease, transform .1s ease;
	}
	/* hide the empty spacer label so the button aligns with the inputs */
	#try .box-footer label.col-sm-1{ display: none; }
	/* align Remember Me with the inputs' left edge */
	#try .checkbox.icheck{ margin-left: 24px !important; }
	#submit:hover{
		filter: brightness(1.07);
		box-shadow: 0 8px 18px rgba(0,192,239,.45);
	}
	#submit:active{ transform: translateY(1px); }
	#dberror{ font-weight: 600; }

	/* --- Particles.js layer: purely decorative, sits BEHIND the login card,
	   on top of the html gradient. Never intercepts clicks --- */
	#particles-js{
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 0;
		pointer-events: none;
	}
	.login-box{ position: relative; z-index: 1; }

	/* --- Responsive only: the normal desktop/tablet look (>=992px) is unchanged.
	   Rules below apply only on phones/small tablets so nothing overflows --- */
	img { max-width: 100%; height: auto; }
	@media (max-width: 991px) {
		#try {
			float: none;
			width: 92%;
			max-width: 400px;
			margin-left: auto;
			margin-right: auto;
		}
		.input-group {
			margin-left: 0;
			width: 100%;
		}
		#submit { width: 100%; margin-left: 0; margin-right: 0; }
		.box-footer { margin-right: 0 !important; }
	}
  

</style>
</head>
<body class="hold-transition login-page" align="center">
<!-- particles.js background layer (decorative) -->
<div id="particles-js"></div>
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
                <span class="toggle-password" title="Show password">
                  <svg class="svg-eye" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                  <svg class="svg-eye-off" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>
                </span>
                
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
        <div id="loginMessage" class="text-center" style="margin-top:10px;"></div>
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
<!-- particles.js background -->
<script src="<?= base_url()?>/public/plugins/particles/particles.min.js"></script>
<script>
  $(function () {
    if (window.particlesJS) {
      particlesJS('particles-js', {
        particles: {
          number: { value: 70, density: { enable: true, value_area: 900 } },
          color: { value: '#ffffff' },
          shape: { type: 'circle', stroke: { width: 0, color: '#000000' } },
          opacity: { value: 0.45, random: true, anim: { enable: true, opacity_min: 0.15, speed: 1 } },
          size: { value: 6, random: true,  
          anim: { enable: false, speed: 40, size_min: 0.1, sync: false }},
          line_linked: { enable: true, distance: 140, color: '#ffffff', opacity: 0.25, width: 1 },
          move: { enable: true, speed: 1.6, direction: 'none', random: true, out_mode: 'out' }
        },
        interactivity: {
          detect_on: 'window',
          events: { onhover: { enable: true, mode: 'grab' }, onclick: { enable: true, mode: 'push' }, resize: true },
          modes: { grab: { distance: 130, line_linked: { opacity: 0.35 } }, push: { particles_nb: 4 } }
        },
        retina_detect: true
      });
    }
  });
</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
    // Show / hide password eye toggle
    $(document).on('click', '.toggle-password', function () {
      var $pwd = $('#password');
      var show = $pwd.attr('type') === 'password';
      $pwd.attr('type', show ? 'text' : 'password');
      $(this).toggleClass('showing');
      $(this).attr('title', show ? 'Hide password' : 'Show password');
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
