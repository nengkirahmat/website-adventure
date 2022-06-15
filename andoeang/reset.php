<?php
include "koneksi.php";
require 'phpmailer/PHPMailerAutoload.php';

function kirim_pesan($email, $subject, $pesan)
{
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->Host = "smtp.gmail.com"; //smtp gmail
	$mail->From = "itmelankolis@gmail.com"; //alamat email asal
	$mail->Port = 587; //tcp post 
	$mail->AddAddress($email); //alamat email penerima
	$mail->Username = "andoeangadventure"; //username atau email smtp yang anda miliki
	$mail->Password = "andoeang12"; // password smtp yang anda miliki
	$mail->SetFrom('andoeangadventure@gmail.com', 'Andoeang Adventure');
	$mail->AddReplyTo('andoeangadventure@gmail.com', 'Andoeang Adventure');
	$mail->Subject = $subject; //subjek email anda
	$mail->Body = $pesan; //isi pesan email anda
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);
	$mail->isHTML(true);
	if ($mail->Send()){
		echo "<h3>Kami telah mengirimkan password ke email anda. .</h3>";
	}else{
		echo "<h3>Gagal mengirim password ke email anda</h3>";
	}
}


if (isset($_POST['reset'])) {
	$email   = $_POST['email'];
	$subject = "Reset Password || Andoeang Adventure";
	$query=$con->prepare("select * from tbl_user where email=:email");
	$query->BindParam(":email",$email);
	$query->execute();
	$rc=$query->rowCount();
	if ($rc>0){
	$q=$query->fetch();
	$password=$q['password'];
	$pesan   = "Anda menggunakan fitur Lupa Password<br>Password anda adalah : <b>".$password."</b><br>Terima Kasih";
	kirim_pesan($email, $subject, $pesan);
	}else{
	echo "<h3>email tidak terdaftar</h3>";
}
}
if (!empty($_GET['reset']) and $_GET['reset']=="true"){

	?>
	<form action="#" method="POST">
		<label>Masukkan Alamat Email</label>
		<input type="email" name="email" required="" class="form-control">
		<input type="submit" name="reset" value="Reset" class="btn-success">
	</form>
	<?php
}
?>