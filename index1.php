<?php

session_start();
//include config
//require_once "waktu.php";
include_once ('koneksi.php');
?>

<?php
//set base constant
if( !isset($_SESSION['usrid1'])) { ?>
<script>setTimeout("location.href='login'",500);</script>
<?php die( 'Illegal Acces' ); }else if( !isset($_SESSION['pasid1'])) { ?>
 <script>setTimeout("location.href='lockscreen'",500);</script>
<?php die( 'Illegal Acces' );
}

//request page
$page = isset($_GET['p'])?$_GET['p']:'';
$act  = isset($_GET['act'])?$_GET['act']:'';
$id   = isset($_GET['id'])?$_GET['id']:'';
$page = strtolower($page);
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>QC2-Final | <?php if($_GET['p']!=""){echo ucwords($_GET['p']);}else{echo "Home";}?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- toast CSS -->
  <link href="bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link href="bower_components/datatables.net-bs/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
  <!-- Sweet Alert -->
  <link href="bower_components/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
  <!-- Sweet Alert -->
  <script type="text/javascript" src="bower_components/sweetalert/sweetalert2.min.js"></script>
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">	
  <!--  AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
	body{
		font-family: Calibri, "sans-serif", "Courier New";  /* "Calibri Light","serif" */
		font-style: normal;
	}	
  </style>
  <!-- Google Font -->
  <!--
  <link rel="stylesheet"
        href="dist/css/font/font.css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  -->
  <link rel="icon" type="image/png" href="dist/img/ITTI_Logo index.ico">
<style>
.blink_me {
  animation: blinker 1s linear infinite;
}
.bulat{
  border-radius: 50%;
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}
.border-dashed{
		border: 3px dashed #083255;
	}
@keyframes blinker {
  50% { opacity: 0; }
}
	body{
		font-family: Calibri, "sans-serif", "Courier New";  /* "Calibri Light","serif" */
		font-style: normal;
	}
</style>

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-collapse fixed">

<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header ">

    <!-- Logo -->
    <a href="Home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>QC2F</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>QC2</b>-Final</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
<?php ?>

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Ada <span class="label label-warning"></span> Note</li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
				<?php 	?>
                  <li><!-- start notification -->
                    <a href="#">
                      <i class="fa fa-file-text text-aqua"></i>
                    </a>
                  </li>
                  <!-- end notification -->
					<?php  ?>
                </ul>
              </li>
              <li class="footer"><a href="?p=Terima-RMP">Tampil Semua</a></li>
            </ul>
          </li>
			<?php 	?>
          <!-- Tasks Menu -->
          <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-info"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Ada <span class="label label-primary"></span> Note</li>
              <li>
                <!-- Inner menu: contains the tasks -->
                <ul class="menu">
				<?php 	?>
                  <li><!-- Task item -->
                    <a href="#">
                      <!-- Task title and progress text -->
                      <h3>
                        <small class="pull-right"><?php echo $prsn?>%</small>
                      </h3>
                      <!-- The progress bar -->
                      <div class="progress xs">
                        <!-- Change the css width attribute to simulate progress -->
                        <div class="progress-bar <?php if($prsn=="100"){echo"bg-green";} else if($prsn>70){echo"bg-blue";}else if($prsn>50){echo"bg-aqua";}else if($prsn>30){echo"bg-yellow";}else{echo"bg-red";} ?> " style="width: 0%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only"><?php echo $prsn;?>% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
				<?php  ?>
                </ul>
              </li>
              <li class="footer">
                <a href="?p=Realisasi-GDB">Tampil Semua</a>
              </li>
            </ul>
          </li>
		  <?php ?>
           <!-- Revisi Menu -->
          <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa  fa-envelope-o"></i>
              <span class="label label-danger"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Ada <span class="label label-danger"></span> Note</li>
              <li>
                <!-- Inner menu: contains the tasks -->
                <ul class="menu">
				<?php 	?>
                  <li><!-- Task item -->
                    <a href="#">
                      <!-- Task title and progress text -->
                      <h3>
                      </h3>
                    </a>
                  </li>
                  <!-- end task item -->
				<?php  ?>
                </ul>
              </li>
              <li class="footer">
                <a href="?p=Realisasi-GDB">Tampil Semua</a>
              </li>
            </ul>
          </li>
			<!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="dist/img/<?php echo $_SESSION['foto1'].".png";?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo strtoupper($_SESSION['usrid1']);?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="dist/img/<?php echo $_SESSION['foto1'].".png";?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo strtoupper($_SESSION['usrid1']);?> - <?php echo $_SESSION['jabatan1']; ?>
                  <small>Member since <?php echo $_SESSION['mamber1']; ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div> -->
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="lockscreen" class="btn btn-default btn-flat">LockScreen</a>
                </div>
                <div class="pull-right">
                  <a href="logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/<?php echo $_SESSION['foto1'].".png";?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo strtoupper($_SESSION['usrid1']);?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form (Optional) -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>-->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="<?php if($_GET['p']=="Home" or $_GET['p']==""){echo"active";} ?>"><a href="Home"><i class="fa fa-dashboard"></i> <span>DashBoard</span></a></li>
		<?php if($_SESSION['lvl_id1']=="PACKING"){  ?>  
        <li class="treeview <?php if($_GET['p']=="Input-Data" or $_GET['p']=="Input-Data-KR" or $_GET['p']=="Input-Data-DYE" or $_GET['p']=="Input-Data-ERP" or $_GET['p']=="Input-Data-KR-ERP" or $_GET['p']=="Input-Data-DYE-ERP"){echo"active";}?>">
          <a href="#"><i class="fa fa-gears"></i> <span>QC2F</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
       <ul class="treeview-menu">
       <li class="<?php if($_GET['p']=="Input-Data"){echo"active";} ?> <?php if($_SESSION['akses1']=="biasa"){echo "hidden";} ?>"><a href="InputData"><i class="fa fa-calendar"></i> <span>Input-Data</span></a></li>
	   <li class="<?php if($_GET['p']=="Input-Data-KR"){echo"active";} ?> <?php if($_SESSION['akses1']=="biasa"){echo "hidden";} ?>"><a href="InputDataKR"><i class="fa fa-calendar"></i> <span>Input-Data-KR</span></a></li>
	   <li class="<?php if($_GET['p']=="Input-Data-DYE"){echo"active";} ?> <?php if($_SESSION['akses1']=="biasa"){echo "hidden";} ?>"><a href="InputDataDYE"><i class="fa fa-calendar"></i> <span>Input-Data-DYE</span></a></li>
     <li class="<?php if($_GET['p']=="Input-Data-ERP"){echo"active";} ?> <?php if($_SESSION['akses1']=="biasa"){echo "hidden";} ?>"><a href="InputDataERP"><i class="fa fa-calendar"></i> <span>Input-Data-ERP</span></a></li>
	   <li class="<?php if($_GET['p']=="Input-Data-KR-ERP"){echo"active";} ?> <?php if($_SESSION['akses1']=="biasa"){echo "hidden";} ?>"><a href="InputDataKRERP"><i class="fa fa-calendar"></i> <span>Input-Data-KR-ERP</span></a></li>
	   <li class="<?php if($_GET['p']=="Input-Data-DYE-ERP"){echo"active";} ?> <?php if($_SESSION['akses1']=="biasa"){echo "hidden";} ?>"><a href="InputDataDYEERP"><i class="fa fa-calendar"></i> <span>Input-Data-DYE-ERP</span></a></li>
<!-- <li class="<?php if($_GET['p']=="Input-Data3"){echo"active";} ?> <?php if($_SESSION['akses1']=="biasa"){echo "hidden";} ?>"><a href="InputData3"><i class="fa fa-calendar"></i> <span>Input-Data3</span></a></li> 	   
<li class="<?php if($_GET['p']=="Input-Data-DYE3"){echo"active";} ?> <?php if($_SESSION['akses1']=="biasa"){echo "hidden";} ?>"><a href="InputDataDYE3"><i class="fa fa-calendar"></i> <span>Input-Data-DYE3</span></a></li>	   
<li class="<?php if($_GET['p']=="Input-Data-KR3"){echo"active";} ?> <?php if($_SESSION['akses1']=="biasa"){echo "hidden";} ?>"><a href="InputDataKR3"><i class="fa fa-calendar"></i> <span>Input-Data-KR3</span></a></li> -->
</ul>
        </li>
		 <?php } ?>
		
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content container-fluid">
      <?php
          if(!empty($page) and !empty($act)){
            $files = 'pages/'.$page.'.'.$act.'.php';
          } else
          if(!empty($page)){
            $files = 'pages/'.$page.'.php';
          } else {
            $files = 'pages/home.php';
          }

          if(file_exists($files)){
            include_once($files);
          } else {
            include_once("blank.php");
          }
          ?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      DIT
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022 <a href="#">Indo Taichen Textile Industry</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <!--
  <aside class="control-sidebar control-sidebar-dark">

    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>

    <div class="tab-content">

      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>


        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>


      </div>

      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>

      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>

        </form>
      </div>

    </div>
  </aside>
  -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- start - This is for export functionality only -->
    <script src="bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/buttons.flash.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/jszip.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/pdfmake.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/vfs_fonts.js"></script>
    <script src="bower_components/datatables.net-bs/js/buttons.html5.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
<script src="bower_components/toast-master/js/jquery.toast.js"></script>

<script>

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
	  format: 'dd-mm-yyyy',
	  todayHighlight: true,
    }),
	//Date picker
    $('#datepicker1').datepicker({
      autoclose: true,
	  format: 'dd-mm-yyyy',
	  todayHighlight: true,
    }),
	//Date picker
    $('#datepicker2').datepicker({
      autoclose: true,
	  format: 'dd-mm-yyyy',
	  todayHighlight: true,
    }),
	//Date picker
    $('#datepicker3').datepicker({
      autoclose: true,
	  format: 'dd-mm-yyyy',
	  todayHighlight: true,
    })
</script>
<script>
  $(function () {

    $('#example1').DataTable({
	  'scrollX'  : true,
	  'paging': true,

	})
	$('#example2').DataTable()
    $('#example3').DataTable({
	 'scrollX'	: true,
	 dom: 'Bfrtip',
      buttons: [
            'excel',
	  {
        orientation: 'portrait',
        pageSize: 'LEGAL',
        extend: 'pdf',
        footer: true,
				},
        ]
	})
	$('#example4').DataTable({
	    'paging': false,
	})
	$('#example5').DataTable()
	$('#example6').DataTable() 
	$('#tblr1').DataTable()
	$('#tblr2').DataTable()
	$('#tblr3').DataTable()
	$('#tblr4').DataTable()
	$('#tblr5').DataTable()
	$('#tblr6').DataTable()
	$('#tblr7').DataTable()
	$('#tblr8').DataTable()
	$('#tblr9').DataTable()
	$('#tblr10').DataTable()
	$('#tblr11').DataTable()
	$('#tblr12').DataTable()
	$('#tblr13').DataTable()
	$('#tblr14').DataTable()
	$('#tblr15').DataTable()
	$('#tblr16').DataTable()
	$('#tblr17').DataTable()
	$('#tblr18').DataTable()
	$('#tblr19').DataTable()
	$('#tblr20').DataTable()

  })
</script>
<!-- Javascript untuk popup modal Edit-->
<script type="text/javascript">
   $(document).ready(function () {

	 });
   //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })	
</script>
<script type="text/javascript">
$(document).on('click', '.data_edit', function (e) {
  var m = $(this).attr("id");
    $.ajax({
       url: "pages/data_edit.php",
       type: "GET",
       data : {id: m,},
       success: function (ajaxData){
         $("#DataEdit").html(ajaxData);
         $("#DataEdit").modal('show',{backdrop: 'true'});
       }
     });
      });
$(document).on('click', '.inputbr_edit', function (e) {
  var m = $(this).attr("id");
    $.ajax({
       url: "pages/inputbr_edit.php",
       type: "GET",
       data : {id: m,},
       success: function (ajaxData){
         $("#InputBrEdit").html(ajaxData);
         $("#InputBrEdit").modal('show',{backdrop: 'true'});
       }
     });
      });	  
$(document).on('click', '.dtmail', function (e) {
  var m = $(this).attr("id");
    $.ajax({
       url: "pages/detail_email.php",
       type: "GET",
       data : {id: m,},
       success: function (ajaxData){
         $("#DtMail").html(ajaxData);
         $("#DtMail").modal('show',{backdrop: 'true'});
       }
     });
      });	
</script>
       <script src="bower_components/ckeditor/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
