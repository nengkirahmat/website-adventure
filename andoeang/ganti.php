<?php include "koneksi.php"; 

if (isset($_POST['ganti'])){
	$id_user=$_POST['id_user'];
	$password_lama=$_POST['password_lama'];
	$password_baru=$_POST['password_baru'];
	$ulangi_password=$_POST['ulangi_password'];
	$query=$con->prepare("select * from tbl_user where id_user=:id_user");
	$query->BindParam(":id_user",$id_user);
	$query->execute();
	$query=$query->fetch();
	if ($query['password']==$password_lama){
		if ($password_baru==$ulangi_password){
			$query=$con->prepare("update tbl_user set password=:password where id_user=:id_user");
			$query->BindParam(":password",$password_baru);
			$query->BindParam(":id_user",$id_user);
			$query->execute();
			$_SESSION['info']="Berhasil Mengganti Password";
		}else{
			$_SESSION['info']="Password Tidak Sama";
		}
	}else{
		$_SESSION['info']="Password Salah";
	}
}

include "head.php";


if (!empty($_GET['ganti']) and !empty($_SESSION['id_user'])){ ?>
<h3 class="page-header">Ganti Password Akun</h3>
<form action="#" method="POST">
	<input type="hidden" name="id_user" value="<?php echo $_GET['ganti']; ?>">
	<label>Password Lama</label>
	<input class="form-control" type="password" name="password_lama"><br>
	<label>Password Baru</label>
	<input class="form-control" type="password" name="password_baru"><br>
	<label>Ulangi Password Baru</label>
	<input class="form-control" type="password" name="ulangi_password"><br>
	<input class="btn-success btn-sm" type="submit" name="ganti" value="Ganti">
</form>
<?php } 
include "footer.php";
?>
