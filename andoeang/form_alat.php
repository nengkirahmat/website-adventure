<?php
include "koneksi.php";

//Simpan data alat
if (isset($_POST['simpan'])){
	$nama_alat=$_POST['nama_alat'];
	$biaya_sewa=$_POST['biaya_sewa'];
	$satuan=$_POST['satuan'];
	$stock=$_POST['stock'];
	$foto=$_FILES['foto']['name'];
	$folder="gambar/";
	$folder=$folder.basename($_FILES['foto']['name']);
	$cek_alat=$con->prepare("select * from tbl_alat where nama_alat=:nama_alat");
        $cek_alat->BindParam(":nama_alat",$nama_alat);
        $cek_alat->execute();
        $res=$cek_alat->rowCount();
        if ($res>0){
            $_SESSION['info']="Gagal Disimpan, Nama Alat Sudah Ada...!!!";
        }else{
			if (move_uploaded_file($_FILES['foto']['tmp_name'],$folder)){
				$query=$con->prepare("insert into tbl_alat values ('',:nama_alat,:biaya_sewa,:satuan,:stock,:foto)");
				$query->BindParam(":nama_alat",$nama_alat);
				$query->BindParam(":biaya_sewa",$biaya_sewa);
				$query->BindParam(":satuan",$satuan);
				$query->BindParam(":stock",$stock);
				$query->BindParam(":foto",$foto);
				$query->execute();
				$_SESSION['info']="Alat baru telah ditambahkan...!!!";
			}
		}
}

//Hapus data alat
if (!empty($_GET['hapus'])){
	$id_alat=$_GET['hapus'];
	$query=$con->prepare("delete from tbl_alat where id_alat=:id_alat");
	$query->BindParam(":id_alat",$id_alat);
	$query->execute();
	$_SESSION['info']="1 Alah telah dihapus...!!!";
}

if (isset($_POST['update_stock'])){
	$id_alat=$_POST['id_alat'];
	$stock=$_POST['stock'];
	$tambah=$_POST['tambah'];
	$total=$stock+$tambah;
	$query=$con->prepare("update tbl_alat set stock=:stock where id_alat=:id_alat");
	$query->BindParam(":stock",$total);
	$query->BindParam(":id_alat",$id_alat);
	$query->execute();
	$_SESSION['info']="Stock alat menjadi ".$total." ...!!!";
}

include "head.php";
?>
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 id="title2">Plain Page</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
<?php


if (!empty($_GET['add_stock'])){
	$id_alat=$_GET['add_stock'];
	$query=$con->prepare("select * from tbl_alat where id_alat=:id_alat");
	$query->BindParam(":id_alat",$id_alat);
	$query->execute();
	$res=$query->fetch();


?>

   <div class="col-md-3"></div><div class="col-md-6">

<script>
	document.getElementById('title1').innerHTML="Tambah Stock";
	document.getElementById('title2').innerHTML="Tambah Stock";
</script>
	<form action="#" method="POST">
		Id Alat<br>
		<input type="text" name="id_alat" class="form-control" readonly="" value="<?php echo $res['id_alat']; ?>"><br>
		Nama Alat<br>
		<input type="text" name="nama_alat" class="form-control" readonly="" value="<?php echo $res['nama_alat']; ?>"><br>
		Stock<br>
		<input type="text" name="stock" class="form-control" readonly="" value="<?php echo $res['stock']; ?>"><br>
		Masukkan Jumlah Tambah<br>
		<input type="number" class="form-control" required="" name="tambah"><br>
		<input type="submit" class="btn btn-success" name="update_stock" value="Update Stock">
	</form>
	<?php
}
else{
?>
<script>
	document.getElementById('title1').innerHTML="Input Alat";
	document.getElementById('title2').innerHTML="Input Alat";
</script>
<form action="#" method="POST" enctype="multipart/form-data">
	Nama Alat<br>
	<input type="text" class="form-control" required="" name="nama_alat"><br>
	Harga Sewa<br>
	<input type="text" class="form-control" required="" name="biaya_sewa"><br>
	Satuan<br>
	<select class="form-control" required="" name="satuan">
		<option value="">Pilih Satuan</option>
		<option value="Set">Set</option>
		<option value="Unit">Unit</option>
		<option value="Dus">Dus</option>
		<option value="Meter">Meter</option>
	</select><br>
	Stock<br>
	<input type="number" class="form-control" required="" name="stock"><br>
	Foto Alat<br>
	<input type="file" name="foto"><br>
	<input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
	<input type="reset" class="btn btn-danger">
</form>

<?php } ?>

					</div>
					
					<div class="col-md-3"></div>
					<div class="col-md-12">
	<div class="x_title">
                    <h2>Data Alat</h2>
                    <div class="clearfix"></div>
                  </div>
	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
		<th>Id Alat</th>
		<th>Nama Alat</th>
		<th>Biaya Sewa</th>
		<th>Satuan</th>
		<th>Stock</th>
		<th>Foto Alat</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		<?php
		$query=$con->prepare("select * from tbl_alat order by id_alat desc");
		$query->execute();
		$res=$query->fetchAll();
		foreach ($res as $res) {
			?>
			<tr>
				<td align="center"><?php echo $res['id_alat']; ?></td>
				<td><?php echo $res['nama_alat']; ?></td>
				<td align="right">Rp.<?php echo number_format($res['biaya_sewa'],0,".","."); ?></td>
				<td align="center"><?php echo $res['satuan']; ?></td>
				<td align="center"><?php echo $res['stock']; ?></td>
				<td align="center"><img style="width: 80px; height: 60px;" src="gambar/<?php echo $res['foto']; ?>"></td>
				<td align="center"><a class="btn btn-danger btn-xs" href="?hapus=<?php echo $res['id_alat']; ?>">Hapus</a> <a class="btn btn-primary btn-xs" href="?add_stock=<?php echo $res['id_alat']; ?>">Add Stock</a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
					</div>
					</div>
                </div>
              </div>
            </div>
<?php
include "footer.php";
?>
