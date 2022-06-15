<?php 
include "koneksi.php";
include "head.php";
?>
<script>window.print();</script>
<div class="x_title">
<center>
<h1>Andoeang Adventure</h1>
<h3>Laporan Pengembalian Alat</h3>
<i>Alamat : Canduang, Telpon : 08123456789, Fax : 454545, Kode Pos : 4544656</i>
</center>
<hr style="margin-top: 10px; margin-bottom: 0;">
<hr style="margin-top: 0; margin-bottom: 10px;">		
                    <div class="clearfix"></div>
                  	</div>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>Id Pengembalian</th>
		<th>Id Pinjam</th>
		<th>Id Keranjang</th>
		<th>Nama Alat</th>
		<th>Jumlah Sewa</th>
		<th>Jumlah Kembali</th>
		<th>Tanggal / Waktu Kembali</th>
	</tr>
	</thead>
	<tbody>
		<?php
		$rc=0;
		$query=$con->prepare("select tbl_keranjang.id_pinjam,tbl_alat.nama_alat,tbl_keranjang.id_keranjang,tbl_kembali.id_kembali,tbl_kembali.jml_sewa,tbl_kembali.jml_kembali,tbl_kembali.date from tbl_kembali,tbl_keranjang,tbl_alat where tbl_kembali.id_keranjang=tbl_keranjang.id_keranjang and tbl_alat.id_alat=tbl_keranjang.id_alat order by date desc");
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_kembali']; ?></td>
				<td align="center"><?php echo $res['id_pinjam']; ?></td>
				<td align="center"><?php echo $res['id_keranjang']; ?></td>
				<td><?php echo $res['nama_alat']; ?></td>
				<td align="center"><?php echo $res['jml_sewa']; ?></td>
				<td align="center"><?php echo $res['jml_kembali']; ?></td>
				<td align="center"><?php echo $res['date']; ?></td>
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
<?php include "footer.php"; ?>