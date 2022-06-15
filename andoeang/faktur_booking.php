<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Andoeang Adventure | Faktur Booking Alat Camping</title>
	<style>
		body{
			font-size: 20px;
		}
	</style>
</head>
<body onload="window.print();">
<?php
if (!empty($_GET['id_pinjam'])){
	$id_user=$_GET['id_user'];
	$query=$con->prepare("select tbl_pinjam.id_pinjam,tbl_user.username,tbl_pinjam.tgl_mulai,tbl_pinjam.tgl_akhir,tbl_pinjam.jml_hari,tbl_pinjam.total_biaya,tbl_pinjam.jml_bayar,tbl_pinjam.status from tbl_pinjam,tbl_user where tbl_pinjam.id_user=tbl_user.id_user and tbl_pinjam.id_user=:id_user");
	$query->BindParam(":id_user",$id_user);
	$query->execute();
	$query=$query->fetch();
	?>
	<table cellpadding="10" align="center" border="1">
		<thead>
			<tr>
				<th colspan="2">Faktur Pembayaran Booking Alat</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="200">Id Pinjam</td><td width="200"><?php echo $query['id_pinjam']; ?></td>
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
		</tbody>
	</table>
	<?php
}

?>
</body>
</html>