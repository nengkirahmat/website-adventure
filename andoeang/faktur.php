<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Andoeang Adventure | Faktur Pembayaran</title>
	<style>
		body{
			font-size: 18px;
		}
	</style>
</head>
<body onload="window.print();">

<?php
if (!empty($_GET['id_pinjam'])){
	$id_pinjam=$_GET['id_pinjam'];
	$query=$con->prepare("select tbl_pinjam.id_pinjam,tbl_user.username,tbl_pinjam.tgl_mulai,tbl_pinjam.tgl_akhir,tbl_pinjam.jml_hari,tbl_pinjam.total_biaya,tbl_pinjam.jml_bayar,tbl_pinjam.status from tbl_pinjam,tbl_user where tbl_pinjam.id_user=tbl_user.id_user and tbl_pinjam.id_pinjam=:id_pinjam");
	$query->BindParam(":id_pinjam",$id_pinjam);
	$query->execute();
	$query=$query->fetch();
	?>
	<table cellpadding="5" align="center" border="1">
		<thead>
			<tr>
				<th colspan="2">Andoeang Adventure<br>Faktur Pembayaran Booking Alat</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="180">Id Pinjam</td><td width="180"><?php echo $query['id_pinjam']; ?></td>
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
				<td>Total Biaya</td><td>Rp.<?php echo number_format($query['total_biaya'],0,".","."); ?></td>
			</tr>
			<tr>
				<td>Telah Dibayar</td><td>Rp.<?php echo number_format($query['jml_bayar'],0,".","."); ?></td>
			</tr>
			<tr>
				<td>Sisa Pembayaran</td><td>Rp.<?php $sisa=$query['total_biaya']-$query['jml_bayar']; echo number_format($sisa,0,".","."); ?></td>
			</tr>
			<tr>
				<td>Status</td><td><?php echo $query['status']; ?></td>
			</tr>
			<tr>
				<td colspan="2" style="font-size: 14px;">
					<h5 style="margin: 0;">CS Andoeang Adventure</h5>
HP/WA: 0857-5299-6363 / 085331996483<br>
<h5 style="margin: 0;">Rekening Pembayaran Via Transfer</h5>
Nama Rekening : Rudi Harianto<br>
No Rekening : 0091010198754565 (BRI)
<h5 style="margin: 0;">Alamat Kami</h5>Jl. Simpang Rumah Gadang No.002 Jorong III Suku Nagari Canduang Koto Laweh, Kecamatan Canduang, Kabupaten Agam, Provinsi Sumatera Barat
				</td>
			</tr>
		</tbody>
	</table>
<br>
	<table align="center" border="1" cellpadding="5px;">
		<thead>
		<tr>
			<th colspan="2">Keranjang Alat</th>
		</tr>
		<tr>
			<th>Nama Alat</th><th>Jumlah</th>
		</tr>
		</thead>
		<tbody>
			<?php
			$id_pinjam=$_GET['id_pinjam'];
		$query=$con->prepare("select tbl_keranjang.id_pinjam,tbl_keranjang.id_keranjang,tbl_alat.nama_alat,tbl_alat.biaya_sewa,tbl_alat.stock,tbl_alat.foto,tbl_keranjang.id_alat,tbl_keranjang.jml_sewa,tbl_keranjang.status from tbl_alat,tbl_keranjang where tbl_keranjang.id_alat=tbl_alat.id_alat and tbl_keranjang.status<>'Menunggu' and tbl_keranjang.id_pinjam='$id_pinjam' order by tbl_keranjang.id_keranjang desc");
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td width="180px"><?php echo $res['nama_alat']; ?></td><td width="180px" align="center"><?php echo $res['jml_sewa']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php
}

?>
</body>
</html>