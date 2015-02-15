<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/test/common/config.inc.php');
ob_start();
?>
<!DOCTYPE html>

<html>
<head >
<meta charset="utf-8"/>
<title>welcome</title>
<link href="<?php echo "//".BASE_URL."style/basic.css"?>" rel="stylesheet" >
<script src="<?php echo "//".BASE_URL."scripts/jquery-1.11.2.min.js"?>"> </script>

</head>
<body>


<header>
<?php require_once (BASE_URI.'views/header.html') ; ?>

</header>





<div id="main" >
<?php require_once (BASE_URI.'route.php') ;

?>
</div>


</body>
</html>

<?php ob_end_flush();?>