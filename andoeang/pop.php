<html>
<head>
<title>Membuat Pop-Up Window</title>
<script language="javascript">
function buka_popup(){
 window.open('popup2.php', '', 'width=640, height=480, menubar=no,location=yes,scrollbars=yes, resizeable=yes, status=yes, copyhistory=no,toolbar=no');
 window.print();
}
</script>
<body onLoad="buka_popup();">
<p>Anda juga dapat membuka window popupnya dari sini</p>
<a href="javascript: buka_popup();">KLIK DISINI</a>
</body>
</html>