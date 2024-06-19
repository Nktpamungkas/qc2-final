<?php
ini_set("error_reporting", 1);
session_start();
//require_once "waktu.php";
include"koneksi.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
  <title>QC2 Final | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!--alerts CSS -->
  <link href="bower_components/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->

  <!--<link rel="stylesheet"
        href="dist/css/font/font.css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->
<style>
        body{
          font-family: Calibri, "sans-serif", "Courier New";  /* "Calibri Light","serif" */
          font-style: normal;
        }
        </style>
  <link rel="icon" type="image/png" href="dist/img/ITTI_Logo index.ico">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  <a href="index.php"><b>QC2 ITTI</b></a>
    <img src="dist/img/ITTI_LogoShape.png" alt="Logo Indotaichen">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
	  <p class="login-box-msg">Sign in to start your session</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="UserName" name="username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
         <div class="col-xs-8">
          <!-- <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div> -->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->

      </div>
    </form>

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

    <!-- <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->

</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- Sweet Alert -->
<script type="text/javascript" src="bower_components/sweetalert/sweetalert2.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
<?php
if($_POST){ //login user
  extract($_POST);
  $username = mysqli_real_escape_string($con,$_POST['username']);
  $password = mysqli_real_escape_string($con,$_POST['password']);
  $sql=mysqli_query($con,"SELECT * FROM user_login WHERE user='$username' AND password='$password' AND dept = 'QC' LIMIT 1");
  if(mysqli_num_rows($sql)>0)
  {
  $_SESSION['usrid1']=$username;
  $_SESSION['pasid1']=$password;
  $r = mysqli_fetch_array($sql);
  $_SESSION['lvl_id1']=$r['level'];
  $_SESSION['status1']=$r['status'];
  $_SESSION['mamber1']=$r['mamber'];
  $_SESSION['foto1']=$r['foto'];
  $_SESSION['jabatan1']=$r['jabatan'];
  $_SESSION['ket1']=$r['ket'];
  $_SESSION['akses1']=$r['akses'];
  //login_validate();
    //echo "<script>window.location='index1.php?p=Home';</script>";
	echo "<script>swal({
  title: 'Login Success!!',
  text: 'Click Ok to continue',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    window.location='Home';
  }
});</script>";

  }else {
	  // echo "<script>alert('Login Gagal!! $username');window.location='index.php';</script>";
  	 echo "<script> swal({
            title: 'Login Gagal!!',
            text: ' Klik Ok untuk Login kembali',
            type: 'warning'
        }, function(){
            window.location='login';
        });</script>";
  }

}else
if( $_GET['act']=="logout" ){ //logout user
unset($_SESSION['usrid']);
//echo "<script>window.location='index.php';</script>";
echo "<script>swal({
  title: 'You are Logged out!!',
  text: 'Click Ok to redirect',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    window.location='login';
  }
});</script>";
}
?>
