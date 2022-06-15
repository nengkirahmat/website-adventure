<?php
include "koneksi.php";
if (!empty($_GET['id']) and $_GET['id']=="daftar"){
	if (isset($_POST['daftar'])){
		$username=$_POST['username'];
		$password=$_POST['password'];
		$repassword=$_POST['repassword'];
		$hp=$_POST['hp'];
		$level="user";
		$date_join=date('Y-m-d h:i:s');
		$cek_user=$con->prepare("select * from tbl_user where username=:username");
		$cek_user->BindParam(":username",$username);
		$cek_user->execute();
		$res=$cek_user->rowCount();
		if ($res>0){
			echo "Username telah digunakan...!!!";
		}else
		if ($password<>$repassword){
			echo "Kombinasi password tidak valid...!!!";
		}
		else
		{
			$query=$con->prepare("insert into tbl_user values('',:username,:password,:hp,:level,:date_join)");
			$query->BindParam(":username",$username);
			$query->BindParam(":password",$password);
			$query->BindParam(":hp",$hp);
			$query->BindParam(":level",$level);
			$query->BindParam(":date_join",$date_join);
			$query->execute();
			echo "Pendaftaran sukses, silahkan login...!!!";
		}
	}
?>

	<form action="#" method="POST">
		Username<br>
		<input type="text" name="username"><br>
		Password<br>
		<input type="password" name="password"><br>
		Ulangi Password<br>
		<input type="password" name="repassword"><br>
		Nomor HP<br>
		<input type="text" name="hp"><br>
		<input type="submit" name="daftar" value="Daftar"> <input type="reset" name="" value="Batal"> 
	</form>

<?php
}


if (!empty($_GET['id']) and $_GET['id']=="login"){
	if (isset($_POST['login'])){
		$username=$_POST['username'];
		$password=$_POST['password'];
		$query=$con->prepare("select * from tbl_user where username=:username and password=:password");
		$query->BindParam(":username",$username);
		$query->BindParam(":password",$password);
		$query->execute();
		$qu=$query->rowCount();
		if ($qu>0){
			$query=$query->fetch();
			$_SESSION['id_user']=$query['id_user'];
			$_SESSION['username']=$query['username'];
			$_SESSION['level']=$query['level'];
			header('location:index.php');
		}
		else{
			echo "Login gagal, Username dan Password tidak valid...!!!";
		}
	}
	?>
	<form action="#" method="POST">
		Username<br>
		<input type="text" name="username"><br>
		Password<br>
		<input type="password" name="password"><br>
		<input type="submit" name="login" value="Login"> <input type="reset" name="" value="Batal">
	</form>
	<?php
}

if (!empty($_GET['id']) and $_GET['id']=="keluar"){
	session_destroy();
	header('location:index.php');
}
?>
