<?php
include "koneksi.php";
include "head.php";

if (!empty($_GET['hapus_user'])){
	$id_user=$_GET['hapus_user'];
	$query=$con->prepare("delete from tbl_user where id_user=:id_user");
	$query->BindParam(":id_user",$id_user);
	$query->execute();
	
}
?>
<script>window.print();</script>
<div class="x_title">
<center>
<h1>Andoeang Adventure</h1>
<h3>Laporan Data User</h3>
<i>Alamat : Canduang, Telpon : 08123456789, Fax : 454545, Kode Pos : 4544656</i>
</center>
<hr style="margin-top: 10px; margin-bottom: 0;">
<hr style="margin-top: 0; margin-bottom: 10px;">
<div class="clearfix"></div>
</div>
<script>
	document.getElementById('title1').innerHTML="Laporan Data Pengguna";
	document.getElementById('title2').innerHTML="Laporan Data Pengguna";
</script>
<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
		<th>Id User</th>
		<th>Nama Lengkap</th>
		<th>Telpon / HP</th>
		<th>Alamat Lengkap</th>
		<th>Email</th>
		<th>Username</th>
		<th>Level</th>
		<th>Tanggal Gabung</th>
		<!-- <th>Aksi</th> -->
	</thead>
	<tbody>
		<?php
		$rc=0;
		$query=$con->prepare("select * from tbl_user where level<>'admin' order by username asc");
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_user']; ?></td>
				<td><?php echo $res['nama_lengkap']; ?></td>
				<td align="center"><?php echo $res['hp']; ?></td>
				<td><?php echo $res['alamat']; ?></td>
				<td><?php echo $res['email']; ?></td>
				<td><?php echo $res['username']; ?></td>
				<td align="center"><?php echo $res['level']; ?></td>
				<td align="center"><?php echo $res['date_join']; ?></td>
				<!--<td align="center">
				<a class="btn btn-danger" href="?hapus_user=<?php echo $res['id_user']; ?>">Hapus</a>
				</td>
				-->
			</tr>
			<?php
		$rc+=1; }
		?>
	</tbody>
</table>
<div style="float:left; margin-left: 30px;"><br>
	Total User : <?php echo $rc; ?>
</div>
<div style="float: right; margin-right: 50px;">
<br><br>
	Canduang,<?php echo date('d-M-Y'); ?>
	<br><br><br><br>
	<center><?php echo strtoupper($_SESSION['username']); ?></center>
</div>
<?php
include "footer.php";
?>