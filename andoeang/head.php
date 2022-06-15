<?php 
if (empty($_SESSION['id_user'])){
    $_SESSION['info']="Silahkan Login...!!!";
  header('location:index.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title id="title1"></title>
	<!-- Bootstrap -->
    <link href="bs/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="bs/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="bs/vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="bs/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="bs/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="bs/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="bs/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="bs/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="bs/build/css/custom.min.css" rel="stylesheet">

    <!-- Bootstrap --> 
    <link href="bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="moment-with-locales.js"></script>
    <script type="text/javascript" src="jquery-1.10.2.min.js"></script>
</head>
 <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="administrator.php" class="site_title"><span>Andoeang Adventure</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $_SESSION['username']; ?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Halaman <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.php">Beranda</a></li>
                      <li><a href="administrator.php">Administrator</a></li>
                    </ul>
                  </li>
                  <?php if ($_SESSION['level']=="admin"){ ?>
                  <li><a><i class="fa fa-edit"></i> Master <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="form_alat.php">Input Alat</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-table"></i> Data <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="data_peminjaman.php">Data Booking</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="laporan_user.php">Laporan User</a></li>
                      <li><a href="laporan_booking.php">Laporan Booking</a></li>
                      <li><a href="laporan_keranjang.php">Laporan Keranjang</a></li>
                      <li><a href="laporan_pengembalian.php">Laporan Pengembalian</a></li>
                    </ul>
                  </li>
                  <?php } ?>
                  <li><a href="keranjang.php"><i class="fa fa-shopping-cart"></i>Keranjang</a>
                  </li>
                  <li><a href="ganti.php?ganti=<?php echo $_SESSION['id_user']; ?>">Ganti Password</a></li>
                </ul>
              </div>
              
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="log_reg.php?id=keluar">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

       

           <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
<?php if (!empty($_SESSION['info'])){ ?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong><?php echo $_SESSION['info']; ?></strong>
                  </div>
   
<?php unset($_SESSION['info']); } ?>

<?php } ?>