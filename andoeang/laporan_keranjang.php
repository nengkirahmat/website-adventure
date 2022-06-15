<?php 
include "koneksi.php";
include "head.php";
?>

<div class="col-md-12">
			<?php
		if (isset($_POST['tampilkan'])){
			if (!empty($_POST['id_pinjam']) and empty($_POST['status'])){
			$id_pinjam=$_POST['id_pinjam'];
			$query=$con->prepare("select tbl_keranjang.id_pinjam,tbl_keranjang.id_keranjang,tbl_alat.nama_alat,tbl_alat.biaya_sewa,tbl_alat.stock,tbl_alat.foto,tbl_keranjang.id_alat,tbl_keranjang.jml_sewa,tbl_keranjang.status from tbl_alat,tbl_keranjang where tbl_keranjang.id_alat=tbl_alat.id_alat and tbl_keranjang.status<>'Menunggu' and tbl_keranjang.status<>'Menunggu Pembayaran' and id_pinjam=:id_pinjam order by id_pinjam desc");
			$query->BindParam(":id_pinjam",$id_pinjam);
			$query->execute();
	
			}else if (empty($_POST['id_pinjam']) and !empty($_POST['status'])){
			$status=$_POST['status'];
			$query=$con->prepare("select tbl_keranjang.id_pinjam,tbl_keranjang.id_keranjang,tbl_alat.nama_alat,tbl_alat.biaya_sewa,tbl_alat.stock,tbl_alat.foto,tbl_keranjang.id_alat,tbl_keranjang.jml_sewa,tbl_keranjang.status from tbl_alat,tbl_keranjang where tbl_keranjang.id_alat=tbl_alat.id_alat and tbl_keranjang.status<>'Menunggu' and tbl_keranjang.status<>'Menunggu Pembayaran' and status=:status order by id_pinjam desc");
			$query->BindParam(":status",$status);
			$query->execute();	
		
		}else{
		$query=$con->prepare("select tbl_keranjang.id_pinjam,tbl_keranjang.id_keranjang,tbl_alat.nama_alat,tbl_alat.biaya_sewa,tbl_alat.stock,tbl_alat.foto,tbl_keranjang.id_alat,tbl_keranjang.jml_sewa,tbl_keranjang.status from tbl_alat,tbl_keranjang where tbl_keranjang.id_alat=tbl_alat.id_alat and tbl_keranjang.status<>'Menunggu' and tbl_keranjang.status<>'Menunggu Pembayaran' order by id_pinjam desc");
		$query->execute();
	
}
	?>
<script>window.print();</script>	
	<div class="x_title">
    <center>
<h1>Andoeang Adventure</h1>
<h3>Laporan Keranjang</h3>
<h4><?php if (!empty($status)){ echo "Status : ".$status; }else if (!empty($id_pinjam)){ echo "ID Pinjam : ".$id_pinjam; } ?></h4>
<i>Alamat : Canduang, Telpon : 08123456789, Fax : 454545, Kode Pos : 4544656</i>
</center>
<hr style="margin-top: 10px; margin-bottom: 0;">
<hr style="margin-top: 0; margin-bottom: 10px;">	
    </div>
<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>Id Pinjam</th>
		<th>Id Keranjang</th>
		<th>Foto Alat</th>
		<th>Id Alat</th>
		<th>Nama Alat</th>
		<th>Biaya Sewa</th>
		<th>Jumlah Sewa</th>
		<th>Status</th>
	</tr>
	</thead>
	<tbody>
<?php
		$rc=0;
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_pinjam']; ?></td>
				<td align="center"><?php echo $res['id_keranjang']; ?></td>
				<td align="center"><img style="width: 80px; height: 60px;" src="gambar/<?php echo $res['foto']; ?>"></td>
				<td align="center"><?php echo $res['id_alat']; ?></td>
				<td><?php echo $res['nama_alat']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['biaya_sewa'],0,".","."); ?></td>
				<td align="center"><?php echo $res['jml_sewa']; ?></td>
				<td><?php echo $res['status']; ?></td>
			</tr>
			<?php
		$rc+=1; }
		?>
	</tbody>
</table>
<div style="float:left; margin-left: 30px;"><br>
	Total Data : <?php echo $rc; ?>
</div>
<div style="float: right; margin-right: 50px;">
<br><br>
	Canduang,<?php echo date('d-M-Y'); ?>
	<br><br><br><br>
	<center><?php echo strtoupper($_SESSION['username']); ?></center>
</div>

	<?php
	}else{
		?>
		<div class="col-md-4">
	<form action="#" method="POST">
	<label>Id Peminjaman</label>
		<input type="text" class="form-control" name="id_pinjam" placeholder="Id Peminjaman">
</div>
<div class="col-md-2">
<br>
	<h3 style="text-align: center;">ATAU</h3>
</div>
<div class="col-md-4">
	<label>Status Booking</label>
		<select class="form-control" name="status">
			<option value="">Semua</option>
			<option value="Booking">Booking</option>
			<option value="Selesai">Selesai</option>
		</select>
</div>

<div class="col-md-2">
<br>
	<input style="margin-top: 5px;" type="submit" class="btn btn-success" name="tampilkan" value="Tampilkan">
	</form>
</div>
		<?php
}
?>
</div>



<?php include "footer.php"; ?>