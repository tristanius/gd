<?php 
#header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
#header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=".$informe."-".date("d-m-Y").".xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<?php echo $html; ?>
</body>
</html>
