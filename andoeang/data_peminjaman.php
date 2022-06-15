<?php 
include "koneksi.php";
if (isset($_POST['update'])){
$id_keranjang=$_POST['id_keranjang'];
$id_alat=$_POST['id_alat'];
$jml_kembali=$_POST['jml_kembali'];
$query=$con->prepare("select * from tbl_alat where id_alat=:id_alat");
$query->BindParam(":id_alat",$id_alat);
$query->execute();
$query=$query->fetch();
if ($query['stock']<=0){
	$stock=$jml_kembali;
}else{
	$stock=$jml_kembali+$query['stock'];
}
$query=$con->prepare("update tbl_alat set stock=:stock where id_alat=:id_alat");
$query->BindParam(":stock",$stock);
$query->BindParam(":id_alat",$id_alat);
$query->execute();
$query=$con->prepare("select * from tbl_keranjang where id_keranjang=:id_keranjang");
$query->BindParam(":id_keranjang",$id_keranjang);
$query->execute();
$query=$query->fetch();
$jml_pinjam=$query['jml_sewa'];
$query=$con->prepare("select * from tbl_kembali where id_keranjang=:id_keranjang");
$query->BindParam(":id_keranjang",$id_keranjang);
$query->execute();
$query=$query->fetch();
$kembali=$query['jml_kembali'];
$kembali=$kembali+$jml_kembali;
if ($kembali>=$jml_pinjam){
  $query=$con->prepare("update tbl_keranjang set status='Selesai' where id_keranjang=:id_keranjang");
  $query->BindParam(":id_keranjang",$id_keranjang);
  $query->execute();
  $query=$con->prepare("select * from tbl_kembali where id_keranjang=:id");
  $query->BindParam(":id",$id_keranjang);
  $query->execute();
  if ($query->rowCount()<=0){
  date_default_timezone_set('asia/jakarta');
  $date=date('Y-m-d h:i:s');
  $query=$con->prepare("insert into tbl_kembali values('',:id_keranjang,:jml_sewa,:jml_kembali,'$date')");
  $query->BindParam(":id_keranjang",$id_keranjang);
  $query->BindParam(":jml_sewa",$jml_pinjam);
  $query->BindParam(":jml_kembali",$jml_kembali);
  $query->execute();
  }else{
    date_default_timezone_set('asia/jakarta');
  $date=date('Y-m-d h:i:s');
  $query=$con->prepare("update tbl_kembali set jml_kembali=:kembali where id_keranjang=:id");
  $query->BindParam(":id",$id_keranjang);
  $query->BindParam(":kembali",$kembali);
  $query->execute();
  $_SESSION['info']="Berhasil Dikembalikan (jumlah ".$kembali.")...!!!";
  }
}
else{
  $query=$con->prepare("select * from tbl_kembali where id_keranjang=:id");
  $query->BindParam(":id",$id_keranjang);
  $query->execute();
  if ($query->rowCount()<=0){
  date_default_timezone_set('asia/jakarta');
  $date=date('Y-m-d h:i:s');
  $query=$con->prepare("insert into tbl_kembali values('',:id_keranjang,:jml_sewa,:jml_kembali,'$date')");
  $query->BindParam(":id_keranjang",$id_keranjang);
  $query->BindParam(":jml_sewa",$jml_pinjam);
  $query->BindParam(":jml_kembali",$jml_kembali);
  $query->execute();
  }else{
    date_default_timezone_set('asia/jakarta');
  $date=date('Y-m-d h:i:s');
  $query=$con->prepare("update tbl_kembali set jml_kembali=:kembali where id_keranjang=:id");
  $query->BindParam(":id",$id_keranjang);
  $query->BindParam(":kembali",$kembali);
  $query->execute();
  $_SESSION['info']="Berhasil Dikembalikan (jumlah ".$kembali.")...!!!";
  }
}
}


if (isset($_POST['proses_bayar'])){
	$id_pinjam=$_POST['id_pinjam'];
	$jml_bayar=$_POST['jml_bayar'];
	$cek=$con->prepare("select id_user,total_biaya,jml_bayar,status from tbl_pinjam where id_pinjam=:id_pinjam");
	$cek->BindParam(":id_pinjam",$id_pinjam);
	$cek->execute();
	$res=$cek->fetch();
	$id_user=$res['id_user'];
	$telah_bayar=$res['jml_bayar'];
	$total=$telah_bayar+$jml_bayar;
	if ($total<$res['total_biaya']){
		$status="Belum Lunas";
	}
	else{
		$status="Lunas";
	}
	$query=$con->prepare("update tbl_pinjam set jml_bayar=:jml_bayar,status=:status where id_pinjam=:id_pinjam");
	$query->BindParam(":id_pinjam",$id_pinjam);
	$query->BindParam(":jml_bayar",$total);
	$query->BindParam(":status",$status);
	$query->execute();
	$_SESSION['info']="Pembayaran telah disimpan,total bayar Rp.".number_format($total,0,".",".")."...!!!";
	$cek=$con->prepare("select * from tbl_keranjang  where id_user=:id_user and status='Menunggu Pembayaran' order by id_keranjang desc");
	$cek->BindParam(":id_user",$id_user);
	$cek->execute();
	$res=$cek->fetch();
	if ($res['status']=="Menunggu Pembayaran"){
		$query=$con->prepare("update tbl_keranjang set status='Booking' where id_user=:id_user and status='Menunggu Pembayaran'");
				$query->BindParam(":id_user",$id_user);
				$query->execute();
	}

}
include "head.php";
include "pro_keranjang.php";
?>
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 id="title2">Data Booking</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
<?php

if (!empty($_GET['proses'])){
	?>
<script>
	document.getElementById('title1').innerHTML="Pembayaran Booking Alat";
	document.getElementById('title2').innerHTML="Pembayaran Booking Alat";
</script>
<div class="col-md-3"></div><div class="col-md-6">
	<?php
	$id_pinjam=$_GET['proses'];
	$query=$con->prepare("select tbl_pinjam.metode,tbl_pinjam.id_pinjam,tbl_user.username,tbl_pinjam.tgl_mulai,tbl_pinjam.tgl_akhir,tbl_pinjam.jml_hari,tbl_pinjam.total_biaya,tbl_pinjam.jml_bayar,tbl_pinjam.status from tbl_pinjam,tbl_user where tbl_pinjam.id_user=tbl_user.id_user and tbl_pinjam.id_pinjam=:id_pinjam");
	$query->BindParam(":id_pinjam",$id_pinjam);
	$query->execute();
	$query=$query->fetch();
	?>
	<form action="#" method="POST">
	<table style="font-size: 18px;" class="table table-striped table-bordered dt-responsive nowrap">
		<thead>
			<tr>
				<td align="center" colspan="2">Pembayaran Booking Alat</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Id Pinjam</td><td><?php echo $query['id_pinjam']; ?></td>
				<input type="hidden" name="id_pinjam" value="<?php echo $query['id_pinjam']; ?>">
			</tr>
			<tr>
				<td>Username</td><td><?php echo $query['username']; ?></td>
			</tr>
			<tr>
				<td>Tgl Mulai</td><td><?php echo $query['tgl_mulai']; ?></td>
			</tr>
			<tr>
				<td>Tgl Akhir</td><td><?php echo $query['tgl_akhir']; ?></td>
			</tr>
			<tr>
				<td>Total Hari</td><td><?php echo $query['jml_hari']; ?></td>
			</tr>
			<tr>
				<td>Metode Bayar</td><td><?php echo $query['metode']; ?></td>
			</tr>
			<tr>
				<td>Total Biaya</td><td>Rp.<?php echo number_format($query['total_biaya'],0,".","."); ?></td>
			</tr>
			<tr>
				<td>Telah Dibayar</td><td>Rp.<?php echo number_format($query['jml_bayar'],0,".","."); ?></td>
			</tr>
			<tr>
				<td>Sisa Pembayaran</td><td>Rp.<?php $sisa=$query['total_biaya']-$query['jml_bayar']; echo number_format($sisa,0,".","."); ?></td>
			</tr>
			<?php if ($query['jml_bayar']<$query['total_biaya']){ ?>
			<tr>
				<td>Masukkan Jumlah Bayar</td><td><input type="text" class="form-control" required="" name="jml_bayar"></td>
			</tr>
			<?php } ?>
			<tr>
				<td>Status</td><td><?php echo $query['status']; ?></td>
			</tr>
			
			<tr>
				<td colspan="2">
				<?php if ($query['status']<>"Lunas"){ ?>
				<input type="submit" name="proses_bayar" class="btn btn-primary" value="Proses">
				<?php } ?>
				<a class="btn btn-info btn-sm" target="_blank" href="faktur.php?id_pinjam=<?php echo $query['id_pinjam']; ?>">Cetak</a>
				</td>
			</tr>
			
		</tbody>
	</table>
	</form>
</div><div class="col-md-3"></div>
	<?php
}

?>
<?php if (empty($_GET['keranjang_booking']) and empty($_GET['proses'])){ ?>
<script>
	document.getElementById('title1').innerHTML="Data Booking";
	document.getElementById('title2').innerHTML="Data Booking";
</script>
<div class="col-md-12">
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
		<th>Id Pinjam</th>
		<th>Username</th>
		<th>Tgl Mulai</th>
		<th>Tgl Akhir</th>
		<th>Total Hari</th>
		<th>Metode Bayar</th>
		<th>Total Biaya</th>
		<th>Telah Dibayar</th>
		<th>Status</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		<?php
		$query=$con->prepare("select * from tbl_pinjam,tbl_user where tbl_pinjam.id_user=tbl_user.id_user order by id_pinjam desc");
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_pinjam']; ?></td>
				<td align="center"><?php echo $res['username']; ?></td>
				<td align="center"><?php echo $res['tgl_mulai']; ?></td>
				<td align="center"><?php echo $res['tgl_akhir']; ?></td>
				<td align="center"><?php echo $res['jml_hari']; ?></td>
				<td align="center"><?php echo $res['metode']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['total_biaya'],0,".","."); ?></td>
				<td align="right">Rp.<?php echo number_format($res['jml_bayar'],0,".","."); ?></td>
				<td align="center"><?php echo $res['status']; ?></td>
				<td align="center">
				<?php if ($res['status']<>"Lunas"){ ?>
					<a class="btn btn-primary btn-xs" href="?proses=<?php echo $res['id_pinjam']; ?>">Proses</a>
				<?php } ?>
				<a class="btn btn-success btn-xs" href="?keranjang_booking=<?php echo $res['id_pinjam']; ?>">Keranjang Booking</a>
				<a class="btn btn-info btn-xs" target="_blank" href="faktur.php?id_pinjam=<?php echo $res['id_pinjam']; ?>">Cetak</a>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<?php } ?>
<?php
if (!empty($_GET['keranjang_booking'])){
$id_pinjam=$_GET['keranjang_booking'];
?>
<script>
	document.getElementById('title1').innerHTML="Keranjang Booking";
	document.getElementById('title2').innerHTML="Keranjang Booking";
</script>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
		<th>Id Pinjam</th>
		<th>Username</th>
		<th>Tgl Mulai</th>
		<th>Tgl Akhir</th>
		<th>Total Hari</th>
		<th>Metode Bayar</th>
		<th>Total Biaya</th>
		<th>Telah Dibayar</th>
		<th>Status</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		<?php
		$query=$con->prepare("select * from tbl_pinjam,tbl_user where tbl_pinjam.id_pinjam=:id_pinjam and tbl_user.id_user=tbl_pinjam.id_user");
		$query->BindParam(":id_pinjam",$id_pinjam);
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_pinjam']; ?></td>
				<td align="center"><?php echo $res['username']; ?></td>
				<td align="center"><?php echo $res['tgl_mulai']; ?></td>
				<td align="center"><?php echo $res['tgl_akhir']; ?></td>
				<td align="center"><?php echo $res['jml_hari']; ?></td>
				<td align="center"><?php echo $res['metode']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['total_biaya'],0,".","."); ?></td>
				<td align="right">Rp.<?php echo number_format($res['jml_bayar'],0,".","."); ?></td>
				<td align="center"><?php echo $res['status']; ?></td>
				<td align="center">
				<?php if ($res['status']<>"Lunas"){ ?>
					<a class="btn btn-primary btn-xs" href="?proses=<?php echo $res['id_pinjam']; ?>">Proses</a>
				<?php } ?>
				
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

					<div class="x_title">
                    <h2 id="title2">Keranjang Booking</h2>
                    <div class="clearfix"></div>
                  	</div>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>Id Keranjang</th>
		<th>Foto Alat</th>
		<th>Id Alat</th>
		<th>Nama Alat</th>
		<th>Biaya Sewa</th>
		<th>Jumlah Sewa</th>
		<th>Aksi</th>
	</tr>
	</thead>
	<tbody>
		<?php
		$query=$con->prepare("select tbl_keranjang.id_keranjang,tbl_alat.nama_alat,tbl_alat.biaya_sewa,tbl_alat.stock,tbl_alat.foto,tbl_keranjang.id_alat,tbl_keranjang.jml_sewa,tbl_keranjang.status from tbl_alat,tbl_keranjang where tbl_keranjang.id_alat=tbl_alat.id_alat and tbl_keranjang.id_pinjam='$id_pinjam' order by id_pinjam desc");
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_keranjang']; ?></td>
				<td align="center"><img style="width: 80px; height: 60px;" src="gambar/<?php echo $res['foto']; ?>"></td>
				<td align="center"><?php echo $res['id_alat']; ?></td>
				<td><?php echo $res['nama_alat']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['biaya_sewa'],0,".","."); ?></td>
				<td align="center"><?php echo $res['jml_sewa']; ?></td>
				<td>
					<?php if ($res['status']=="Booking"){ ?>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal<?php echo $res['id_keranjang']; ?>">Pengembalian</button>
					<?php }else if ($res['status']=="Menunggu Pembayaran"){ echo $res['status']; }else{ echo "Selesai"; } ?>

					<div class="row">
                  <div class="modal fade" id="modal<?php echo $res['id_keranjang']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                      <form action="#" method="POST">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Pengembalian Alat</h4>
                        </div>
                        <div class="modal-body">
                        <label>Id Keranjang</label><br>
                          <input type="text" name="id_keranjang" required="" readonly="" value="<?php echo $res['id_keranjang']; ?>" style="width: 100%;" class="form-control"><br>
                          <label>Id Alat</label><br>
                          <input type="text" name="id_alat" required="" readonly="" value="<?php echo $res['id_alat']; ?>" style="width: 100%;" class="form-control"><br>
                        <label>Nama Alat</label><br>
                          <input type="text" name="nama" required="" readonly="" value="<?php echo $res['nama_alat']; ?>"  style="width: 100%;" class="form-control"><br>
                        <label>Jumlah Pinjam</label><br>
                          <input type="text" name="jml_pinjam" required="" readonly="" value="<?php echo $res['jml_sewa']; ?>"  style="width: 100%;" class="form-control"><br>
                        <label>Jumlah Dikembalikan</label><br>
                          <input type="text" name="jml_kembali" required=""  style="width: 100%;" class="form-control">
                        <?php
                        $id_keranjang=$res['id_keranjang'];
                        $query=$con->prepare("select jml_kembali from tbl_kembali where id_keranjang=:id_keranjang");
                        $query->BindParam(":id_keranjang",$id_keranjang);
                        $query->execute();
                        $jml=$query->fetch();
                        ?>
                        <label>Telah Dikembalikan</label><br>
                          <input type="text" name="telah_kembali" readonly="" value="<?php echo $jml['jml_kembali']; ?>" required=""  style="width: 100%;" class="form-control">
                        </div>
                        <div class="modal-footer">
                          <input type="submit" name="update" value="Update Alat" class="btn btn-primary">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
</div>

				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<?php
}
?>
</div>
					</div>
                </div>
              </div>
            </div>
<?php
include "footer.php";
?>