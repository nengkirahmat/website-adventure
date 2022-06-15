<?php
include "koneksi.php";
include "pro_keranjang.php";


    if (isset($_POST['daftar'])){
        $nama_lengkap=$_POST['nama_lengkap'];
        $alamat=$_POST['alamat'];
        $email=$_POST['email'];
        $username=$_POST['username'];
        $password=$_POST['password'];
        $repassword=$_POST['repassword'];
        $hp=$_POST['hp'];
        $level="user";
        $date_join=date('Y-m-d h:i:s');
        $cek_user=$con->prepare("select * from tbl_user where username=:username");
        $cek_user->BindParam(":username",$username);
        $cek_user->execute();
        $res=$cek_user->rowCount();
        if ($res>0){
            $_SESSION['info']="Username telah digunakan...!!!";
        }else
        if ($password<>$repassword){
            $_SESSION['info']="Kombinasi password tidak valid...!!!";

        }
        else
        {
            $query=$con->prepare("insert into tbl_user values('',:nama_lengkap,:hp,:alamat,:email,:username,:password,:level,:date_join)");
            $query->BindParam(":nama_lengkap",$nama_lengkap);
            $query->BindParam(":hp",$hp);
            $query->BindParam(":alamat",$alamat);
            $query->BindParam(":email",$email);
            $query->BindParam(":username",$username);
            $query->BindParam(":password",$password);
            $query->BindParam(":level",$level);
            $query->BindParam(":date_join",$date_join);
            $query->execute();
            $_SESSION['info']="Pendaftaran sukses, silahkan login...!!!";
            
        }
    }



    if (isset($_POST['login'])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $query=$con->prepare("select * from tbl_user where username=:username and password=:password");
        $query->BindParam(":username",$username);
        $query->BindParam(":password",$password);
        $query->execute();
        $qu=$query->rowCount();
        if ($qu>0){
            $query=$query->fetch();
            $_SESSION['id_user']=$query['id_user'];
            $_SESSION['username']=$query['username'];
            $_SESSION['level']=$query['level'];
            $_SESSION['info']="Selamat Datang ".$_SESSION['username']."...!!!";
           header('location:index.php');
        }
        else{
            $_SESSION['info']="Login gagal, Username dan Password tidak valid...!!!";
            
        }
    }

if (!empty($_GET['id']) and $_GET['id']=="login"){
    $_SESSION['info']="Silahkan login...!!!";
}


if (!empty($_GET['id']) and $_GET['id']=="keluar"){
    session_destroy();
    $_SESSION['info']="Anda telah keluar...!!!";
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Andoeang Adventure</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-fixed-top.css" rel="stylesheet">
    <script src="dist/js/jquery.min.js"></script>

    <style>
        .img{
            opacity: 0.8;
        }
        .img:hover{
            opacity: 1;
        }
        body{
            font-family: arial;
            font-size: 16px;
        }
        .container{
            width: 100%;
        }
    </style>
  </head>

  <body style="background: rgb(60, 7, 104) none repeat scroll 0% 0%;">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Andoeang Adventure</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Beranda</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#peraturan">Peraturan Sewa</a></li>
            <li><a href="#cara-booking">Cara Booking</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          	<?php if (!empty($_SESSION['id_user'])){
                if ($_SESSION['level']=="admin"){
                    ?>
                    <li><a href="administrator.php">Administrator</a></li>
                    <?php
                    }else{ ?>
          	         <li><a href="keranjang.php">Keranjang</a></li>
                <?php } ?>
          	<li><a href="?id=keluar">Logout</a></li>
          	<?php }else{ ?>
            <li><a href="#modal-login" data-toggle="modal" data-target="#modal-login">Login</a></li>
            <li class="active"><a href="#modal-daftar" data-toggle="modal" data-target="#modal-daftar">Daftar<span class="sr-only">(current)</span></a></li>
            <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<?php if (!empty($_SESSION['info'])){ ?>
<br>
    <div class="container">
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong><?php echo $_SESSION['info']; ?></strong>
                  </div>
    </div>
<?php unset($_SESSION['info']); } ?>
    <div class="jumbotron" style="margin: 0; padding: 0;">
        <img src="gambar/head.jpg" style="width: 100%; max-height: 300px;" />
    </div>
    <div class="container" style="background: #eee;">
    <?php
    $query=$con->prepare("select * from tbl_alat where stock>'0' order by nama_alat asc");
    $query->execute();
    $res=$query->fetchAll();
    foreach ($res as $r) {
    ?>
    	<div class="col-md-3 col-sm-6 col-xs-12" style="box-shadow: 10px 10px 5px #ccc;">
    		<div style="width: 100%; height: 160px; margin-bottom: 0; margin-top: 20px;">
    			<a target="_blank" href="gambar/<?php echo $r['foto']; ?>">
                <img class="img" style="width: 100%; height: 160px;" src="gambar/<?php echo $r['foto']; ?>">
    		      </a>
            </div>
    		<div style="width: 100%; height: 160px; background: #eee; font-family: verdana; color: rgb(10, 127, 152); margin-bottom: 20px;">
    			<div style="margin: 0; padding: 5px;">
    			<h4 style="margin-top: 5;"><?php echo $r['nama_alat']; ?></h4>
    			<h3 style="margin-top: 5px;">Rp.<?php echo number_format($r['biaya_sewa'],0,".","."); ?> / Hari</h3>
    			<p>Stock : <?php echo $r['stock'].' '.$r['satuan']; ?></p>
    			<a class="btn btn-danger" href="?cart_plus=<?php echo $r['id_alat']; ?>">Add To Cart</a>
    			</div>
    		</div>
    	</div>
    <?php } ?>
    <div class="row" style="margin-bottom: 20px;"></div>
    </div>

    <div class="container" style="background: rgb(0, 176, 163) none repeat scroll 0% 0%; color: #fff;">
    <div class="col-md-12" id="cara-booking">
    <br><br><br><br>
    <h3>Cara Booking</h3>
    	Ada 3 cara untuk melakukan booking alat di Andoeang Adventure.
    	<ol>
    		<li>Kunjungi situs Andoeang Adventure</li>
    		<ul>
    			<li>Daftar(jika belum punya akun) dan Login</li>
    			<li>Tambahkan alat yang akan dibooking ke keranjang</li>
    			<li>Isi formulir booking alat</li>
    			<li>Setelah itu lakukan pembayaran</li>
    		</ul>
    		<li>Datang langsung ke alamat kami</li>
    		<li>Hubungi CS Andoeang Adventure</li>
    	</ol>
        Untuk pembayaran Via Transfer Bank Silahkan Transfer Ke Rekening Berikut :<br>
        Nama Rekening : Nengki Rahmat<br>
        No Rekening : 009101012649538 (BRI)<br>
    <br><br><br><br>
    </div>
    </div>

    <div class="container" style="background: rgb(209, 0, 118) none repeat scroll 0% 0%; color: #fff;">
    <div class="col-md-12" id="peraturan">
    <br><br><br><br>
    <h3>Peraturan Sewa</h3>
    <p>Sebelum menyewa, ada beberapa peraturan yang harus diikuti oleh calon penyewa alat camping.</p>
    <ul>
    	<li>WAJIB menjaminkan identitas diri yang masih berlaku, seperti KTP/SIM/PASPOR/STNK.</li>
    	<li>Keterlambatan pengembalian akan dihitung sebagai penambahan waktu penyewaan.</li>
    	<li>Kerusakan atau kehilangan peralatan yang disewa sepenuhnya adalah tanggung Jawab penyewa.</li>
    	<li>Booking dianggap sah apabila sudah melakukan pembayaran minimal 50% dari total biaya sewa.</li>
		<li>Uang DP yg sudah dibayarkan tidak dapat di kembalikan apabila ada pembatalan pemakaian secara sepihak kecuali 3 hari sebelum hari H kalau mau uang kembali.</li>
		<li>Disarankan booking dan DP terlebih dahulu minimal semingu sebelum pemakaian karna kami akan
prioritaskan barang yg anda sudah pesan dan di DP, kami tidak menjamin kalau anda blum DP pada saat
pengambilan barangnya sudah disewa pihak lain atau barang tidak ada (Kosong).</li>
		<li>Segala bentuk penipuan akan kami serahkan kepada pihak yang berwenang.</li>
    </ul>
    <br><br><br><br><br>
    </div>
    </div>
<div class="container" style="background:rgb(121, 174, 1) none repeat scroll 0% 0%; color: #fff;">
<div class="col-md-12" id="contact">
<br><br><br><br>
<h3>Contact</h3>
<blockquote>
CS Andoeang Adventure<br>
HP/WA: 0857-6772-0388<br>
Nama Rekening : Nengki Rahmat<br>
No Rekening : 009101012649538 (BRI)<br>
Atau Datang Langsung ke alamat kami :
Jl. Lintas Sumatera KM 4, Jorong Sawah Ilie, Nagari Saok Laweh, Kec. Kubung, Kab. Solok, Provinsi Sumatera Barat</blockquote>
<br><br><br><br>
    </div>
    </div> <!-- /container -->


    <div class="row">
                  <div class="modal fade" id="modal-daftar" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content" style="background: rgb(0, 137, 117) none repeat scroll 0% 0%; color: white;">
                      <form action="#" method="POST">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Pendaftaran</h4>
                        </div>
                        <div class="modal-body">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" required="" name="nama_lengkap"><br>
                        <label>Telpon / HP</label>
                        <input type="text" class="form-control" name="hp"><br>
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control"></textarea><br>
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"><br>
                        <label>Username</label>
                        <input type="text" class="form-control" required="" name="username"><br>
                        <label>Password</label>
                        <input type="password" class="form-control" required="" name="password"><br>
                        <label>Ulangi Password</label>
                        <input type="password" class="form-control" required="" name="repassword"><br>
                        </div>
                        <div class="modal-footer">
                        <input type="submit" name="daftar" class="btn btn-success" value="Daftar">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
    </div>

    

    <div class="row">
                  <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content" style="background: rgb(0, 137, 117) none repeat scroll 0% 0%; color: white;">
                      <form action="#" method="POST">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Silahkan Login...</h4>
                        </div>
                        <div class="modal-body">
                        <label>Username</label>
                        <input type="text" class="form-control" required="" name="username">
                        <label>Password</label>
                        <input type="password" class="form-control" required="" name="password">
                        </div>
                        <div class="modal-footer">
                          <input type="submit" class="btn btn-success" name="login" value="Login">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <a style="color: #fff;" href="reset.php?reset=true">Lupa Password?</a>
                        </div>
                        </form>

                      </div>
                    </div>
                  </div>
    </div>
<nav class="navbar navbar-inverse navbar-static-bottom" style="color: white; padding: 12px; border-radius: 0; margin-bottom: 0; border:0; "><center>Copyright &copy; Andoeang Adventure - <?php echo date('Y'); ?> All Right Reserved</center></nav>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>
