<?php 
include "koneksi.php";
if (isset($_POST['booking'])){
	$id_user=$_SESSION['id_user'];
	$query=$con->prepare("select * from tbl_keranjang where id_user='$id_user' and status='Menunggu'");
	$query->execute();
	$cek=$query->rowCount();
	if ($cek>0){
	$query=$query->fetchAll();
	$n=1;
	foreach ($query as $qu) {
		$id_alat=$qu['id_alat'];
			if ($n<=1){
				$tgl_mulai=$_POST['tgl_mulai'];
		$tgl_akhir=$_POST['tgl_akhir'];
		$selisih = ((abs(strtotime ($tgl_mulai) - strtotime ($tgl_akhir)))/(60*60*24));
		$jml_hari=$selisih;
		if ($jml_hari<1){
			$jml_hari=1;
		}
		$qy=$con->prepare("select sum(biaya_sewa*jml_sewa) as total from tbl_keranjang where id_user='$id_user' and status='Menunggu'");
		$qy->execute();
		$qy=$qy->fetch();
		$total=$qy['total'] * $jml_hari;
		$status="Menunggu Pembayaran";
		$date=date('Y-m-d');
		$metode=$_POST['metode'];
		$query=$con->prepare("insert into tbl_pinjam values ('','$tgl_mulai','$tgl_akhir','$jml_hari','$metode','$total','0','$status','$id_user','$date')");
		$query->execute();
			$_SESSION['info']="Booking anda Telah disimpan, Menunggu Proses Pembayaran";
			}
		$cek_idpinjam=$con->prepare("select id_pinjam from tbl_pinjam where id_user=:id_user and status='Menunggu Pembayaran' order by id_pinjam desc");
		$cek_idpinjam->BindParam(":id_user",$id_user);
		$cek_idpinjam->execute();
		$res=$cek_idpinjam->fetch();
		$id_pinjam=$res['id_pinjam'];
		$query=$con->prepare("update tbl_keranjang set id_pinjam=:id_pinjam,status='Menunggu Pembayaran' where id_user='$id_user' and id_alat='$id_alat' and status='Menunggu'");
		$query->BindParam(":id_pinjam",$id_pinjam);
		$query->execute();
		$n++;
}
}else{
	$_SESSION['info']="Gagal di Proses, data keranjang tidak ada...!!!";
	header('location:keranjang.php');
}
}
include "pro_keranjang.php";
include "head.php";
?>
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 id="title2">Keranjang</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  

<script>
	document.getElementById('title1').innerHTML="Keranjang";
	document.getElementById('title2').innerHTML="Keranjang";
</script>
<div class="col-md-12">
<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>Id Alat</th>
		<th>Nama Alat</th>
		<th>Stock Tersedia</th>
		<th>Biaya Sewa</th>
		<th>Jumlah Sewa</th>
		<th>Sub Total</th>
		<th>Foto Alat</th>
		<th>Aksi</th>
	</tr>
	</thead>
	<tbody>
		<?php
		$id_user=$_SESSION['id_user'];
		$query=$con->prepare("select tbl_alat.nama_alat,tbl_alat.biaya_sewa,tbl_alat.stock,tbl_alat.foto,tbl_keranjang.id_keranjang,tbl_keranjang.id_alat,tbl_keranjang.jml_sewa from tbl_alat,tbl_keranjang where tbl_keranjang.id_alat=tbl_alat.id_alat and tbl_keranjang.id_user='$id_user' and tbl_keranjang.status='Menunggu' order by nama_alat asc");
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_alat']; ?></td>
				<td><?php echo $res['nama_alat']; ?></td>
				<td align="center"><?php echo $res['stock']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['biaya_sewa'],0,".","."); ?></td>
				<td align="center"><?php echo $res['jml_sewa']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['biaya_sewa']*$res['jml_sewa'],0,".","."); ?></td>
				<td align="center"><img style="width: 80px; height: 60px;" src="gambar/<?php echo $res['foto']; ?>"></td>
				<td>
				<form action="pro_keranjang.php" method="POST">
					<input type="hidden" name="id_keranjang" value="<?php echo $res['id_keranjang']; ?>">
					<input type="number" name="jumlah" value="<?php echo $res['jml_sewa']; ?>" size="2">
					<input class="btn btn-primary btn-xs" type="submit" name="update_keranjang" value="Update">
				</form>
				<a class="btn btn-danger btn-xs" href="keranjang.php?kurang=<?php echo $res['id_keranjang']; ?>">-1</a>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div>
<div class="col-md-6"><a class="btn btn-info" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> Lanjutkan Pilih Barang</a></div><div class="col-md-6">
	<form action="#" method="POST">
	<h2>Proses Booking</h2>
	* Minimal peminjaman 2 hari.<br>
	* Setelah melakukan Booking, silahkan lakukan pembayaran minimal DP 50% dari total biaya, jika dalam waktu 1 hari belum dibayar maka kami tidak bisa memastikan barang yang anda pilih masih tersedia atau tidak.<br><br>
		       <div class="form-group">
					<label>Tanggal Penjemputan</label>
					<div class="input-group date" id="tgl1">
						<input type="date" name="tgl_mulai" required="required" class="form-control aa"/>	
							<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
				<div class="form-group">
					<label>Tanggal Pengembalian</label>
					<div class="input-group date" id="tgl2">
						<input type="date" name="tgl_akhir" required="required" class="form-control" />	
							<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
				<div class="form-group">
					<label>Jumlah Hari</label>
						<input type="text" name="jml_hari" class="form-control" id="selisih" required="required" readonly="readonly" />	
				</div>
				<div class="form-group">
					<label>Metode Bayar</label><br>
						<input type="radio" name="metode" onclick="rek();" value="Bank Transfer"> Bank Transfer <input type="radio" name="metode" onclick="lsg();" value="Bayar Langsung"> Bayar Langsung	
				</div>
				<div class="rek" style="display: none;">
					<h4>Lakukan Pembayaran ke Rekening Dibawah ini</h4>
					Nama Rekening : Rudi Harianto<br>
					No Rekening : 0091010198754565 (BRI)<br>
				</div>
				<script>
					function rek(){
						$(".rek").css('display','block');
					}
					function lsg(){
						$(".rek").css('display','none');
					}
				</script>
				<?php
				$id_user=$_SESSION['id_user'];
				$query=$con->prepare("select sum(biaya_sewa*jml_sewa) as total from tbl_keranjang where id_user='$id_user' and status='Menunggu'");
				$query->execute();
				$query=$query->fetch();
				?>
					<input type="hidden" name="sub_total" value="<?php echo $query['total']; ?>" id="st">
				
				<div class="form-group">
				<input type="hidden" name="total" id="gtotal">
				<label><h2>Total Biaya Rp.<span style="color: darkred;" id="total">
				<?php echo number_format($query['total'],0,".","."); ?></span></h2></label>
				</div>
				<div class="form-group">
					<input class="btn btn-danger" type="submit" name="booking" value="Booking">
				</div>
				
	</form>
</div>

<div class="col-md-12">
<div class="x_title">
<h2 id="title2">History Peminjaman</h2>
<div class="clearfix"></div>
</div>
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
		$id_user=$_SESSION['id_user'];
		$query=$con->prepare("select * from tbl_pinjam,tbl_user where tbl_pinjam.id_user=tbl_user.id_user and tbl_pinjam.id_user=:id_user order by id_pinjam desc");
		$query->BindParam(":id_user",$id_user);
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
				<a class="btn btn-success btn-xs" href="?keranjang_booking=<?php echo $res['id_pinjam']; ?>">Keranjang Booking</a>
				<a class="btn btn-info btn-xs" target="_blank" href="faktur.php?id_pinjam=<?php echo $res['id_pinjam']; ?>">Cetak</a>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div>
<?php if (empty($_GET['keranjang_booking'])){ ?>
<div class="col-md-12">
<div class="x_title">
<h2 id="title2">History Keranjang</h2>
<div class="clearfix"></div>
</div>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>Id Keranjang</th>
		<th>Id Pinjam</th>
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
		$id_user=$_SESSION['id_user'];
		$query=$con->prepare("select tbl_keranjang.id_pinjam,tbl_keranjang.id_keranjang,tbl_alat.nama_alat,tbl_alat.biaya_sewa,tbl_alat.stock,tbl_alat.foto,tbl_keranjang.id_alat,tbl_keranjang.jml_sewa,tbl_keranjang.status from tbl_alat,tbl_keranjang where tbl_keranjang.id_alat=tbl_alat.id_alat and tbl_keranjang.id_user='$id_user' and tbl_keranjang.status<>'Menunggu' order by tbl_keranjang.id_keranjang desc");
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_keranjang']; ?></td>
				<td align="center"><?php echo $res['id_pinjam']; ?></td>
				<td align="center"><img style="width: 80px; height: 60px;" src="gambar/<?php echo $res['foto']; ?>"></td>
				<td align="center"><?php echo $res['id_alat']; ?></td>
				<td><?php echo $res['nama_alat']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['biaya_sewa'],0,".","."); ?></td>
				<td align="center"><?php echo $res['jml_sewa']; ?></td>
				<td align="center">
					<?php echo $res['status']; ?>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div>
<?php } ?>

<?php if (!empty($_GET['keranjang_booking'])){ ?>
					<div class="x_title">
                    <h2 id="title2">Keranjang Booking</h2>
                    <div class="clearfix"></div>
                  	</div>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>Id Keranjang</th>
		<th>Id Pinjam</th>
		<th>Foto Alat</th>
		<th>Id Alat</th>
		<th>Nama Alat</th>
		<th>Biaya Sewa</th>
		<th>Jumlah Sewa</th>
	</tr>
	</thead>
	<tbody>
		<?php
		$id_pinjam=$_GET['keranjang_booking'];
		$query=$con->prepare("select tbl_keranjang.id_pinjam,tbl_keranjang.id_keranjang,tbl_alat.nama_alat,tbl_alat.biaya_sewa,tbl_alat.stock,tbl_alat.foto,tbl_keranjang.id_alat,tbl_keranjang.jml_sewa,tbl_keranjang.status from tbl_alat,tbl_keranjang where tbl_keranjang.id_alat=tbl_alat.id_alat and tbl_keranjang.id_pinjam='$id_pinjam' order by id_pinjam desc");
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_keranjang']; ?></td>
				<td align="center"><?php echo $res['id_pinjam']; ?></td>
				<td align="center"><img style="width: 80px; height: 60px;" src="gambar/<?php echo $res['foto']; ?>"></td>
				<td align="center"><?php echo $res['id_alat']; ?></td>
				<td><?php echo $res['nama_alat']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['biaya_sewa'],0,".","."); ?></td>
				<td align="center"><?php echo $res['jml_sewa']; ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<?php } ?>
					</div>
                </div>
              </div>
            </div>
<?php include "footer.php"; ?>
