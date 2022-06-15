<?php
if (isset($_POST['update_keranjang'])){
	include "koneksi.php";
	$id_keranjang=$_POST['id_keranjang'];
	$jumlah=$_POST['jumlah'];
	if ($jumlah<=0){
		$query=$con->prepare("select * from tbl_keranjang where id_keranjang='$id_keranjang'");
		$query->execute();
		$res=$query->fetch();
		$id_alat=$res['id_alat'];
		
		$cek_alat=$con->prepare("select * from tbl_alat where id_alat='$id_alat'");
		$cek_alat->execute();
		$res_alat=$cek_alat->fetch();
		$stock=$res['jml_sewa']+$res_alat['stock'];

		$query=$con->prepare("delete from tbl_keranjang where id_keranjang='$id_keranjang'");
		$query->execute();

		$query=$con->prepare("update tbl_alat set stock='$stock' where id_alat='$id_alat'");
		$query->execute();
		$_SESSION['info']="Sebuah alat telah dihapus dari keranjang";
		header('location:keranjang.php');
	}else{
		$query=$con->prepare("select * from tbl_keranjang where id_keranjang='$id_keranjang'");
		$query->execute();
		$res=$query->fetch();
		$id_alat=$res['id_alat'];
		$tersedia=0;
		$cek_alat=$con->prepare("select * from tbl_alat where id_alat='$id_alat'");
			$cek_alat->execute();
			$res_alat=$cek_alat->fetch();
			$tersedia=$res['jml_sewa']+$res_alat['stock'];
			if ($tersedia<$jumlah){
				$_SESSION['info']="Stock tidak cukup";
				header('location:keranjang.php');
			}else{
			$query=$con->prepare("update tbl_keranjang set jml_sewa='$jumlah' where id_keranjang='$id_keranjang'");
			$query->execute();
			$stk=$tersedia-$jumlah;
			$query=$con->prepare("update tbl_alat set stock='$stk' where id_alat='$id_alat'");
			$query->execute();
			$_SESSION['info']="Jumlah Sewa Diperbaharui menjadi ".$jumlah;
			header('location:keranjang.php');
			}
}
}

if (!empty($_GET['kurang'])){
	$id_keranjang=$_GET['kurang'];
	$query=$con->prepare("select * from tbl_keranjang where id_keranjang='$id_keranjang'");
		$query->execute();
		$res=$query->fetch();
		$id_alat=$res['id_alat'];
		if ($res['jml_sewa']<=1){
		$cek_alat=$con->prepare("select * from tbl_alat where id_alat='$id_alat'");
		$cek_alat->execute();
		$res_alat=$cek_alat->fetch();
		$stock=$res['jml_sewa']+$res_alat['stock'];

		$query=$con->prepare("delete from tbl_keranjang where id_keranjang='$id_keranjang'");
		$query->execute();

		$query=$con->prepare("update tbl_alat set stock='$stock' where id_alat='$id_alat'");
		$query->execute();
		$_SESSION['info']="Telah Dihapus";
		header('location:keranjang.php');
		}else{
		$cek_alat=$con->prepare("select * from tbl_alat where id_alat='$id_alat'");
		$cek_alat->execute();
		$res_alat=$cek_alat->fetch();
		$stock=$res_alat['stock']+1;
		$jml_sewa=$res['jml_sewa']-1;

		$query=$con->prepare("update tbl_keranjang set jml_sewa='$jml_sewa' where id_keranjang='$id_keranjang'");
		$query->execute();

		$query=$con->prepare("update tbl_alat set stock='$stock' where id_alat='$id_alat'");
		$query->execute();
		$_SESSION['info']="Dikurang 1";
		header('location:keranjang.php');
		}
}


if (!empty($_GET['cart_plus'])){
	if (empty($_SESSION['id_user'])){
		$_SESSION['info']="Silahkan Login...!!!";
	header('location:index.php?id=login');
}else{
		$id_user=$_SESSION['id_user'];
		$id_alat=$_GET['cart_plus'];
		$query=$con->prepare("select * from tbl_keranjang where id_alat='$id_alat' and id_user='$id_user' and status='Menunggu'");
		$query->execute();
		$query=$query->fetch();
		if ($query['id_alat']==$_GET['cart_plus']){
			$cek_alat=$con->prepare("select * from tbl_alat where id_alat='$id_alat'");
			$cek_alat->execute();
			$res_alat=$cek_alat->fetch();
			$stk=$res_alat['stock'];
			if ($res_alat['stock']<=0){
				$_SESSION['info']="Stock tidak cukup";
			}else{
			$jml=$query['jml_sewa']+=1;
			$stk=$stk-=1;
			$query=$con->prepare("update tbl_keranjang set jml_sewa='$jml' where id_alat='$id_alat' and id_user='$id_user' and status='Menunggu'");
			$query->execute();
			$query=$con->prepare("update tbl_alat set stock='$stk' where id_alat='$id_alat'");
			$query->execute();
			$_SESSION['info']="Ditambahkan 1";
			header('location:keranjang.php');
			}
		}
		else
		{
			$cek_alat=$con->prepare("select * from tbl_alat where id_alat='$id_alat'");
			$cek_alat->execute();
			$res_alat=$cek_alat->fetch();
			$stk=$res_alat['stock'];
			if ($res_alat['stock']<=0){
				$_SESSION['info']="Stock tidak cukup";
			}
			else{
			$stk=$stk-=1;
			$biaya=$res_alat['biaya_sewa'];
			$id_user=$_SESSION['id_user'];
			$query=$con->prepare("insert into tbl_keranjang values ('','','$id_alat','$biaya','1','$id_user','Menunggu')");
			$query->execute();
			$query=$con->prepare("update tbl_alat set stock='$stk' where id_alat='$id_alat'");
			$query->execute();
			$_SESSION['info']="Berhasil Ditambahkan";
			header('location:keranjang.php');
			}
		}
}
}

?>