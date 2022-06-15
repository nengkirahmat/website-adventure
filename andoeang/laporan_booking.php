<?php 
include "koneksi.php";
include "head.php";
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    	<div class="x_panel">
          
           


<div class="col-md-12">
	<?php
if (isset($_POST['tampil'])){
	if (!empty($_POST['tgl_mulai']) and !empty($_POST['tgl_akhir']) and empty($_POST['status_bayar'])){
	$tgl_mulai=str_replace('/', '-', $_POST['tgl_mulai']);
	$tgl_akhir=str_replace('/', '-', $_POST['tgl_akhir']);
	$query=$con->prepare("select * from tbl_pinjam,tbl_user where tbl_user.id_user=tbl_pinjam.id_user and (tbl_pinjam.date between '$tgl_mulai' and '$tgl_akhir')");
	$query->execute();
	$res=$query->fetchAll();
	$sum=$con->prepare("select sum(total_biaya) as total_biaya,sum(jml_bayar) as jml_bayar from tbl_pinjam where (date between '$tgl_mulai' and '$tgl_akhir')");
	$sum->execute();
	$sum=$sum->fetch();
	
	}else if (!empty($_POST['tgl_mulai']) and !empty($_POST['tgl_akhir']) and !empty($_POST['status_bayar'])){
		$tgl_mulai=str_replace('/', '-', $_POST['tgl_mulai']);
	$tgl_akhir=str_replace('/', '-', $_POST['tgl_akhir']);
	$status_bayar=$_POST['status_bayar'];
	$query=$con->prepare("select * from tbl_pinjam,tbl_user where tbl_user.id_user=tbl_pinjam.id_user and (tbl_pinjam.date between '$tgl_mulai' and '$tgl_akhir') and tbl_pinjam.status='$status_bayar'");
	$query->execute();
	$res=$query->fetchAll();
	$sum=$con->prepare("select sum(total_biaya) as total_biaya,sum(jml_bayar) as jml_bayar from tbl_pinjam where (date between '$tgl_mulai' and '$tgl_akhir')  and status='$status_bayar'");
	$sum->execute();
	$sum=$sum->fetch();
	}else if(empty($_POST['tgl_mulai']) and empty($_POST['tgl_akhir']) and !empty($_POST['status_bayar'])){
		$status_bayar=$_POST['status_bayar'];
		$query=$con->prepare("select * from tbl_pinjam,tbl_user where tbl_user.id_user=tbl_pinjam.id_user and tbl_pinjam.status='$status_bayar' order by tbl_pinjam.id_pinjam desc");
		$query->execute();
		$res=$query->fetchAll();
		$sum=$con->prepare("select sum(total_biaya) as total_biaya,sum(jml_bayar) as jml_bayar from tbl_pinjam where status='$status_bayar'");
	$sum->execute();
	$sum=$sum->fetch();
	} 
	else{
		$query=$con->prepare("select * from tbl_pinjam,tbl_user where tbl_user.id_user=tbl_pinjam.id_user order by tbl_pinjam.id_pinjam desc");
		$query->execute();
		$res=$query->fetchAll();
		$sum=$con->prepare("select sum(total_biaya) as total_biaya,sum(jml_bayar) as jml_bayar from tbl_pinjam");
	$sum->execute();
	$sum=$sum->fetch();
	}

?>
<script>window.print();</script>	
	<div class="x_title">
    <center>
<h1>Andoeang Adventure</h1>
<h3>Laporan Booking</h3>
<?php if (!empty($tgl_mulai) and !empty($tgl_akhir) and !empty($status_bayar)){ echo "<h4>Tanggal : ".$tgl_mulai." - ".$tgl_akhir." || Status Bayar : ".$status_bayar."</h4>"; }else if (!empty($tgl_mulai) and !empty($tgl_akhir) and empty($status_bayar)){ echo "<h4>Tanggal : ".$tgl_mulai." - ".$tgl_akhir." || Status Bayar : Semua Data</h4>"; } ?>
<i>Alamat : Canduang, Telpon : 08123456789, Fax : 454545, Kode Pos : 4544656</i>
</center>
<hr style="margin-top: 10px; margin-bottom: 0;">
<hr style="margin-top: 0; margin-bottom: 10px;">	
    </div>
<div class="col-md-12">
<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>Id Pinjam</th>
		<th>Username</th>
		<th>Tgl Mulai</th>
		<th>Tgl Akhir</th>
		<th>Total Hari</th>
		<th>Total Biaya</th>
		<th>Telah Dibayar</th>
		<th>Status</th>
		<th>Tanggal</th>
	</tr>
	</thead>
	<tbody>
<?php
$rc=0;
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_pinjam']; ?></td>
				<td align="center"><?php echo $res['username']; ?></td>
				<td align="center"><?php echo $res['tgl_mulai']; ?></td>
				<td align="center"><?php echo $res['tgl_akhir']; ?></td>
				<td align="center"><?php echo $res['jml_hari']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['total_biaya'],0,".","."); ?></td>
				<td align="right">Rp.<?php echo number_format($res['jml_bayar'],0,".","."); ?></td>
				<td align="center"><?php echo $res['status']; ?></td>
				<td align="center"><?php echo $res['date']; ?></td>
				
			</tr>
			<?php
	$rc+=1;	}
		?>
	</tbody>
</table>
<h3>Total Biaya : Rp.<?php echo number_format($sum['total_biaya'],0,".","."); ?></h3>
<h3>Total Jumlah Bayar : Rp.<?php echo number_format($sum['jml_bayar'],0,".","."); ?></h3>
</div>
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
 <div class="x_content">
            <div class="col-md-3">
    		<form action="#" method="POST">
    			<div class="form-group">
					<label>Dari Tanggal</label>
					<div class="input-group date" id="tgl1">
						<input type="date" name="tgl_mulai" class="form-control"/>	
							<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
				<div class="form-group">
					<label>Sampai Tanggal</label>
					<div class="input-group date" id="tgl2">
						<input type="date" name="tgl_akhir" class="form-control" />	
							<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
    		</div>

    		<div class="col-md-3">
    				<label>Status Bayar</label><br>
    				<select class="form-control" name="status_bayar">
    					<option value="">Tampilkan Semua</option>
    					<option value="Lunas">Lunas</option>
    					<option value="Belum Lunas">Belum Lunas</option>
    				</select><br>
    			
    		</div>

    		<div class="col-md-3">
    		<br>
    			<input type="submit" class="btn btn-success" name="tampil" value="Tampilkan">
    			</div>
    		</div>  
		<?php
	}
?>
</div>

    		

            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
