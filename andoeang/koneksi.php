<?php
session_start();
	try {
		$con=new PDO("mysql:host=localhost; dbname=andoeang", "root", "" );
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		$e->getMessage();
	}
?>